@extends('layouts.default')
@section('title','修改菜品信息')
@section('content')
    <div class="row">
        <div class="col-lg-1"></div>
        <div class="container col-lg-9" style="background-color: #eceeae">
            <br/>
            <form  method="post" action="{{ route('meals.update',$meal) }}" enctype="multipart/form-data">
                <div class="form-group">
                    <label>菜品名称</label>
                    <input type="text" class="form-control" name="meal_name" value="{{ $meal->meal_name }}">
                </div>

                <div class="form-group">
                    <label>菜品价格</label>
                    <input class="form-control" name="meal_price" value="{{ $meal->meal_price }}" />
                </div>

                <div class="form-group">
                    <label>菜品分类</label>
                    <select class="form-control" name="food_cat_id">
                        <option value="">--选择分类--</option>
                        @foreach($foodcats as $foodcat)
                            <option value="{{ $foodcat->id }}"{{$foodcat->id==$meal->food_cat_id?'selected':''}}>{{ $foodcat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>原店铺图片</label>
                    <img src="{{$meal->meal_img}}" width="200">
                </div>

                <div class="form-group">
                    <label>新店铺图片</label>
                    <input  type="file"  name="meal_img"/>
                </div>

                <div class="form-group">
                    <label>菜品描述</label>
                    <textarea name="description" maxlength="50" class="form-control" rows="3">{{ $meal->description }}</textarea>
                </div>

                <div class="form-group">
                    <label>菜品建议</label>
                    <textarea name="tips" class="form-control" rows="3" maxlength="50">{{ $meal->tips}}</textarea>
                </div>

                <div class="form-group">
                    <label for="exampleInputEmail1">验证码</label>
                    <input id="captcha" class="form-control" name="captcha" >
                    <img class="thumbnail captcha" src="{{ captcha_src('flat') }}" onclick="this.src='/captcha/flat?'+Math.random()" title="点击图片重新获取验证码">
                </div>
                <button type="submit" class="btn btn-primary btn-success"> 修改菜品</button>
                {{csrf_field()}}
                {{method_field('PUT')}}
            </form>
        </div>
    </div>
@stop
