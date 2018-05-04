<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    //查看菜品销量统计
    public function count(Request $request)
    {
//        return view("sales.count");
        //查询的日期
        $start_time = $request->start_time;
        $end_time = $request->end_time;
        $sum = 0;
        //没有查询日期
        if ($start_time===null || $end_time===null){

            $meals =null;

            return view('sales.count',compact('meals','sum'));

        }

        //有查询日期
        if ($start_time&&$end_time){
            //查询菜品
            $meals = DB::select(
                "select sum(og.count) as `count`,og.goods_name from orders JOIN order_goods as og
            on og.order_id=orders.id where orders.order_birth_time >=? and orders.order_birth_time <=?
            and shop_id=? group by og.goods_name order by `count` desc",
            [date('Y-m-d', strtotime($start_time)),
             date('Y-m-d', strtotime($end_time)+3600*24),
             Auth::user()->shop_id]
            ) ;
        }

//        dd($meals);
        foreach ($meals as $meal){
            $sum +=$meal->count;
        }
        return view('sales.count',compact('meals','sum','goods'));
    }
}
