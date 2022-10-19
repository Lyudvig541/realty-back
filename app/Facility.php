<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Facility extends Model implements TranslatableContract {

    use Translatable;

    protected $fillable = ['value','icon','image'];

    public $translatedAttributes = ['title'];

    public function facilitiesTranslations(){
        return $this->hasMany(FacilityTranslation::class,'facility_id');
    }
}
