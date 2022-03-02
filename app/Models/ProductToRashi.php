<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductToRashi extends Model
{
    //
    protected $table = 'product_to_rashi';
    protected $guarded = [];
    public function rashis()
    {
    	return $this->hasOne('App\Models\Rashi', 'id', 'rashi_id');
    }
}
