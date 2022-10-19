<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PageTranslation extends Model {

    protected $fillable = ['title', 'sub_title','editor'];
    public $timestamps = false;

}
