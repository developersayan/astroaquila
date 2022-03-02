<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Postcode extends Model
{
    protected $table = 'postcode';
    protected $guarded = [];

    public function getCountry()
    {
        return $this->hasOne('App\Models\Country','id','country_id');
    }

    public function getState()
    {
        return $this->hasOne('App\Models\State','id','state_id');
    }

    public function getCity()
    {
        return $this->hasOne('App\Models\City','id','city_id');
    }
}
