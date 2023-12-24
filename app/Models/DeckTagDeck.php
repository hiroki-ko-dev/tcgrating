<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class DeckTagDeck extends Model
{
    use HasFactory;

    protected $guarded = [];

    // 中間テーブルのカスタムテーブル名を設定（必要に応じて変更してください）
    protected $table = 'deck_tag_deck';

    // タイムスタンプを無効にする
    public $timestamps = false;
}