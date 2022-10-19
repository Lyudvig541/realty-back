<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TypeTranslation extends Model {

    protected $fillable = ['name'];
    public $timestamps = false;
    public function type(){
        $this->belongsTo(Type::class);
    }

}
