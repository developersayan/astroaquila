<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nakshatras extends Model
{
    protected $table = 'nakshatras';
    protected $guarded = [];
	/**
	*Method:productDetails
	*Description:For fetching gemstones related to category
	*Author:Madhuchandra
	*Date:2021-NOV-11
	*/
	public function productDetails()
    {
        return $this->hasMany('App\Models\ProductToNakshatras','nakshatra_id','id');
    }
	/**
	*Method:pujaDetails
	*Description:For fetching puja related to planet
	*Author:Madhuchandra
	*Date:2021-NOV-16
	*/
	public function pujaDetails()
    {
        return $this->hasMany('App\Models\PujaToNakshatra','nakshatra_id','id');
    }
}
