<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $fillable = [
        'code',
    ];
    public function categories(){
        return $this->hasMany(Category::class);
    }
    public function types(){
        return $this->hasMany(Type::class);
    }
    public function companies(){
        return $this->hasMany(CreditCompany::class);
    }
    public function announcements(){
        return $this->hasMany(Announcement::class);
    }
    public function valueAdditional(){
        return $this->hasMany(ValueAdditional::class);
    }
    public function valueFacilities(){
        return $this->hasMany(ValueFacilities::class);
    }
    public function banners(){
        return $this->hasMany(Banner::class);
    }
}
