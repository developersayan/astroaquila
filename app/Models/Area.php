<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table = 'area';
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

    public function getPostcode()
    {
        return $this->hasOne('App\Models\ZipMaster','id','postcode_id');
    }

}
