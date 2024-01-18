<?php

declare(strict_types=1);

namespace App\Services\Blogs;

use App\Models\Blog;
use App\Repositories\BlogRepository;
use App\Repositories\BlogCommentRepository;
use App\Utils\ImageUtil;
use Weidner\Goutte\GoutteFacade;

final class BlogsNewPackService extends BlogsService
{
    public function __construct(
        BlogRepository $blogRepository,
        BlogCommentRepository $blogCommentRepository,
        private readonly ImageUtil $imageUtil,
    ) {
        // 親クラスのコンストラクタを呼び出し、依存関係を初期化
        parent::__construct($blogRepository, $blogCommentRepository);
    }

    public function createBlogsNewPack(string $url): Blog
    {
        $elements = [];

        $base = "https://pokecabook.com/archives/";
        $packName = str_replace($base, '', $url);
        $directoryPath = '/images/blogs/' . date('Y-m-d') . '_' . $packName;

        $goutte = GoutteFacade::request('GET', $url);
        $goutte->filter('h4')->each(function ($node) use (&$elements, $directoryPath) {
            $cardName = $node->filter('span')->text(); // カード名を取得

            // 画像のURLを取得
            $imageUrl = null;
            // 変数の初期化
            $technical1 = $technical2 = $effect1 = $effect2 = null;
            $foundTechnical2 = $foundEffect1 = false;

            $node->nextAll('figure')->first()->filter('a')->each(function ($a) use (&$imageUrl, &$technical1, &$technical2, &$effect1, &$effect2, &$foundEffect1, &$foundTechnical2) {
                $imageUrl = $a->attr('href');

                // p要素を処理
                foreach ($a->nextAll() as $element) {
                    // Crawlerオブジェクトに変換
                    $elementCrawler = new Symfony\Component\DomCrawler\Crawler($element);

                    // もし要素がpでなければ、ループを終了
                    if (strtolower($elementCrawler->nodeName()) !== 'p') {
                        break;
                    }

                    $class = $elementCrawler->attr('class');
                    if (!is_null($class) && strpos($class, 'is-style-border-solid') !== false) {
                        // effect処理
                        if (!$foundEffect1) {
                            $effect1 = $elementCrawler->text();
                            $foundEffect1 = true;
                        } else {
                            $effect2 = $elementCrawler->text();
                        }
                    } else {
                        // technical処理
                        if (is_null($technical1)) {
                            $technical1 = $elementCrawler->text();
                        } elseif (!$foundTechnical2) {
                            $technical2 = $elementCrawler->text();
                            $foundTechnical2 = true;
                        }
                    }
                }
            });

            try {
                if (is_null($imageUrl)) {
                    throw new \Exception("Image URL is null");
                }
                $fileName = basename($imageUrl);
                $savedImagePath = $this->imageUtil->saveImage($fileName, $directoryPath, $imageUrl);
                $elements[] = [
                    'title' => $cardName,
                    'technical1' => $technical1,
                    'technical2' => $technical2,
                    'effect1' => $effect1,
                    'effect2' => $effect2,
                    'url' => $imageUrl,
                    'saved_image_path' => $savedImagePath
                ];
            } catch (\Exception $e) {
                // 例外が発生した場合（file_get_contentsが失敗した場合）、
                // このイメージの処理をスキップして次に進む
                // エラーログを記録する場合はここに記述
            }
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

        foreach ($elements as $index => $element) {
            // カードの内容
            $html .= '<div class="card">';
            $html .= '<img class="card-image" src="' . htmlspecialchars($element['saved_image_path']) . '" alt="' . htmlspecialchars($element['title']) . '">';
            // カードタイトル
            $html .= '<div class="card-title">' . htmlspecialchars($element['title']) . '</div>';
            // technical1 と technical2 の表示
            if (!is_null($element['technical1'])) {
                $html .= '<div class="card-technical">' . htmlspecialchars($element['technical1']) . '</div>';
            }
            if (!is_null($element['technical2'])) {
                $html .= '<div class="card-technical">' . htmlspecialchars($element['technical2']) . '</div>';
            }
            // effect1 と effect2 の表示
            if (!is_null($element['effect1'])) {
                $html .= '<div class="card-effect">' . htmlspecialchars($element['effect1']) . '</div>';
            }
            if (!is_null($element['effect2'])) {
                $html .= '<div class="card-effect">' . htmlspecialchars($element['effect2']) . '</div>';
            }
            $html .= '</div>'; // cardを閉じる
        }

        $html .= '</div>'; // card-containerを閉じる
        return $html;
    }
}
