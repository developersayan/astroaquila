<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PujaEnergization extends Model
{
    //
    protected $table = 'puja_energization';
    protected $guarded = [];

    public function puja_name()
    {
    	return $this->hasOne('App\Models\EnergizationPuja', 'id', 'puja_id');
    }
}
