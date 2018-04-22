@extends('layouts.default')
@section('title','菜品分类列表')
    @section('content')
        <table class="table table-bordered table-responsive" id="foodcats">
            <tr>
                <th>ID</th>
                <th>菜品分类名</th>
                <th>是否默认选中</th>
                <th>菜品分类描述</th>
                <th>操作</th>
            </tr>
            @foreach($foodcats as $foodcat)
                <tr data-id="{{ $foodcat->id }}">
                    <td>{{$foodcat->id}}</td>
                    <td>{{$foodcat->name}}</td>
                    <td>{{$foodcat->is_selected==0?'✘':'✔'}}</td>
                    <td>{{$foodcat->description}}</td>
                    <td>
                        <a href="{{ route('foodcats.edit',['foodcat'=>$foodcat]) }}" class="btn btn-warning btn-sm">编辑</a>
                        {{--<a href="{{ route('foodcats.show',['foodcat'=>$foodcat]) }}" class="btn btn-primary btn-sm" >查看</a>--}}
                        <button class="btn btn-danger btn-sm">删除</button>
                    </td>
                </tr>
            @endforeach
        </table>
        {{--{{ $users->appends(['name'=>$name])->links() }}--}}
    @stop
@section('js')
    <script>
        $("#foodcats .btn-danger").click(function () {
            //确认删除 进入点击事件
//                console.log("ok");
            if(confirm('删除后不能恢复!')){
                var tr = $(this).closest('tr');
                var id=tr.data('id');
                $.ajax({
                    type:"DELETE",
                    url:'foodcats/'+id,
                    data:'_token={{ csrf_token() }}',
                    success: function (msg) {
                        tr.fadeOut();
                    }
                });
            }
        });
    </script>

@stop