<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HoroscopeTitle extends Model
{
    protected $table = 'horoscope_title';
    protected $guarded = [];
	/**
	*Method:horoscopeDetails
	*Description:For fetching horoscope related to title
	*Author:Madhuchandra
	*Date:2021-DEC-11
	*/
	public function horoscopeDetails()
    {
        return $this->hasMany('App\Models\Horoscope','title_id','id');
    }
}
