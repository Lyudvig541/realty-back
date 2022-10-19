<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConstAgencyTranslation extends Model {

    protected $fillable = ['name', 'description'];
    public $timestamps = false;

}
