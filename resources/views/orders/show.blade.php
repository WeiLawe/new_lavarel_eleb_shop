@extends('layouts.default')
@section('title','订单号'.$order->order_code)
    @section('content')
        <p style="color:#c8c8cf;font-size: 24px">订单详情</p>
        <dl class="dl-horizontal col-xs-7">
            <dt>订单编号</dt>
            <dd>{{$order->order_code}}</dd>
            <dt>收货人名字</dt>
            <dd>{{$order->receiver}}</dd>
            <dt>收货人地址</dt>
            <dd>{{$order->province.$order->city.$order->area.$order->detail_address}}</dd>
            <dt>收货人联系方式</dt>
            <dd>{{$order->tel}}</dd>
            @foreach($order_goods as $order_good)
            <dt>菜品名称</dt>
            <dd>{{$order_good->goods_name}}</dd>
            <dt>菜品单价</dt>
            <dd>{{$order_good->goods_price}}元</dd>
            <dt>菜品数量</dt>
            <dd>{{$order_good->count}}</dd>
            @endforeach
            <dt>消费金额</dt>
            <dd>{{$order->order_price}}元</dd>
            <dt>下单时间</dt>
            <dd>{{$order->order_birth_time}}</dd>
            <dt></dt><dd></dd>
            <dt></dt>
            <dd>
                <a href="{{route('orders.index')}}" class="btn btn-primary">返回订单列表</a>
            </dd>
        </dl>
    @stop