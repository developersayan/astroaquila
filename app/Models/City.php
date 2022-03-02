<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'city';
    protected $guarded = [];

	
	/**
	*Method:userDetails
	*Description:For fetching users related to country
	*Author:Madhuchandra
	*Date:2021-DEC-13
	*/
	public function userDetails()
    {
        return $this->hasMany('App\User','city','id');
	}
    public function countrylist()
    {
        return $this->hasOne('App\Models\Country','id','country_id')->orderBy('name');
    }
    public function statelist()
    {
        return $this->hasOne('App\Models\State','id','state_id')->orderBy('name');
    }
}
