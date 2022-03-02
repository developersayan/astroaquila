<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Country;
class State extends Model
{
    protected $table = 'states';
    protected $guarded = [];
  
    public $timestamps = false;
   public function countrylist()
    {
        return $this->hasOne('App\Models\Country','id','country_id')->orderBy('name');
    }
	
	/**
	*Method:userDetails
	*Description:For fetching users related to country
	*Author:Madhuchandra
	*Date:2021-DEC-13
	*/
	public function userDetails()
    {
        return $this->hasMany('App\User','state','id');
    }
}
