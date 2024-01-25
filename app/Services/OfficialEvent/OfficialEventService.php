<?php

declare(strict_types=1);

namespace App\Services\OfficialEvent;

use Illuminate\Support\Collection;
use App\Repositories\OfficialEvent\OfficialEventRepository;
use Google_Client;
use Google_Service_Sheets;

class OfficialEventService
{
    public function __construct(
        protected readonly OfficialEventRepository $officialEventRepository
    ) {
    }

    public function saveResult(): Collection
    {
        $sheetConfig = config('assets.google.spread_sheet.pokeka_official_event');

        // google spread sheetと接続するためのkey
        $credentials_path = storage_path('app/json/pokeka-official-event-key.json');
        // 接続の際のクライアントのインスタンスを作成
        $client = new Google_Client();
        // keyをセット
        $client->setAuthConfig($credentials_path);
        // spread sheetに接続することを宣言
        $client->setScopes([Google_Service_Sheets::SPREADSHEETS]);

        $range = '!A2:F1000';
        $sheet = new Google_Service_Sheets($client);

        $sheetName = 'getEventList';
        $eventList = $sheet->spreadsheets_values->get($sheetConfig['sheet_id'], $sheetName . $range)->getValues();
        $sheetName = 'getDeckList';
        $deckList = $sheet->spreadsheets_values->get($sheetConfig['sheet_id'], $sheetName . $range)->getValues();

        $officialEvents = [];
        foreach ($eventList as $eventRow) {
            if (!$eventRow[0]) {
                break;
            }
            if ($eventRow[1] < date('Y/m/d', strtotime('-10 day'))) {
                continue;
            }
            $attrs = null;
            $attrs['official_id'] = (int)$eventRow[0];
            $attrs['name'] = $eventRow[2];
            $attrs['organizer_name'] = $eventRow[3];
            $attrs['date'] = $eventRow[1];

            foreach ($deckList as $i => $deckRow) {
                if ((int)$deckRow[1] !== $attrs['official_id']) {
                    continue;
                }
                $attrs['decks'][$i]['code'] = $deckRow[0];
                $attrs['decks'][$i]['image_url'] = $deckRow[5];
                $attrs['decks'][$i]['rank'] = (int)$deckRow[2];
                $attrs['decks'][$i]['regulation_from'] = 'F';
                $attrs['decks'][$i]['regulation_to'] = 'H';
                foreach (explode(',', $deckRow[3]) as $j => $tag) {
                    $attrs['decks'][$i]['deckTags'][$j]['name'] = $tag;
                }
            }

            if (isset($attrs['decks'])) {
                $officialEvent = $this->officialEventRepository->create($attrs);
                if ($officialEvent) {
                    $officialEvents[] = $officialEvent;
                }
            }
        }

        return collect($officialEvents);
    }

    public function deleteOfficialEvent(array $officialEventIds): void
    {
        $this->officialEventRepository->deleteOfficialEvent($officialEventIds);
    }
}
