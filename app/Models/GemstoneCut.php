<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GemstoneCut extends Model
{
    protected $table = 'gemstone_cuts';
    protected $guarded = [];
	/**
	*Method:productDetails
	*Description:For fetching gemstones related to category
	*Author:Madhuchandra
	*Date:2021-NOV-11
	*/
	public function productDetails()
    {
        return $this->hasMany('App\Models\Products','cut_id','id');
    }
}
