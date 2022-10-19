<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnnouncementImage extends Model{

    public $timestamps = false;
    protected $fillable = [
        'announcement_id',
        'name',
    ];

}
