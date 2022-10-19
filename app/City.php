<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class City extends Model implements TranslatableContract {

    use Translatable;
    protected $fillable = ['coordinates', 'state_id', 'map_zoom'];

    public $translatedAttributes = ['name'];

    public function state(){
        return $this->belongsTo(State::class);
    }
}
