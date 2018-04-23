<?php

namespace App\Http\Controllers;

use App\FoodCat;
use App\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FoodCatsController extends Controller
{
    //必须先登录
    public function __construct()
    {
        $this->middleware('auth',[
            'except'=>[]
        ]);
    }
    //添加菜品分类 表单
    public function create()
    {
        return view('foodcats.create');
    }

    //添加菜品保存
    public function store(Request $request)
    {
//        dump(Auth::user());exit;
        //验证信息
        $this->validate($request,
            [
                'name'=>'required|max:10',
                'description'=>'required|max:100',
            ],
            [
                'name.required'=>'菜品分类名不能为空!',
                'name.max'=>'菜品分类名不能超过10个字!',
                'description'=>'菜品分类描述不能为空!',
                'description.max'=>'菜品分类描述不能超过100个字!',
            ]);
        //保存菜品分类信息

        if ($request->is_selected){
            FoodCat::create(
                [
                    'name'=>$request->name,
                    'description'=>$request->description,
                    'is_selected'=>$request->is_selected,
                    'shop_id'=>Auth::user()->shop_id,
                ]
            );
        }else{
            FoodCat::create(
                [
                    'name'=>$request->name,
                    'description'=>$request->description,
                    'is_selected'=>0,
                    'shop_id'=>Auth::user()->shop_id,
                ]
            );
        }
        session()->flash('success','添加成功~');
        return redirect()->route('foodcats.index');
    }

    //查看菜品分类表
    public function index()
    {
        $wheres=[['shop_id',Auth::user()->shop_id]];
        $foodcats=FoodCat::where($wheres)->get();
        return view('foodcats.index',compact('foodcats'));
    }

    //删除菜品分类
    public function destroy(FoodCat $foodcat)
    {
        $foodcat->delete();
        echo 'success';
    }

    //修改菜品分类表单
    public function edit(FoodCat $foodcat){

        return view('foodcats.edit',compact('foodcat'));
    }

    //更新菜品分类信息保存
    public function update(Request $request,FoodCat $foodcat)
    {
        //验证
        $this->validate($request,
            [
                'name'=>'required|max:10',
                'description'=>'required|max:100',
            ],
            [
                'name.required'=>'菜品分类名不能为空!',
                'name.max'=>'菜品分类名不能超过10个字!',
                'description'=>'菜品分类描述不能为空!',
                'description.max'=>'菜品分类描述不能超过100个字!',
            ]);
        if ($request->is_selected){
            //保存信息
            $foodcat->update(
                [
                    'name'=>$request->name,
                    'description'=>$request->description,
                    'is_selected'=>$request->is_selected,
                ]
            );
        }else{
            //保存信息
            $foodcat->update(
                [
                    'name'=>$request->name,
                    'description'=>$request->description,
                    'is_selected'=>0,
                ]
            );
        }
        //跳转
        session()->flash('success', '修改成功~');
        return redirect()->route('foodcats.index',compact('foodcat'));
    }
}
