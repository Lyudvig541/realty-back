<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Partner extends Model implements TranslatableContract {

    use Translatable;

    protected $fillable = ['image'];

    public $translatedAttributes = ['name', 'description'];

}
