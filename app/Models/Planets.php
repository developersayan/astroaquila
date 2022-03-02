<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Planets extends Model
{
    protected $table = 'planets';
    protected $guarded = [];
	/**
	*Method:productDetails
	*Description:For fetching gemstones related to category
	*Author:Madhuchandra
	*Date:2021-NOV-11
	*/
	public function productDetails()
    {
        return $this->hasMany('App\Models\ProductToPlanet','planet_id','id');
    }
	/**
	*Method:pujaDetails
	*Description:For fetching puja related to planet
	*Author:Madhuchandra
	*Date:2021-NOV-16
	*/
	public function pujaDetails()
    {
        return $this->hasMany('App\Models\PujaToPlanet','planet_id','id');
    }
}
