<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GemstoneShape extends Model
{
    protected $table = 'gemstone_shapes';
    protected $guarded = [];
	/**
	*Method:productDetails
	*Description:For fetching gemstones related to category
	*Author:Madhuchandra
	*Date:2021-NOV-11
	*/
	public function productDetails()
    {
        return $this->hasMany('App\Models\Products','shape_id','id');
    }
}
