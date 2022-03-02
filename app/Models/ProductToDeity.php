<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductToDeity extends Model
{
    //
    protected $table = 'product_to_deity';
    protected $guarded = [];
    public function deities()
    {
    	return $this->hasOne('App\Models\Deity', 'id', 'deity_id');
    }
}
