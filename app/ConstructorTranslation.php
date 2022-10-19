<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConstructorTranslation extends Model {

    protected $fillable = ['property_name', 'property_description','address','features','renovation', 'plans', 'floors','floors_id','plans_id','sub_title'];
    public $timestamps = false;


}
