<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purpose extends Model
{
    protected $table = 'purpose';
    protected $guarded = [];
	/**
	*Method:productDetails
	*Description:For fetching product related to purpose
	*Author:Madhuchandra
	*Date:2021-NOV-16
	*/
	public function productDetails()
    {
        return $this->hasMany('App\Models\Products','purpose_id','id');
    }
	/**
	*Method:pujaDetails
	*Description:For fetching puja related to purpose
	*Author:Madhuchandra
	*Date:2021-NOV-16
	*/
	public function pujaDetails()
    {
        return $this->hasMany('App\Models\PujaToPurpose','purpose_id','id');
    }
}

