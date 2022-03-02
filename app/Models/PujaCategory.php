<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PujaCategory extends Model
{
    //
    protected $table = 'puja_categories';
    protected $guarded = [];

    public function parent()
    {
    	return $this->hasOne('App\Models\PujaCategory','id','parent_id')->where('parent_id','0');
    }
	/**
	*Method:pujaDetails
	*Description:For fetching puja related to category
	*Author:Madhuchandra
	*Date:2021-NOV-16
	*/
	public function pujaDetails()
    {
        return $this->hasMany('App\Models\Puja','puja_category','id');
    }
	
	/**
	*Method:pujaDetailsSubCategory
	*Description:For fetching puja related to sub category
	*Author:Madhuchandra
	*Date:2021-NOV-16
	*/
	public function pujaDetailsSubCategory()
    {
        return $this->hasMany('App\Models\Puja','puja_sub_category','id');
    }
}
