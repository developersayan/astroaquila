<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    //
    protected $table = 'order_details';
    protected $guarded = [];

    public function product()
    {
        return $this->hasOne('App\Models\Products', 'id', 'product_id');
    }
}
