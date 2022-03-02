<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Databank extends Model
{
    protected $table = 'data_bank';
    protected $guarded = [];

    public function countrylist()
    {
        return $this->hasOne('App\Models\Country','id','country_id')->orderBy('name');
    }
    public function statelist()
    {
        return $this->hasOne('App\Models\State','id','state_id')->orderBy('name');
    }

    public function citylist()
    {
        return $this->hasOne('App\Models\City','id','city_id')->orderBy('name');
    }

    public function professionName()
    {
        return $this->hasOne('App\Models\Profession','id','profession_id')->orderBy('name');
    }

    public function famousName()
    {
        return $this->hasOne('App\Models\Famous','id','famous_id')->orderBy('name');
    }
}
