@extends('layouts.default')
@section('title','订单列表')
    @section('content')
        <table class="table table-bordered table-responsive">
            <tr>
                <th>订单编号</th>
                <th>收货人</th>
                <th>电话</th>
                <th>详细收货地址</th>
                <th>订单状态</th>
                <th>操作</th>
            </tr>
            @foreach($orders as $order)
                <tr>
                    <td>{{$order->order_code}}</td>
                    <td>{{$order->receiver}}</td>
                    <td>{{$order->tel}}</td>
                    <td>{{$order->province.$order->city.$order->area.$order->detail_address}}</td>
                    <td>
                        @if($order->order_status==0)代付款@endif
                        @if($order->order_status==1)已付款@endif
                        @if($order->order_status==2)已取消@endif
                        @if($order->order_status==3)已发货@endif
                    </td>
                    <td>
                        @if($order->order_status!=2)
                        <a href="{{ route('orders.cancel',['order'=>$order->id]) }}" class="btn btn-danger btn-sm">取消订单</a>
                        @endif
                        @if($order->order_status!=3&&$order->order_status!=2)
                        <a href="{{ route('orders.send',['order'=>$order->id]) }}" class="btn btn-warning btn-sm">发货</a>
                        @endif
                        @if($order->order_status==2)
                        <a href="{{ route('orders.back',['order'=>$order->id]) }}" class="btn btn-default btn-sm">恢复订单</a>
                        @endif
                        <a href="{{ route('orders.show',['order'=>$order->id]) }}" class="btn btn-primary btn-sm">查看订单详情</a>
                    </td>
                </tr>
            @endforeach
        </table>
        {{ $orders->links() }}
    @stop