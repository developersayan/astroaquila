<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PujaOrder extends Model
{
    //
    protected $table = 'puja_order';
    protected $guarded = [];


    public function customer()
    {
        return $this->hasOne('App\User', 'id', 'customer_id');
    }
    public function pundit()
    {
        return $this->hasOne('App\User', 'id', 'pundit_id');
    }
    public function pujas()
    {
        return $this->hasOne('App\Models\Puja', 'id', 'puja_id');
    }
}
