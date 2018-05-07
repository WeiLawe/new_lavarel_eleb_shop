<?php

namespace App\Http\Controllers;

use App\Event;
use App\Event_prize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EventsController extends Controller
{
    //显示抽奖活动列表
    public function index()
    {

        $events=Event::paginate(3);
//        dd($events);
        return view('events.index',compact('events'));
    }

    //显示抽奖活动详情
    public function show(Event $event)
    {
        $prizes=DB::table('event_prizes')->where('events_id',$event->id)->get();
//        dd($prize);

        return view('events.show',compact('event','prizes'));

    }

    //查看抽奖结果
    public function result(Event $event)
    {
//        dd($event);
        $results=DB::table('event_prizes')
            ->join('members','event_prizes.member_id','=','members.id')
            ->where('events_id',$event->id)
            ->get();
//        dd($event);
        return view('events.result',compact('results','event'));
    }


}
