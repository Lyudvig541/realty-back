<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Type extends Model implements TranslatableContract {
    use Translatable;

    protected $fillable = ['image','slug'];

    public $translatedAttributes = ['name'];

    public function types(){
        $this->hasMany(TypeTranslation::class,'type_id');
    }
    public function announcements(){
        $this->hasMany(Announcement::class,'type_id');
    }
}
