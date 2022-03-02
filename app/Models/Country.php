<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'countries';
    protected $guarded = [];
	
	/**
	*Method:userDetails
	*Description:For fetching users related to country
	*Author:Madhuchandra
	*Date:2021-DEC-13
	*/
	public function userDetails()
    {
        return $this->hasMany('App\User','country_id','id');
    }
}
