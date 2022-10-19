<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotificationTranslation extends Model {

    protected $fillable = ['title', 'text'];
    public $timestamps = false;

}
