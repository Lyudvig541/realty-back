<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class CreditCompany extends Model implements TranslatableContract {

    use Translatable;

    protected $fillable = ['image','phone','whatsapp','viber'];

    public $translatedAttributes = ['name', 'description', 'address'];

}
