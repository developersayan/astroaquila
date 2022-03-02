<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Horoscope extends Model
{
    protected $table = 'horoscope';
    protected $guarded = [];
    public function category()
    {
        return $this->hasOne('App\Models\HoroscopeCategory', 'id', 'category_id');
    }

	/**
	*Method:subcategory
	*Description:For fetching sub category related to horoscope
	*Author:Madhuchandra
	*Date:2021-DEC-11
	*/
	public function subcategory()
    {
        return $this->hasOne('App\Models\HoroscopeCategory', 'id', 'sub_category_id');
    }
	/**
	*Method:title
	*Description:For fetching title related to horoscope
	*Author:Madhuchandra
	*Date:2021-DEC-11
	*/
	public function title()
    {
        return $this->hasOne('App\Models\HoroscopeTitle', 'id', 'title_id');
	}

    public function titleName()
    {
    	return $this->hasOne('App\Models\HoroscopeTitle','id', 'title_id');

    }

    public function horoscopeExpertise()
    {
        return $this->hasMany('App\Models\HoroscopeToExpertise', 'horoscope_id', 'id');
    }
}
