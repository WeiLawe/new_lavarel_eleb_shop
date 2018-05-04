<?php

namespace App\Http\Controllers;

use App\Meal;
use App\Order;
use App\Order_goods;
use App\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{
    //订单列表
    public function index()
    {
        $wheres=[['shop_id',Auth::user()->shop_id]];
        $orders=DB::table('orders')->where($wheres)->paginate(3);
        return view('orders.index',compact('orders'));
    }

    //取消订单
    public function cancel(Order $order)
    {
        $wheres=[['shop_id',Auth::user()->shop_id],['id',$order->id]];
        DB::table('orders')->where($wheres)->update(
            [
                'order_status'=>2,
            ]
        );
        session()->flash('warning','取消成功!');
        return redirect()->route('orders.index');
    }

    //恢复订单
    public function back(Order $order)
    {
        $wheres=[['shop_id',Auth::user()->shop_id],['id',$order->id]];
        DB::table('orders')->where($wheres)->update(
            [
                'order_status'=>0,
            ]
        );
        session()->flash('success','恢复成功!');
        return redirect()->route('orders.index');
    }

    //发货
    public function send(Order $order)
    {
        $wheres=[['shop_id',Auth::user()->shop_id],['id',$order->id]];
        DB::table('orders')->where($wheres)->update(
            [
                'order_status'=>3,
            ]
        );
        session()->flash('success','发货成功!');
        return redirect()->route('orders.index');
    }

    //查询订单详情
    public function show(Order $order)
    {
        $wheres=[['shop_id',Auth::user()->shop_id],['id',$order->id]];
        $order->where($wheres)->get();
        $order_goods=DB::table('order_goods')->where('order_id',$order->id)->get();
//        dd($order_goods);
        return view('orders.show',compact('order','order_goods'));
    }

    //查看订单量统计
    public function count(Request $request)
    {
        $time_day=date('Y-m-d',time());
//        dd($time);
        $where=[
            ['order_birth_time','>',$time_day],
            ['order_birth_time','<',$time_day+3600*24],
            ['shop_id',Auth::user()->shop_id],
        ];
        $count_day=DB::table('orders')->where($where)->count();
//        dd($count_day);

        $time_month=date('Y-m',time());
        $where_month=[
            ['order_birth_time','>',$time_month],
            ['order_birth_time','<',$time_month+'1 month'],
            ['shop_id',Auth::user()->shop_id],
        ];
        $count_month=DB::table('orders')->where($where_month)->count();
//        dd($count_month);

        $count_total=DB::table('orders')->where('shop_id',Auth::user()->shop_id)->count();

        //查询的日期
        $start_time = $request->start_time;
        $end_time = $request->end_time;

        //没有查询日期
            if ($start_time===null || $end_time===null){
                $count = 0;
        }

        //有日期
        if ($start_time&&$end_time){
            $wheres=[
                ['order_birth_time', '>', date('Y-m-d', strtotime($start_time))],
                ['order_birth_time', '<', date('Y-m-d', strtotime($end_time)+3600*24)],
                ['shop_id',Auth::user()->shop_id],
            ];

            //计数
            $count = DB::table('orders')
                ->where($wheres)
                ->count();
        }
        return view('orders.count',compact('count','count_day','count_month','count_total'));
    }
}
