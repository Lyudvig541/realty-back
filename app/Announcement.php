<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Announcement extends Model implements TranslatableContract
{
    use Translatable;
    use SoftDeletes;

    protected $fillable = [
        'property_name',
        'price',
        'address',
        'floor',
        'storeys',
        'area',
        'sewer',
        'distance_from_metro_station',
        'distance_from_medical_center',
        'distance_from_stations',
        'land_area',
        'infrastructure',
        'fence_type',
        'road_type',
        'front_position',
        'front_position_length',
        'land_geometric_appearance',
        'furniture',
        'rooms',
        'bathroom',
        'building_type',
        'ceiling_height',
        'condition',
        'purpose',
        'additional_infos',
        'facilities',
        'latitude',
        'longitude',
        'category_id',
        'type_id',
        'user_id',
        'description',
        'currency_id',
        'balcony',
        'main_image',
        'rent_type',
        'building_number',
        'city',
        'city_id',
        'state',
        'state_id',
        'building',
        'certificate',
        'year',
        'cover',
        'verify',
        'broker_id',
        'accepted',
        'free',
        'land_type',
        'property_place',
        'start_date',
        'end_date',
        'zestimate',
        'degree',
        'condominium',
        'reason',
        'average_value',
    ];

    public $translatedAttributes = ['additional_text'];

    public function announcementImages()
    {
        return $this->hasMany(AnnouncementImage::class);
    }
    public  function type(){
       return  $this->belongsTo(Type::class,'type_id');
    }
    public  function category(){
        return $this->belongsTo(Category::class);
    }
    public  function broker(){
        return $this->belongsTo(User::class,'broker_id');
    }
    public  function favorites(){
        return $this->hasMany(Favorite::class);
    }
    public  function currency(){
        return $this->belongsTo(Currency::class);
    }
    public  function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
