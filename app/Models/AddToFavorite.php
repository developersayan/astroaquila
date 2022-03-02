<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddToFavorite extends Model
{
    //
    protected $table = 'add_to_favorite';
    protected $guarded = [];

    public function product()
    {
        return $this->hasOne('App\Models\Products', 'id', 'product_id');
    }

}
