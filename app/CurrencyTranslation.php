<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CurrencyTranslation extends Model
{
    protected $fillable = ['name'];
    public $timestamps = false;
}
