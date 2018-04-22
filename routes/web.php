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

//菜品资源
Route::resource('meals','MealController');

//店铺密码修改
Route::get('members/{member}/pwd_edit','MembersController@pwd_edit')->name('members.pwd_edit');
Route::post('members/{member}/pwd_edit_save','MembersController@pwd_edit_save')->name('members.pwd_edit_save');

//登录
Route::get('login', 'SessionsController@create')->name('login');
Route::post('login', 'SessionsController@store')->name('login');
Route::delete('logout', 'SessionsController@destroy')->name('logout');