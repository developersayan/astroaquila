<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    //
    protected $table = 'cart_details';
    protected $guarded = [];

    public function productDefault()
    {
        return $this->hasOne('App\Models\ProductToImage', 'product_id', 'product_id')->where('is_default','Y');
    }
    public function product()
    {
        return $this->hasOne('App\Models\Products', 'id', 'product_id');
    }

    public function cirtificate()
    {
        return $this->hasOne('App\Models\Cirtificate', 'id', 'certificate_id');
    }
    public function puja()
    {
        return $this->hasOne('App\Models\PujaEnergization', 'id', 'puja_energization_id');
    }
}
