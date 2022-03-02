<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AstrologerPersonTemp extends Model
{
    protected $table = 'astrologer_person_temp';
    protected $guarded = [];
	
	public function gotras()
    {
    	return $this->hasOne('App\Models\Gotra','id','gotra');
    }

    public function rashis()
    {
    	return $this->hasOne('App\Models\Rashi','id','janam_rashi');
    }

    public function nakshatras()
    {
    	return $this->hasOne('App\Models\Nakshatras','id','janam_nakshatra');
    }
}
