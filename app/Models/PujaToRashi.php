<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PujaToRashi extends Model
{
    protected $table = 'puja_to_rashi';
    protected $guarded = [];
	public function rashis()
    {
    	return $this->hasOne('App\Models\Rashi', 'id', 'rashi_id');
    }
}
