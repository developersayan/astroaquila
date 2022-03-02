<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductGemstonePrice extends Model
{
    protected $table = 'product_gemstone_price';
    protected $guarded = [];
	/**
	*Method: gemstoneDetails
	*Description: To fetch the gemstone details
	*Author: Madhuchandra
	*Date: 2021-SEPT-17
	*/
	public function gemstoneDetails()
    {
    	return $this->hasOne('App\Models\Products', 'id', 'product_id');
    }
}
