<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PartnerTranslation extends Model {

    protected $fillable = ['name', 'description'];
    public $timestamps = false;

}
