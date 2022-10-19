<?php

namespace App;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Text extends Model
{
    use Translatable;

    protected $fillable = ['slug'];

    public $translatedAttributes = ['title','sub_title','text'];

}
