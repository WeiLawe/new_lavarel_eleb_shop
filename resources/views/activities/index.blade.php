@extends('layouts.default')
@section('title','活动列表')
    @section('content')
        <table class="table table-bordered table-responsive">
            <tr>
                <th>ID</th>
                <th>活动标题</th>
                <th>活动开始时间</th>
                <th>活动结束时间</th>
                <th>操作</th>
            </tr>
            @foreach($activities as $activity)
                <tr>
                    <td>{{$activity->id}}</td>
                    <td>{{$activity->title}}</td>
                    <td>{{date('Y-m-d',$activity->start)}}</td>
                    <td>{{date('Y-m-d',$activity->end)}}</td>
                    <td>
                        <a href="{{ route('activities.show',['activity'=>$activity]) }}" class="btn btn-primary btn-sm" >查看</a>
                    </td>
                </tr>
            @endforeach
        </table>
        {{ $activities->links() }}
    @stop
