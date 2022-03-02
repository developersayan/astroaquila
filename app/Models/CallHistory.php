<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CallHistory extends Model
{
    protected $table = 'call_history';
    protected $guarded = [];

	/**
     *   Method      : orderDetails
     *   Description : for fetching order details
     *   Author      : Madhuchandra
     *   Date        : 2021-DEC-03
     **/
	public function orderDetails()
    {
        return $this->hasOne('App\Models\OrderMaster', 'id', 'order_id')->where('status','!=','T');
    }


}
