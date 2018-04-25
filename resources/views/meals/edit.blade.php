@extends('layouts.default')
@section('title','修改菜品信息')
@section('content')
    <link rel="stylesheet" type="text/css" href="/webuploader/webuploader.css">
    <div class="row">
        <div class="col-lg-1"></div>
        <div class="container col-lg-9" style="background-color: #eceeae">
            <br/>
            <form  method="post" action="{{ route('meals.update',$meal) }}">
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
                    <label>原菜品图片:</label><br/>
                    <img src="{{$meal->meal_img}}" width="200">
                </div>

                <div class="form-group">
                    <label for="logo">新图片:</label>
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
            formData:{'_token':"{{csrf_token()}}",'dir':'Meals/edit'},

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
