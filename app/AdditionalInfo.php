<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class AdditionalInfo extends Model implements TranslatableContract {

    use Translatable;

    protected $fillable = ['value','image'];

    public $translatedAttributes = ['title'];

    public function additionalInfoTranslations(){
        return $this->hasMany(AdditionalInfoTranslation::class,'additional_info_id');
    }
}
