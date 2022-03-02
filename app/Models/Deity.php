<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deity extends Model
{
    protected $table = 'deity';
    protected $guarded = [];
	/**
	*Method:productDetails
	*Description:For fetching gemstones related to deity
	*Author:Madhuchandra
	*Date:2021-NOV-11
	*/
	public function productDetails()
    {
        return $this->hasMany('App\Models\ProductToDeity','deity_id','id');
    }
	/**
	*Method:pujaDetails
	*Description:For fetching puja related to deity
	*Author:Madhuchandra
	*Date:2021-NOV-16
	*/
	public function pujaDetails()
    {
        return $this->hasMany('App\Models\PujaToDeity','deity_id','id');
    }
}
