<?php

declare(strict_types=1);

namespace App\Services\Blogs;

use App\Models\Blog;
use Weidner\Goutte\GoutteFacade;

final class BlogsPriceRankService extends BlogsService
{
    public function createBlogsPriceRank(string $url)
    {
        $elements = [];

        $base = "https://osomatsusan.hatenablog.com/entry/";
        // ベースURLを取り除く
        $packName = str_replace($base, '', $url);
        $directoryName = date('Y-m-d') . '_' . $packName;

        // カードラッシュからのスクレイピング
        $goutte = GoutteFacade::request('GET', $url);
        $goutte->filter('.figure-image')->each(function ($node) use (&$elements, $directoryName) {
            $imageUrl = $node->filter('img')->attr('src'); // 画像のURL
            $imageTitle = $node->filter('figcaption')->text(); // 画像のタイトル

            // メルカリ価格を取得
            $mercariPrice = null;
            $node->nextAll('ul')->first()->filter('li')->each(function ($li) use (&$mercariPrice) {
                $text = $li->text();
                if (strpos($text, 'メルカリ等') !== false && preg_match('/(\d+,\d+|\d+)円/', $text, $matches)) {
                    $price = str_replace(',', '', $matches[1]); // カンマを除去して整数に変換
                    $mercariPrice = intval($price);
                }
            });

            // 画像を保存し、ファイルパスを取得
            $fileName = basename($imageUrl); // URLからファイル名を抽出
            $savedImagePath = $this->saveImage($fileName, $directoryName, $imageUrl);

            $elements[] = [
                'url' => $imageUrl,
                'title' => $imageTitle,
                'mercari_price' => $mercariPrice,
                'saved_image_path' => $savedImagePath // 保存した画像のパス
            ];
        });

        // 価格で降順にソート
        usort($elements, function ($item1, $item2) {
            return $item2['mercari_price'] <=> $item1['mercari_price'];
        });

        $attrs['user_id'] = 1;
        $attrs['game_id'] = config('assets.site.game_ids.pokemon_card');
        $attrs['title'] = '';
        $attrs['thumbnail_image_url'] = '';
        $attrs['body'] = $this->makeBody($elements);
        $attrs['is_released'] = false;
        return $this->createBlog($attrs);
    }

    private function saveImage(string $fileName, string $directoryName, string $imageUrl): string
    {
        // URLからファイル取得
        $imgDownloaded = file_get_contents($imageUrl);

        // 保存先のディレクトリパスを設定
        $directoryPath = public_path('images/blogs/' . $directoryName);

        // ディレクトリが存在しない場合は作成
        if (!file_exists($directoryPath)) {
            mkdir($directoryPath, 0755, true);
        }

        // 保存先のファイルパスを設定
        $filePath = $directoryPath . '/' . $fileName;

        // 画像を直接publicディレクトリに保存
        file_put_contents($filePath, $imgDownloaded);

        // 保存したファイルへのURLを返す
        return 'public/images/blogs/' . $fileName;
    }

    private function makeBody(array $elements): string
    {
        $html = '<div class="card-container">';
        foreach ($elements as $element) {
            $html .= '<div class="card">';
            $html .= '<img src="' . htmlspecialchars($element['saved_image_path']) . '" alt="' . htmlspecialchars($element['title']) . '">';
            $html .= '<h3>' . htmlspecialchars($element['title']) . '</h3>';
            $html .= '<p>価格: ' . htmlspecialchars(number_format($element['mercari_price'])) . '円</p>';
            $html .= '</div>';
        }
        $html .= '</div>';
        return $html;
    }
}
