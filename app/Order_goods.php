<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order_goods extends Model
{
    protected $fillable = [
        'order_status','shop_id',
    ];

    public function meal(){
        return $this->belongsTo(Meal::class,'goods_id');
    }

    public function order(){
        return $this->belongsTo(Order::class,'order_id');
    }
}
