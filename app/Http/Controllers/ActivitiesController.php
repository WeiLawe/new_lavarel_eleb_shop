<?php

namespace App\Http\Controllers;

use App\Activity;
use Illuminate\Http\Request;

class ActivitiesController extends Controller
{
    //查看活动列表
    public function index()
    {
        $activities=Activity::paginate(3);
        return view('activities.index',compact('activities'));
    }

    //显示活动详情
    public function show(Activity $activity)
    {
        return view('activities.show',compact('activity'));
    }
}
