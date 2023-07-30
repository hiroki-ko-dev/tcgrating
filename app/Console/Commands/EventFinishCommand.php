<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Enums\EventStatus;
use App\Services\EventService;
use App\Services\DuelService;
use Carbon\Carbon;

final class EventFinishCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:eventFinishCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'ステータスが終了になっていないレート戦を終了';

    public function __construct(
        private readonly EventService $eventService,
        private readonly DuelService $duelService
    ) {
        parent::__construct();
    }

    public function handle(): void
    {
        try {
            $eventFilters['statuses'] = [EventStatus::RECRUIT->value, EventStatus::READY->value];
            $eventFilters['event_category_id'] = \App\Models\EventCategory::CATEGORY_SINGLE;
            $eventFilters['end_date'] = Carbon::today()->subDay(3);
            $events = $this->eventService->getEvents($eventFilters);
            foreach ($events as $event) {
                if ($event->status == EventStatus::RECRUIT->value) {
                    $eventNextStatus = EventStatus::CANCEL->value;
                    $duelNextStatus = \App\Models\Duel::STATUS_CANCEL;
                } elseif ($event->status == EventStatus::READY->value) {
                    $eventNextStatus = EventStatus::FINISH->value;
                    $duelNextStatus = \App\Models\Duel::STATUS_FINISH;
                } else {
                    throw new \Exception("想定外のステータス");
                }
                $this->eventService->updateEventStatus($event->id, $eventNextStatus);
                $this->duelService->updateDuelStatus($event->eventDuels[0]->duel_id, $duelNextStatus);
            }
        } catch (\Exception $e) {
            report($e);
            dd($e);
        }
    }
}
