<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductToPlanet extends Model
{
    //
    protected $table = 'product_to_planet';
    protected $guarded = [];
    public function planets()
    {
    	return $this->hasOne('App\Models\Planets', 'id', 'planet_id');
    }
}
