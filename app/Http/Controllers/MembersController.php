<?php

namespace App\Http\Controllers;

use App\Cat;
use App\Event;
use App\Handlers\ImageUploadHandler;
use App\Member;
use App\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MembersController extends Controller
{
//    必须先登录
//    public function __construct()
//    {
//        $this->middleware('auth',[
//            'except'=>[]
//        ]);
//    }
    //添加店铺
    public function create(){
        $cats=Cat::all();
//        dump($cats);exit;
        return view('members.create',compact('cats'));
    }

    //店铺保存
    public function store(Request $request,Member $member){
        //验证店铺
        $this->validate($request,
            [
                'name'=>'required',
                'email'=>'required|email',
                'password'=>'required|min:6|confirmed',
                'cat_id'=>'required',
                'captcha' => 'required|captcha',
                'shop_img'=>'required'
            ],
            [
                'name.required'=>'店铺名不能为空!',
                'email.required'=>'邮箱不能为空!',
                'email.email'=>'请填写合法的邮箱!',
                'password.required'=>'密码不能为空!',
                'password.min'=>'密码不能低于6位!',
                'password.confirmed'=>'前后两次密码输入不一致!',
                'cat_id.required'=>'分类不能为空!',
                'captcha.required' => '验证码不能为空',
                'captcha.captcha' => '请输入正确的验证码',
                'shop_img.required'=>'店铺图片不能为空!'
            ]);



//保存商品店主信息
        DB::transaction(function () use ($request) {

            $shops=Shop::create(
                [
                    'shop_name'=>$request->shop_name,
                    'shop_img'=>$request->shop_img,
                    'brand'=>$request->brand,
                    'on_time'=>$request->on_time,
                    'fengniao'=>$request->fengniao,
                    'bao'=>$request->bao,
                    'piao'=>$request->piao,
                    'zhun'=>$request->zhun,
                    'start_send'=>$request->start_send,
                    'shop_rating'=>0,
                    'send_cost'=>$request->send_cost,
                    'notice'=>$request->notice,
                    'discount'=>$request->discount,
                    'distance'=>$request->distance,
                    'estimate_time'=>$request->estimate_time,

                ]
            );

            Member::create(
                [
                    'name'=>$request->name,
                    'cat_id'=>$request->cat_id,
                    'password'=>bcrypt($request->password),
                    'status'=>0,
                    'email'=>$request->email,
                    'detail'=>$request->detail,

//                    最后插入的id
                    'shop_id'=>$shops->id
                ]
            );
        });
        session()->flash('success','添加商铺成功,待审核');
        return redirect()->route('home');
    }

    //显示该商铺详情
    public function show(Member $member){
        $cats=Cat::all();

        return view("members.show",compact('member','cats'));
    }

    //修改密码表单
    public function pwd_edit(Member $member)
    {
        return view('members.pwd_edit',compact('member'));
    }

    //修改密码保存
    public function pwd_edit_save(Request $request, Member $member)
    {
        //验证
//        dump($request);exit;
        if (!empty($request->old_password)) {
            if (Hash::check($request->old_password, $member->password)) {
                $this->validate($request,
                    [
                        'old_password' => 'required',
                        'password' => 'required|min:6|confirmed',
                    ],
                    [
                        'old_password.required' => '旧密码不能为空!',
                        'password.required' => '新密码不能为空!',
                        'password.min' => '新密码不能低于6位!',
                        'password.confirmed' => '前后两次密码输入不一致!',
                    ]);
                $member->update(
                    [
                        'password' => bcrypt($request->password),
                    ]
                );
                Auth::logout();
                session()->flash('success', '修改密码成功,请重新登录!');
                return redirect()->route('login', compact('member'));
            }
        }
        session()->flash('warning', '修改失败,返回首页');
        return redirect()->route('home');
    }


    //显示修改表单
    public function edit(Member $member)
    {
        $cats=Cat::all();
        return view('members.edit',compact('member','cats'));
    }

    //修改信息保存
    public function update(Request $request,Member $member){
        $this->validate($request,
            [
                'name'=>'required',
                'email'=>'required|email',
                'cat_id'=>'required',

            ],
            [
                'name.required'=>'店铺名不能为空!',
                'email.required'=>'邮箱不能为空!',
                'email.email'=>'请填写合法的邮箱!',
                'cat_id.required'=>'分类不能为空!',
                'shop_img.required'=>'店铺图片不能为空!'
            ]);

        //保存商品店主信息
        DB::transaction(function () use ($request,$member) {
            if ($request->shop_img) {
                DB::table('shops')->where('id',$member->shop_id)->update(
                    [
                        'shop_name'=>$request->shop_name,
                        'shop_img'=>$request->shop_img,
                        'brand'=>$request->brand,
                        'on_time'=>$request->on_time,
                        'fengniao'=>$request->fengniao,
                        'shop_rating'=>$request->shop_rating,
                        'bao'=>$request->bao,
                        'piao'=>$request->piao,
                        'zhun'=>$request->zhun,
                        'start_send'=>$request->start_send,
                        'send_cost'=>$request->send_cost,
                        'notice'=>$request->notice,
                        'discount'=>$request->discount,
                        'distance'=>$request->distance,
                        'estimate_time'=>$request->estimate_time,
                    ]
                );
                $member->update(
                    [
                        'name'=>$request->name,
                        'email'=>$request->email,
                        'status'=>$request->status,
                        'cat_id'=>$request->cat_id,
                        'detail'=>$request->detail,
                    ]
                );
            }else{
                DB::table('shops')->where('id',$member->shop_id)->update(
                    [
                        'shop_name'=>$request->shop_name,
                        'brand'=>$request->brand,
                        'on_time'=>$request->on_time,
                        'fengniao'=>$request->fengniao,
                        'shop_rating'=>$request->shop_rating,
                        'bao'=>$request->bao,
                        'piao'=>$request->piao,
                        'zhun'=>$request->zhun,
                        'start_send'=>$request->start_send,
                        'send_cost'=>$request->send_cost,
                        'notice'=>$request->notice,
                        'discount'=>$request->discount,
                        'distance'=>$request->distance,
                        'estimate_time'=>$request->estimate_time,
                    ]
                );
                $member->update(
                    [
                        'name'=>$request->name,
                        'email'=>$request->email,
                        'status'=>$request->status,
                        'cat_id'=>$request->cat_id,
                        'detail'=>$request->detail,
                    ]
                );
            }
        });

        session()->flash('success', '修改成功~');
        return redirect()->route('members.show',compact('member'));
    }
}
