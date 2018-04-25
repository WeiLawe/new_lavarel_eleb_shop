@extends('layouts.default')
@section('title', '添加菜品')

@section('content')
    <link rel="stylesheet" type="text/css" href="/webuploader/webuploader.css">
    <form  method="post" action="{{ route('meals.store') }}">
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
            <label for="logo">菜品图片:</label>
            <input type="hidden" name="meal_img" id="logo" class="form-control">
        </div>
        <div class="form-group">
            <!--dom结构部分-->
            <div id="uploader-demo">
                <!--用来存放item-->
                <div id="fileList" class="uploader-list"></div>
                <div id="filePicker">选择图片</div>
            </div>
        </div>
        <div class="form-group">
            <img src="" id="img" style="width: 150px"/>
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
@section('js')
    <script type="text/javascript" src="/webuploader/webuploader.js"></script>
    <script>
        // 初始化Web Uploader
        var uploader = WebUploader.create({

            // 选完文件后，是否自动上传。
            auto: true,

            // swf文件路径
            swf: '/webuploader/Uploader.swf',

            // 文件接收服务端。
            server: '/upload',
            formData:{'_token':"{{csrf_token()}}",'dir':'Meals/create'},

            // 选择文件的按钮。可选。
            // 内部根据当前运行是创建，可能是input元素，也可能是flash.
            pick: '#filePicker',

            // 只允许选择图片文件。
            accept: {
                title: 'Images',
                extensions: 'gif,jpg,jpeg,bmp,png',
                mimeTypes: 'image/*'
            }
        });
        // 文件上传成功，给item添加成功class, 用样式标记上传成功。
        uploader.on( 'uploadSuccess', function( file,response ) {
//            $( '#'+file.id ).addClass('upload-state-done');
            //回显图片
            var url=response.url;
            $("#img").attr('src',url);
            //回显url地址
            $("#logo").val(url);
        });

    </script>
@stop