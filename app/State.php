<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class State extends Model implements TranslatableContract {

    use Translatable;
    protected $fillable = ['coordinates', 'country_id', 'map_zoom'];

    public $translatedAttributes = ['name'];
    public function cities(){
        return $this->hasMany(City::class);
    }
}
