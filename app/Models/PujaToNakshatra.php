<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PujaToNakshatra extends Model
{
    protected $table = 'puja_to_nakshatra';
    protected $guarded = [];
	public function nakshatras()
    {
    	return $this->hasOne('App\Models\Nakshatras', 'id', 'nakshatra_id');
    }
}
