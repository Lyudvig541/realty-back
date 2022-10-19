<?php

namespace App;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Permissions\HasPermissionsTrait;
use Tymon\JWTAuth\Contracts\JWTSubject;
use willvincent\Rateable\Rateable;
use App\Notifications\ResetPassword as ResetPasswordNotification;

class User extends Authenticatable implements TranslatableContract, JWTSubject
{
    use Notifiable;
    use HasPermissionsTrait;
    use Rateable;
    use SoftDeletes;
    use Translatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'remember_token',
        'avatar',
        'social_type',
        'social_token',
        'info',
        'phone',
        'agency_id',
        'country_id',
        'state_id',
        'city_id',
        'broker_licenses',
        'broker_type',
        'google_id',
        'announcements_limit',
        'broker_id',
        'phone_number_verified_at',
        'phone_number_verify_code',
    ];

    public $translatedAttributes = ['name', 'description'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function agency(){
        return $this->belongsTo(Agency::class);
    }

    public function country(){
        return $this->belongsTo(Country::class);
    }

    public function state(){
        return $this->belongsTo(State::class);
    }

    public function city(){
        return $this->belongsTo(City::class);
    }

    public function user_comments(){
        return $this->hasMany(Comment::class,'user_id');
    }
    public function broker_comments(){
        return $this->hasMany(Comment::class,'broker_id');
    }

    public function roles(){
        return $this->belongsToMany(Role::class,'user_roles');
    }

    public function permissions(){
        return $this->belongsToMany(Permission::class,'user_permissions');
    }

    public function announcements(){
        return $this->hasMany(Announcement::class);
    }
    public function favorites(){
        return $this->hasMany(Favorite::class,'user_id');
    }
    public function brokerAnnouncements(){
        return $this->hasMany(Announcement::class,'broker_id');
    }
    public function brokers(){
        return $this->hasMany(User::class,'broker_id');
    }
    public function super_broker(){
        return $this->belongsTo(User::class,'broker_id');
    }
    public function brokersAnnouncements()
    {
        return $this->hasManyThrough(
            Announcement::class,
            User::class,
            'broker_id',
            'broker_id'
        );
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
    public function sendPasswordResetNotification($token,$email='')
    {
        $this->notify(new ResetPasswordNotification($token,$email));
    }
    public function userMessages(){
        return $this->hasMany(Message::class,'user_id');
    }
    public function brokerMessages(){
        return $this->hasMany(Message::class,'broker_id');
    }
}
