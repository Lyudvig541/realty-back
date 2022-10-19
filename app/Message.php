<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['user_id', 'broker_id', 'message','write_broker','user_status','broker_status'];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function broker(){
        return $this->belongsTo(User::class,'broker_id');
    }
}
