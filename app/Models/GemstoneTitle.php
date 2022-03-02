<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GemstoneTitle extends Model
{
    //
    protected $table = 'gemstone_title';
    protected $guarded = [];

    public function parent()
    {
    	return $this->hasOne('App\Models\GemstoneTitle','id','parent_id')->where('parent_id','0');
    }
	/**
	*Method:productDetails
	*Description:For fetching gemstones related to category
	*Author:Madhuchandra
	*Date:2021-NOV-11
	*/
	public function productDetails()
    {
        return $this->hasMany('App\Models\Products','title_id','id');
    }
}
