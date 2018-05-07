@extends('layouts.default')
@section('title','抽奖活动列表')
    @section('content')
        <table class="table table-bordered table-responsive">
            <tr>
                <th>ID</th>
                <th>抽奖活动标题</th>
                <th>抽奖报名开始时间</th>
                <th>抽奖报名结束时间</th>
                <th>开奖时间</th>
                <th>抽奖限制人数</th>
                <th>操作</th>
            </tr>
            @foreach($events as $event)
                <tr>
                    <td>{{$event->id}}</td>
                    <td>{{$event->title}}</td>
                    <td>{{date('Y-m-d',$event->signup_start)}}</td>
                    <td>{{date('Y-m-d',$event->signup_end)}}</td>
                    <td>{{date('Y-m-d',$event->prize_date)}}</td>
                    <td>{{$event->signup_num}}</td>
                    <td>

                        <a href="{{ route('events.show',['event'=>$event]) }}" class="btn btn-primary btn-sm" >查看</a>
                    </td>
                </tr>
            @endforeach
        </table>
        {{ $events->links() }}
    @stop