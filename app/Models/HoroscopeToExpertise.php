<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HoroscopeToExpertise extends Model
{
    protected $table = 'horoscope_expertise';
    protected $guarded = [];

    public function name()
    {
    	return $this->hasOne('App\Models\Expertise','id','expertise_id');
    }
}
