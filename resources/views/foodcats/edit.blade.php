@extends('layouts.default')
@section('title','修改菜品分类')
    @section('content')
        <form action="{{route('foodcats.update',['foodcat'=>$foodcat])}}" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            {{method_field('PUT')}}
            <div class="form-group">
                <label>菜品分类名:</label>
                <div class="row">
                    <div class="col-sm-3">
                        <input type="text" name="name" class="form-control" value="{{$foodcat->name}}">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>店铺简介</label>
                <textarea name="description" maxlength="50" class="form-control" rows="3">{{ $foodcat->description }}</textarea>
            </div>

            <div class="checkbox">
                <label>
                    <input type="checkbox" name="is_selected" value="1" @if($foodcat->is_selected==1) checked @endif>
                    是否为默认选中状态
                </label>
            </div>

            <button type="submit" class="btn btn-default">确认修改</button>
        </form>
        @stop