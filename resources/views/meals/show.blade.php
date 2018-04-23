@extends('layouts.default')
@section('title',$meal->meal_name)
    @section('content')
        <p style="color:#c8c8cf;font-size: 24px">菜品详情</p>
        <dl class="dl-horizontal col-xs-7">
            <dt>菜品名称</dt>
            <dd>{{$meal->meal_name}}</dd>
            <dt>菜品图片</dt>
            <dd><img src="{{$meal->meal_img}}" alt="未上传" width="200"></dd>
            <dt>菜品所属分类</dt>
            <dd>{{$meal->food_cat->name}}</dd>
            <dt>菜品价格</dt>
            <dd>{{$meal->meal_price}}元</dd>
            <dt>菜品描述</dt>
            <dd>{{$meal->description}}</dd>
            <dt>菜品建议</dt>
            <dd>{{$meal->tips}}</dd>
            <dt></dt><dd></dd>
            <dt></dt>
            <dd>
                <a href="{{route('meals.index')}}" class="btn btn-primary">返回菜品列表</a>
            </dd>
        </dl>
    @stop