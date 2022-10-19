<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Constructor extends Model implements TranslatableContract
{
    use Translatable;

    protected $fillable = [
        'price_start',
        'price_end',
        'available_apartments',
        'apartment_counts',
        'sold_apartments',
        'reserved_apartments',
        'start_date',
        'end_date',
        'floor_height',
        'storeys',
        'parking',
        'available_parking',
        'underground_parking',
        'available_underground_parking',
        'office_space',
        'available_office_space',
        'min_room',
        'max_room',
        'area',
        'lot',
        'main_image',
        'latitude',
        'longitude',
        'type',
        'property_type',
        'currency_id',
        'const_agency_id',
        'city_id',
        'state_id',
        'live_video_url',
        'distance_from_school',
        'distance_from_kindergarten',
        'distance_from_supermarket',
        'distance_from_pharmacy',
    ];

    public $translatedAttributes = ['property_name', 'property_description','address','features','renovation', 'plans', 'floors',"plans_id","floors_id",'sub_title'];

    public function constructorImages()
    {
        return $this->hasMany(ConstructorImage::class);
    }
    public function constAgency()
    {
        return $this->belongsTo(User::class,'const_agency_id');
    }
    public  function currency(){
        return $this->belongsTo(Currency::class);
    }
}
