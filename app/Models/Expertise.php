<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expertise extends Model
{
    protected $table = 'expertise';
    protected $guarded = [];
	/**
	*Method:userDetails
	*Description:For fetching users related to expertise
	*Author:Madhuchandra
	*Date:2021-NOV-26
	*/
	public function userDetails()
    {
        return $this->hasMany('App\Models\AstrologerToExpertise','expertise_id','id');
    }

    public function horoscopeDetails()
    {
        return $this->hasMany('App\Models\HoroscopeToExpertise','expertise_id','id');
    }
}
