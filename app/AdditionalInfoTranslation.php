<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdditionalInfoTranslation extends Model {

    protected $fillable = ['title'];
    public $timestamps = false;

    public function additionalInfo(){
        return $this->belongsTo(AdditionalInfo::class);
    }
}
