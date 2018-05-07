<?php

namespace App\Http\Controllers;

use App\Event;
use App\Event_member;
use App\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Event_membersController extends Controller
{
    //报名
    public function apply(Request $request)
    {


            Event_member::create(
                [
                    'events_id'=>$request->event,
                    'member_id'=>Auth::user()->id,
                ]
            );
            session()->flash('success', '报名成功~');
            return redirect()->route('events.index');


    }
    

}
