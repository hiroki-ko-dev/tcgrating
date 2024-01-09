<?php

declare(strict_types=1);

namespace App\Services\Twitter;

use Illuminate\Support\Collection;
use App\Models\Deck;

final class TwitterOfficialEventService extends TwitterService
{
    public function tweetResult(Collection $officialEvents): void
    {
        if (config('assets.common.appEnv') == 'production') {
            foreach ($officialEvents as $officialEvent) {
                $officialEvent->decks = $officialEvent->decks->sortBy('rank');
                $decks = '';
                $replyDecks = '';
                $images = [];
                $replyImages = [];
                foreach ($officialEvent->decks as $i => $deck) {
                    if ($deck->rank <= 3) {
                        $decks .= $deck->rank . '位 ' . $this->getDeckName($deck) . PHP_EOL;
                        $images[] = $this->saveDeckImage($officialEvent->id . '_' .$i . '.png', $deck);
                    } else {
                        $replyDecks .= $deck->rank . '位 ' . $this->getDeckName($deck) . PHP_EOL;
                        $replyImages[] = $this->saveDeckImage($officialEvent->id . '_' .$i . '.png', $deck);
                    }
                }

                $tweet =
                '【' . $officialEvent->date . '開催】' . PHP_EOL .
                $officialEvent->name . PHP_EOL .
                $officialEvent->organizer_name . PHP_EOL .
                PHP_EOL .
                $decks;

                // ツイートを投稿
                $apiKeys = config('assets.twitter.pokeka_info');
                $tweetId = $this->imagesTweet($apiKeys, $tweet, $images, null);
                $this->imagesTweet($apiKeys, $replyDecks, $replyImages, $tweetId);
            }
            $this->deleteTempDirectory();

            if ($officialEvents->isNotEmpty()) {
                // discord投稿
                $webHook = config('assets.discord.web_hook.blog');
                $content =
                    '以下の入賞デッキデータを追加いたしました。' . PHP_EOL .
                    PHP_EOL .
                    '【' . $officialEvents[0]->date . '開催分】' . PHP_EOL .
                    $officialEvents[0]->name . PHP_EOL .
                    PHP_EOL .
                    url('/decks');
                $this->discordPost($content, $webHook);
            }
        }
    }

    public function getDeckName(Deck $deck): string
    {
        $name = '';
        foreach ($deck->deckTags as $deckTag) {
            $name .= $deckTag->name;
        }
        return $name;
    }

    public function saveDeckImage(string $file_name, Deck $deck): string
    {
        // URLからファイル取得
        $img_downloaded = file_get_contents($deck->image_url);

        // 保存先のディレクトリパスを設定
        $directoryPath = public_path('images/temp/official_event');

        // ディレクトリが存在しない場合は作成
        if (!file_exists($directoryPath)) {
            mkdir($directoryPath, 0755, true);
        }

        // 保存先のファイルパスを設定
        $filePath = $directoryPath . '/' . $file_name;

        // 画像を直接publicディレクトリに保存
        file_put_contents($filePath, $img_downloaded);

        // 保存したファイルへのURLを返す
        return 'public/images/temp/official_event/' . $file_name;
    }

    public function deleteTempDirectory()
    {
        $directory = public_path('images/temp/official_event');

        // ディレクトリが存在するか確認
        if (file_exists($directory)) {
            // ディレクトリ内のすべてのファイルを取得
            $files = glob($directory . '/*');

            // 各ファイルを削除
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file); // ファイルを削除
                }
            }
            // 空のディレクトリを削除
            rmdir($directory);
        }
    }
}
