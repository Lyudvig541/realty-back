<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Agency extends Model implements TranslatableContract {

    use Translatable;

    protected $fillable = ['image', 'phone', 'country_id', 'state_id', 'city_id'];

    public $translatedAttributes = ['name', 'description'];

    public function country(){
        return $this->belongsTo(Country::class);
    }

    public function state(){
        return $this->belongsTo(State::class);
    }

    public function city(){
        return $this->belongsTo(City::class);
    }
}
