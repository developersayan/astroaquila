<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PujaName extends Model
{
    protected $table = 'puja_name';
    protected $guarded = [];
	/**
	*Method:pujaDetails
	*Description:For fetching puja related to category
	*Author:Madhuchandra
	*Date:2021-NOV-16
	*/
	public function pujaDetails()
    {
        return $this->hasMany('App\Models\Puja','puja_id','id');
    }
}
