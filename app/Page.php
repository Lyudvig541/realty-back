<?php

namespace App;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Page extends Model implements TranslatableContract{
    use Translatable;

    protected $fillable = ['image', 'slug'];

    public $translatedAttributes = ['title', 'sub_title','editor'];
}
