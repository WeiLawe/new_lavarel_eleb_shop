@extends('layouts.default')
@section('title','菜品列表')
    @section('content')
        <form class="navbar-form navbar-left" method="get">
            <div class="form-group">
                <input type="text" name="keywords" class="form-control" placeholder="搜索...">
            </div>
            <button type="submit" class="btn btn-default">查询</button>
        </form>
        <table class="table table-bordered table-responsive" id="meals">
            <tr>
                <th>菜品ID</th>
                <th>菜品名</th>
                <th>菜品价格</th>
                <th>菜品分类</th>
                <th>菜品图片</th>
                <th>菜品描述</th>
                <th>菜品建议</th>
                <th>操作</th>
            </tr>
            @foreach($meals as $meal)
                <tr data-id="{{ $meal->id }}">
                    <td>{{$meal->id}}</td>
                    <td>{{$meal->meal_name}}</td>
                    <td>{{$meal->meal_price.'元'}}</td>
                    <td>{{$meal->food_cat->name}}</td>
                    <td><img src="@if($meal->meal_img){{ $meal->meal_img }}@endif" class="img-circle img-circle" style="width: 50px"></td>
                    <td>{{$meal->description}}</td>
                    <td>{{$meal->tips}}</td>
                    <td>
                        <a href="{{ route('meals.edit',['meal'=>$meal->id]) }}" class="btn btn-warning btn-sm" >编辑</a>
                        <a href="{{ route('meals.show',['meal'=>$meal->id]) }}" class="btn btn-primary btn-sm" >查看详细信息</a>
                        <button class="btn btn-danger btn-sm">删除</button>
                    </td>
                </tr>
            @endforeach
        </table>
        {{ $meals->appends(compact('keywords'))->links() }}
    @stop
@section('js')
    <script>
        $("#meals .btn-danger").click(function () {
            //确认删除 进入点击事件
//                console.log("ok");
            if(confirm('删除后不能恢复!')){
                var tr = $(this).closest('tr');
                var id=tr.data('id');
                $.ajax({
                    type:"DELETE",
                    url:'meals/'+id,
                    data:'_token={{ csrf_token() }}',
                    success: function (msg) {
                        tr.fadeOut();
                    }
                });
            }
        });
    </script>

@stop