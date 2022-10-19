<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankRequest extends Model {

    protected $fillable = ['company_id','user_id','property_price','property_size','bedrooms','bathrooms','file','comment'];

    public function company(){
        return $this->belongsTo(CreditCompany::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

}
