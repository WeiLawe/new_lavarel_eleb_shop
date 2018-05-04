@extends('layouts.default')
@section('title','查看菜品销量')
@section('content')
    <div class="form-group">
    <table class="table table-responsive">
        <tr>
            <th style="text-align: center" colspan="2">菜品销量</th>
        </tr>
        <tr><td colspan="2">
                <form action="" method="get">
                    <input type="date" name="start_time">
                    <input type="date" name="end_time">
                    <input type="submit" value="查询" class="btn btn-primary btn-sm">
                </form>
            </td>
        </tr>
        <tr>
            <th>菜品名</th>
            <th>销量</th>
        </tr>
        @if($meals)
        @foreach($meals as $meal)
            <tr>
                <td>{{$meal->goods_name}}</td>
                <td>{{$meal->count}}</td>
            </tr>
        @endforeach
        @endif
        <tr>
            <td>总销量</td><td>{{$sum}}条</td>
        </tr>
    </table>
    </div>
@stop