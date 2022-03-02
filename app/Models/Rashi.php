<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rashi extends Model
{
    protected $table = 'rashis';
    protected $guarded = [];
	/**
	*Method:productDetails
	*Description:For fetching gemstones related to category
	*Author:Madhuchandra
	*Date:2021-NOV-11
	*/
	public function productDetails()
    {
        return $this->hasMany('App\Models\ProductToRashi','rashi_id','id');
    }
	/**
	*Method:pujaDetails
	*Description:For fetching puja related to planet
	*Author:Madhuchandra
	*Date:2021-NOV-16
	*/
	public function pujaDetails()
    {
        return $this->hasMany('App\Models\PujaToRashi','rashi_id','id');
    }
}
