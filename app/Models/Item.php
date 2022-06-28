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

    public function getAmountAttribute(){
        if($this->itemStocks){
            $itemStocks = $this->itemStocks->sum('amount');
        }else{
            $itemStocks = 0;
        }

        if($this->transactionItems){
            $transactionItems = $this->transactionItems->sum('amount');
        }else{
            $transactionItems = 0;
        }

        return $itemStocks - $transactionItems;
    }
}
