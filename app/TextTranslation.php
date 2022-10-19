<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TextTranslation extends Model
{
    protected $fillable = ['title', 'sub_title','text'];
    public $timestamps = false;
}
