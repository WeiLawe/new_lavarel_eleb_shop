<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event_member extends Model
{
    protected $fillable = [
        'events_id','member_id'
    ];

    public function event(){
        return $this->belongsTo(Event::class,'events_id');
    }

    public function member(){
        return $this->belongsTo(Member::class,'member_id');
    }
}
