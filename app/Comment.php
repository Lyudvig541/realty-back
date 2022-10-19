<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model {

    protected $fillable = ['broker_id','user_id','text'];

    public function broker(){
        return $this->belongsTo(User::class,'broker_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

}
