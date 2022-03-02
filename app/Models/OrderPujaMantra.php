<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderPujaMantra extends Model
{
    //
    protected $table = 'order_puja_add_mantra';
    protected $guarded = [];
	
	/**
	*Method: mantra
	*Description: For fetching mantra name
	*Author: Madhuchandra
	*Date: 2021-SEPT-03
	*/
	public function mantra()
    {
        return $this->hasOne('App\Models\Mantra', 'id', 'mantra_id');
    }
}
