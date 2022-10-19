<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserTranslation extends Model {

    protected $fillable = ['name', 'description'];
    public $timestamps = false;
    public function user(){
        $this->belongsTo(User::class);
    }

}
