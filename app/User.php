<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    // use Notifiable;
    protected $table = 'users';
    protected $guarded = [];

    // /**
    //  * The attributes that are mass assignable.
    //  *
    //  * @var array
    //  */
    // protected $fillable = [
    //     'name', 'email', 'password',
    // ];

    // /**
    //  * The attributes that should be hidden for arrays.
    //  *
    //  * @var array
    //  */

    protected $hidden = [
        'password', 'remember_token',
    ];

    // /**
    //  * The attributes that should be cast to native types.
    //  *
    //  * @var array
    //  */
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];
    /**
     *
     */
    public function userAccount()
    {
        return $this->hasOne('App\Models\UserAccount', 'user_id', 'id');
    }
    public function astrologerExpertise()
    {
        return $this->hasMany('App\Models\AstrologerToExpertise', 'user_id', 'id');
    }
    public function astrologerLanguage()
    {
        return $this->hasMany('App\Models\AstrologerToLanguages', 'user_id', 'id');
    }
    public function gotra()
    {
        return $this->hasOne('App\Models\Gotra', 'id', 'gotra_id');
    }

    public function countries()
    {
        return $this->hasOne('App\Models\Country', 'id', 'country_id');
    }

    public function astrologerEducation()
    {
        return $this->hasMany('App\Models\AstrologerToEducation', 'user_id', 'id');
    }

    public function astrologerExperience()
    {
        return $this->hasMany('App\Models\AstrologerToExperience', 'user_id', 'id');
    }

    public function userAvailable()
    {
        return $this->hasMany('App\Models\UserToAvailable', 'user_id', 'id')->orderBy('day');
    }

    public function punditPujas()
    {
        return $this->hasMany('App\Models\PunditToPuja', 'user_id', 'id');
    }

    public function punditZip()
    {
        return $this->hasMany('App\Models\PunditToZipcode', 'pundit_id', 'id');
    }

    public function states()
    {
        return $this->hasOne('App\Models\State', 'id', 'state');
    }

	/**
     *   Method      : cityName
     *   Description : To fetch the city name
     *   Author      : Madhuchandra
     *   Date        : 2021-DEC-13
     **/
	public function cityName()
    {
        return $this->hasOne('App\Models\City', 'id', 'city');
    }


    public function orderbookings()
    {
        return $this->hasMany('App\Models\OrderMaster', 'user_id', 'id');
    }

    public function customerbooking_puja()
    {
        return $this->hasMany('App\Models\OrderMaster', 'customer_id', 'id')->where('order_type','P');
    }
     public function customerbooking_call()
    {
        return $this->hasMany('App\Models\OrderMaster', 'customer_id', 'id')->where('order_type','C');
    }

	/**
     *   Method      : astrologerExclusionDateDetails
     *   Description : To fetch the exclusion date for astrologer
     *   Author      : Madhuchandra
     *   Date        : 2021-DEC-13
     **/
	public function astrologerExclusionDateDetails()
    {
        return $this->hasOne('App\Models\AstrologerExclusionDateList', 'astrologer_id', 'id')->where('date',date('Y-m-d'));
    }


    public function getCity()
    {
        return $this->hasOne('App\Models\City', 'id', 'city');
    }
    public function getArea()
    {
        return $this->hasOne('App\Models\Area', 'id', 'area');
    }

}
