<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

//  以/ get请求 映射到StaticPagesController控制器的home方法
Route::get('/', 'StaticPagesController@home')->name('home');
Route::get('/help', 'StaticPagesController@help')->name('help');
Route::get('/about', 'StaticPagesController@about')->name('about');

//店铺资源
Route::resource('members','MembersController');
//菜品分类资源
Route::resource('foodcats','FoodCatsController');
//活动查看及详情查询
Route::get('activities','ActivitiesController@index')->name('activities.index');
Route::get('activities/{activity}','ActivitiesController@show')->name('activities.show');

//菜品资源
Route::resource('meals','MealController');

//店铺密码修改
Route::get('members/{member}/pwd_edit','MembersController@pwd_edit')->name('members.pwd_edit');
Route::post('members/{member}/pwd_edit_save','MembersController@pwd_edit_save')->name('members.pwd_edit_save');

//登录
Route::get('login', 'SessionsController@create')->name('login');
Route::post('login', 'SessionsController@store')->name('login');
Route::delete('logout', 'SessionsController@destroy')->name('logout');

//图片上传
Route::post('/upload','UploaderController@upload');
//阿里云测试上传
//E:\www\eleb_shop\public\uploads\images\Shop\img\201804\23\0_1524417167_4tgVRGXfyw.jpg
//Route::get('/oss',function (){
//    $client = App::make('aliyun-oss');
//    try{
//        $client->uploadFile('wei-eleb-shop', 'public\uploads\images\Shop\img\201804\23\0_1524417167_4tgVRGXfyw.jpg', public_path('uploads\images\Shop\img\201804\23\0_1524417167_4tgVRGXfyw.jpg'));
//    } catch(\OSS\Core\OssException $e) {
//        printf(__FUNCTION__ . ": FAILED\n");
//        printf($e->getMessage() . "\n");
//        return;
//    }
//    print(__FUNCTION__ . ": OK" . "\n");
//});