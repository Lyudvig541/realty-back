<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConstructorImage extends Model{

    public $timestamps = false;
    protected $fillable = [
        'constructor_id',
        'name',
    ];

}
