<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CallPurchase extends Model
{
    //
    protected $table = 'call_purchase';
    protected $guarded = [];


    public function customer()
    {
        return $this->hasOne('App\User', 'id', 'customer_id');
    }
    public function astrologer()
    {
        return $this->hasOne('App\User', 'id', 'astrologer_id');
    }
}
