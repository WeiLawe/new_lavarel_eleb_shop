@extends('layouts.default')
@section('title', '添加菜品')

@section('content')

    <form  method="post" action="{{ route('meals.store') }}" enctype="multipart/form-data">
        <div class="form-group">
            <label>菜品名称</label>
            <input type="text" class="form-control" placeholder="菜品名" name="meal_name" value="{{ old('meal_name') }}">
        </div>

        <div class="form-group">
            <label>菜品价格</label>
            <input type="number" class="form-control" placeholder="菜品价格" name="meal_price" value="{{ old('meal_price') }}">
        </div>

        <div class="form-group">
            <label>菜品分类</label>
            <select class="form-control" name="food_cat_id">
                <option value="">--选择分类--</option>
                @foreach($foodcats as $foodcat)
                    <option value="{{ $foodcat->id }}">{{ $foodcat->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>菜品图片</label>
            <input  type="file"  name="meal_img"/>
        </div>

        <div class="form-group">
            <label>菜品描述</label>
            <textarea name="description" maxlength="50" class="form-control" rows="3" placeholder="菜品描述">{{ old('description') }}</textarea>
        </div>

        <div class="form-group">
            <label>菜品建议</label>
            <textarea name="tips" class="form-control" rows="3" placeholder="菜品建议" maxlength="50">{{ old('tips') }}</textarea>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">验证码</label>
            <input id="captcha" class="form-control" name="captcha" >
            <img class="thumbnail captcha" src="{{ captcha_src('flat') }}" onclick="this.src='/captcha/flat?'+Math.random()" title="点击图片重新获取验证码">
        </div>
        <button type="submit" class="btn btn-primary btn-success"> 添加菜品</button>
        {{csrf_field()}}
    </form>

    @stop