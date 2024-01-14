<?php

declare(strict_types=1);

namespace App\Services\Blogs;

use App\Models\Blog;
use App\Repositories\BlogRepository;
use App\Repositories\BlogCommentRepository;
use App\Utils\ImageUtil;
use Weidner\Goutte\GoutteFacade;

final class BlogsPriceRankService extends BlogsService
{
    public function __construct(
        BlogRepository $blogRepository,
        BlogCommentRepository $blogCommentRepository,
        private readonly ImageUtil $imageUtil,
    ) {
        // 親クラスのコンストラクタを呼び出し、依存関係を初期化
        parent::__construct($blogRepository, $blogCommentRepository);
    }

    public function createBlogsPriceRank(string $url): Blog
    {
        $elements = [];

        $base = "https://osomatsusan.hatenablog.com/entry/";
        // ベースURLを取り除く
        $packName = str_replace($base, '', $url);
        $directoryPath = '/images/blogs/' . date('Y-m-d') . '_' . $packName;

        // カードラッシュからのスクレイピング
        $goutte = GoutteFacade::request('GET', $url);
        $goutte->filter('.figure-image')->each(function ($node) use (&$elements, $directoryPath) {
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
            $savedImagePath = $this->imageUtil->saveImage($fileName, $directoryPath, $imageUrl);

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
        $attrs['title'] = 'title';
        $attrs['thumbnail_image_url'] = 'test';
        $attrs['body'] = $this->makeBody($elements);
        $attrs['is_released'] = false;
        return $this->createBlog($attrs);
    }

    private function makeBody(array $elements): string
    {
        $html = '<div class="card-container">';
        $currentRank = 1;
        $previousPrice = null;
        $rankGroupStarted = false;

        foreach ($elements as $index => $element) {
            // 価格が前の要素と異なる場合、新しいランクグループを開始
            if ($previousPrice !== $element['mercari_price']) {
                if ($rankGroupStarted) {
                    $html .= '</div>'; // 前のグループを閉じる
                }
                $currentRank = $index + 1;
                $previousPrice = $element['mercari_price'];
                $html .= '<div class="rank-group">'; // 新しいグループを開始
                $html .= '<div class="rank-group-info">';
                $html .= '<div class="rank-number">' . htmlspecialchars((string)$currentRank) . '位</div>';
                $html .= '<div class="rank-price">価格: ' . htmlspecialchars(number_format($element['mercari_price'])) . '円</div>';
                $html .= '</div>'; // rank-group-infoを閉じる
                $rankGroupStarted = true;
            }
            // カードの内容
            $html .= '<div class="card">';
            $html .= '<img class="card-image" src="' . htmlspecialchars($element['saved_image_path']) . '" alt="' . htmlspecialchars($element['title']) . '">';
            $html .= '<div class="card-title">' . htmlspecialchars($element['title']) . '</div>';
            $html .= '</div>'; // cardを閉じる
        }
        if ($rankGroupStarted) {
            $html .= '</div>'; // 最後のグループを閉じる
        }

        $html .= '</div>'; // card-containerを閉じる
        return $html;
    }
}
