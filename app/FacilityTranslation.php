<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacilityTranslation extends Model {

    protected $fillable = ['title'];
    public $timestamps = false;

    public function facility(){
        return $this->belongsTo(Facility::class,'id');
    }
}
