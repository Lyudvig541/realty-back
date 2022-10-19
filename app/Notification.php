<?php

namespace App;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model implements TranslatableContract
{
    use Translatable;

    protected $fillable = ['user_id', 'status', 'type'];

    public $translatedAttributes = ['title', 'text'];
}
