<?php

namespace App\Services;
use Illuminate\Http\Request;
use Weidner\Goutte\GoutteFacade;

class ProductService
{
    public function __construct()
    {
    }

    /**
     * @param $request
     * @return mixed
     */
    public function getProducts($request)
    {
        $list = [];
        $store = [];

        // カードラッシュからのスクレイピング
        $goutte = GoutteFacade::request('GET', 'https://www.cardrush-pokemon.jp/product-list/0/0/photo?keyword=' . $request->word . '&num=100&img=160&order=featured');
        $goutte->filter('.list_item_cell')->each(function ($li) use(&$cardRash){
            $store['id'][] = $li->filter('div')->attr('data-product-id');
            $store['name'][] = $li->filter('.goods_name')->text();
            $store['price'][] = $li->filter('.figure')->text();
            $store['image'][] = $li->filter('img')->attr('src');
            $store['store'][] = 'カードラッシュ';
            $store['url'][] = 'https://www.cardrush-pokemon.jp/product/';
        });
        if($cardRash){
            $list = array_merge($list, $cardRash);
        }
        $store = [];

        // カードラボからのスクレイピング
//        $cardLabo = [];
//        $goutte = GoutteFacade::request('GET', 'https://www.c-labo-online.jp/product-list?keyword=+ポケカ++' . $request->word . '&num=10&Submit=');
//        $goutte->filter('.item_data')->each(function ($li) use(&$cardLabo){
//            // idは画像からとる
//            $cardLabo['image'][] = $li->filter('.global_photo')->attr('data-src');
//            // idを抜き出す必要あり
//            $cardLabo['id'] = $cardLabo['image'];
//
//            $cardLabo['name'][] = $li->filter('.goods_name')->text();
//            $cardLabo['price'][] = $li->filter('.figure')->text();
//            $cardLabo['store'][] = 'カードラボ';
//            $cardLabo['url'][] = 'https://www.c-labo-online.jp/product/';
//        });
//
//        if($cardLabo){
//            $list = array_merge($list, $cardLabo);
//        }

        // カードラッシュからのスクレイピング
        $goutte = GoutteFacade::request('GET', 'https://dorasuta.jp/pokemon-card/product-list?kw=' . $request->word);
//        $store['image'][] = $goutte->filter('.lazyload')->attr('data-src');
        $goutte->filter('body')->each(function ($li) use(&$store){
            $store['name'][] = $li->filter('a')->text();
            $store['price'][] = $li->filter('ul')->filter('li')->eq(2)->text();

            $store['store'][] = 'ドラゴンスター';
            $store['url'][] = 'https://dorasuta.jp/pokemon-card/product?pid=';
        });
        foreach($store['image'] as $i => $id){
            $store['id'] = str_replace('/pokemon-card/product?pid=', '', $store['image'][$i]);
            $store['image'][$i] = 'https://dorasuta.jp/pokemon-card/product' . $store['image'][$i];
        }
        if($cardRash){
            $list = array_merge($list, $cardRash);
        }
        $store = [];

        return $list;

    }

}
