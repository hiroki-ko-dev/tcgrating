<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function game(){
        return $this->belongsTo('App\Models\Game','game_id','id');
    }

    public function itemStocks(){
        return $this->hasMany('App\Models\ItemStock','item_id','id');
    }

    public function transactionItems(){
        return $this->hasMany('App\Models\TransactionItem','item_id','id');
    }

    /**
     * @return int
     * 入荷数-購入数を行い、現在の在庫数を出す
     */
    public function getQuantityAttribute(){
        if($this->itemStocks){
            $itemStocks = $this->itemStocks->sum('quantity');
        }else{
            $itemStocks = 0;
        }

        if($this->transactionItems){
            $transactionItems = $this->transactionItems->sum('quantity');
        }else{
            $transactionItems = 0;
        }

        return $itemStocks - $transactionItems;
    }
}
