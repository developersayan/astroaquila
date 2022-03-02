<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $table = 'product_category';
    protected $guarded = [];
    public function parent()
    {
    	return $this->hasOne('App\Models\ProductCategory','id','parent_id')->where('parent_id','0');
    }
	/**
	*Method:productDetails
	*Description:For fetching product related to category
	*Author:Madhuchandra
	*Date:2021-NOV-16
	*/
	public function productDetails()
    {
        return $this->hasMany('App\Models\Products','category_id','id');
    }
	/**
	*Method:productDetails
	*Description:For fetching product related to sub category
	*Author:Madhuchandra
	*Date:2021-NOV-16
	*/
	public function productDetailsSubCategory()
    {
        return $this->hasMany('App\Models\Products','sub_category_id','id');
    }
}
