<?php

namespace App\Http\Controllers;

use App\FoodCat;
use App\Handlers\ImageUploadHandler;
use App\Meal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use OSS\Core\OssException;

class MealController extends Controller
{
    //必须先登录
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => []
        ]);

    }

        //添加菜品表单
    public function create()
    {
        $wheres=[['shop_id',Auth::user()->shop_id]];
        $foodcats=FoodCat::where($wheres)->get();
        return view('meals.create',compact('foodcats'));
    }

    //保存菜品
    public function store(Request $request)
    {
//        dump($request);exit;
        $this->validate($request,
            [
                'meal_name'=>'required',
                'meal_price'=>'required',
                'food_cat_id'=>'required',
                'description'=>'required',
                'tips'=>'required',
                'meal_img'=>'required',
            ],
            [
                'meal_name.required'=>'菜品名不能为空!',
                'meal_price.required'=>'菜品价格不能为空!',
                'food_cat_id.required'=>'分类不能为空!',
                'description.required'=>'菜品描述不能为空!',
                'tips.required'=>'菜品建议不能为空!',
                'meal_img.required'=>'菜品图片不能为空!',
            ]);

        //保存菜品信息
        DB::transaction(function () use ($request) {
            Meal::create(
                [
                    'meal_name' => $request->meal_name,
                    'meal_img' => $request->meal_img,
                    'meal_price' => $request->meal_price,
                    'description' => $request->description,
                    'food_cat_id'=>$request->food_cat_id,
                    'tips' => $request->tips,
                    'shop_id' => Auth::user()->shop_id,
                ]
            );
        });
        session()->flash('success','添加成功~');
        return redirect()->route('meals.index');
    }

    //菜品列表
    public function index(Request $request,Meal $meal)
    {
        $foodcats=FoodCat::all();
        //检查是否有keywords参数,有,需要搜索,没有 不需要搜索
        $keywords = $request->keywords;
        $wheres=[['shop_id',Auth::user()->shop_id]];
        if($keywords){
            $wheres[]=["meal_name",'like',"%{$keywords}%"];
        }
        $meals = Meal::where($wheres)->paginate(3);
        return view('meals.index',compact('meals','keywords','foodcats','meal'));
    }

    //修改菜品表单
    public function edit(Meal $meal)
    {
        $wheres=[['shop_id',Auth::user()->shop_id]];
        $foodcats=FoodCat::where($wheres)->get();
        return view('meals.edit',compact('meal','foodcats'));
    }

    //修改信息更新
    public function update(Request $request,Meal $meal)
    {
//        dump($meal);die;
        $this->validate($request,
            [
                'meal_name'=>'required',
                'meal_price'=>'required',
                'food_cat_id'=>'required',
                'description'=>'required',
                'tips'=>'required',
            ],
            [
                'meal_name.required'=>'菜品名不能为空!',
                'meal_price.required'=>'菜品价格不能为空!',
                'food_cat_id.required'=>'分类不能为空!',
                'description.required'=>'菜品描述不能为空!',
                'tips.required'=>'菜品建议不能为空!',

            ]);
        //保存菜品信息
        DB::transaction(function () use ($request,$meal) {
            if ($request->meal_img){
                DB::table('meals')->where('id',$meal->id)->update(
                    [
                        'meal_name' => $request->meal_name,
                        'meal_img' => $request->meal_img,
                        'meal_price' => $request->meal_price,
                        'description' => $request->description,
                        'food_cat_id'=>$request->food_cat_id,
                        'tips' => $request->tips,
                    ]
                );
            }else{
                DB::table('meals')->where('id',$meal->id)->update(
                    [
                        'meal_name' => $request->meal_name,
                        'meal_price' => $request->meal_price,
                        'description' => $request->description,
                        'food_cat_id'=>$request->food_cat_id,
                        'tips' => $request->tips,
                    ]
                );
            }

        });
        session()->flash('success','修改成功~');
        return redirect()->route('meals.index');
    }

    //查看菜品详情
    public function show(Meal $meal)
    {
        $wheres=[['shop_id',Auth::user()->shop_id]];
        $foodcats=FoodCat::where($wheres)->get();
        return view("meals.show",compact('meal','foodcats'));
    }

    //删除菜品
    public function destroy(Meal $meal)
    {
        $meal->delete();
        echo 'success';
    }

}
