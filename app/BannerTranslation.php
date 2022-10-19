<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BannerTranslation extends Model {

    protected $fillable = ['title','description'];
    public $timestamps = false;

}
