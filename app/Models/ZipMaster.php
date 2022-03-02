<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ZipMaster extends Model
{
    //
    protected $table = 'zipcode_master';
    protected $guarded = [];
    public function countrylist()
    {
        return $this->hasOne('App\Models\Country','id','country_id')->orderBy('name');
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
