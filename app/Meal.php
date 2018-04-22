<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    //
    protected $fillable = [
        'meal_name', 'description','shop_id','meal_price','meal_img','tips','food_cat_id'
    ];

    public function shop(){
        return $this->belongsTo(Shop::class,'shop_id');
    }

    public function food_cat(){
        return $this->belongsTo(FoodCat::class,'food_cat_id');
    }
}
