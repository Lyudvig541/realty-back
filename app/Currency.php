<?php

namespace App;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $fillable = ['value','name', 'local'];
}
