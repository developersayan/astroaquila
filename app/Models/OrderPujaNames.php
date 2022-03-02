<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderPujaNames extends Model
{
    //
    protected $table = 'order_puja_user_names';
    protected $guarded = [];

    public function gotras()
    {
    	return $this->hasOne('App\Models\Gotra','id','gotra');
    }

    public function rashis()
    {
    	return $this->hasOne('App\Models\Rashi','id','janam_rashi_lagna');
    }

    public function nakshatras()
    {
    	return $this->hasOne('App\Models\Nakshatras','id','janama_nkshatra');
    }

}
