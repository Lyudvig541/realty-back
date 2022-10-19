<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CreditCompanyTranslation extends Model {

    protected $fillable = ['name', 'description','address'];
    public $timestamps = false;

}
