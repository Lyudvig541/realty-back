<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $fillable = ['user_id','announcement_id'];

    public function announcement(){
        return $this->belongsTo(Announcement::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
