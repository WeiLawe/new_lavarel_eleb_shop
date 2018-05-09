<?php

namespace App\Http\Controllers;

use App\Event;
use App\Event_member;
use App\Event_prize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EventsController extends Controller
{
    //显示抽奖活动列表
    public function index()
    {

        $events=Event::
            paginate(3);
//        dd($events);
        return view('events.index',compact('events'));
    }

    //显示抽奖活动详情
    public function show(Event $event)
    {
//        dd($event);
        $prizes=DB::table('event_prizes')->where('events_id',$event->id)->get();
//        dd($prize);

        return view('events.show',compact('event','prizes'));

    }

    //报名
    public function apply(Event $event)
    {
//        dd($event);
        //判断报名人数是否报满
        //查询出已报名的人数
        $num = DB::select('select count(*) as count from event_members where events_id=?',[$event->id]);
//        dd($num[0]);
        if($num[0]->count>=$event->signup_num){
            session()->flash('danger','报名人数已满');
            return redirect()->route('events.show',['event'=>$event]);
        }
        //查询报名时间是否过期
        $time= DB::table('events')->where([
            ['signup_end','<',time()],
            ['id',$event->id]
        ])->first();
//        dd($time);
        if($time){
            session()->flash('danger','该活动已结束');
            return redirect()->route('events.show',['event'=>$event]);
        }
        //判断是否已经报名
        $result= DB::table('event_members')->where([
            ['member_id',Auth::user()->id],
            ['events_id',$event->id]
        ])->first();
//        dd($result);
        if($result){
            session()->flash('danger','您已报名');
            return redirect()->route('events.show',['event'=>$event]);
        }

        Event_member::create(
            [
                'events_id'=>$event->id,
                'member_id'=>Auth::user()->id,
            ]
        );
        session()->flash('success', '报名成功~');
        return redirect()->route('events.index');

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
