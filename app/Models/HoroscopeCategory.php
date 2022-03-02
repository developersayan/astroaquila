<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HoroscopeCategory extends Model
{
    protected $table = 'horoscope_category';
    protected $guarded = [];
	/**
	*Method:horoscopeDetails
	*Description:For fetching horoscopes related to category
	*Author:Madhuchandra
	*Date:2021-NOV-26
	*/
	public function horoscopeDetails()
    {
        return $this->hasMany('App\Models\Horoscope','category_id','id');
    }

    public function parent()
    {
    	return $this->hasOne('App\Models\HoroscopeCategory','id','parent_id')->where('parent_id','0');
    }
	/**
	*Method:horoscopeDetailsSubCategory
	*Description:For fetching horoscope related to sub category
	*Author:Madhuchandra
	*Date:2021-DEC-11
	*/
	public function horoscopeDetailsSubCategory()
    {
        return $this->hasMany('App\Models\Horoscope','sub_category_id','id');
    }
}
