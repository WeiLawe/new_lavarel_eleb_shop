@extends('layouts.default')
@section('title','添加菜品分类')
    @section('content')
        <form action="{{route('foodcats.store')}}" method="post">
            {{csrf_field()}}
            <div class="form-group">
                <label>菜品分类名:</label>
                <div class="row">
                    <div class="col-sm-3">
                        <input type="text" name="name" class="form-control" placeholder="菜品分类名称" value="{{old('name')}}">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>菜品分类简介</label>
                <textarea name="description" maxlength="50" class="form-control" rows="3" placeholder="分类描述">{{ old('description') }}</textarea>
            </div>

            <div class="checkbox">
                <label>
                    <input type="checkbox" name="is_selected" value="1" @if(old('is_selected')) checked @endif>
                    是否为默认选中状态
                </label>
            </div>

            <div class="form-group">
                <label for="name">验证码：</label>
                <div class="row">
                    <div class="col-sm-2">
                        <input id="captcha" class="form-control" name="captcha" >
                    </div>
                    <div class="col-sm-4">
                        <img class="thumbnail captcha" src="{{ captcha_src('flat') }}" onclick="this.src='/captcha/flat?'+Math.random()" title="点击图片重新获取验证码">
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-default">确认添加</button>
        </form>



        @stop