<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FoodCat extends Model
{
    protected $fillable = [
        'name', 'description','shop_id','is_selected'
    ];

    public function shop(){
        return $this->belongsTo(Shop::class,'shop_id');
    }
}
