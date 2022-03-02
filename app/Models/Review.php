<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    //
    protected $table = 'reviews';
    protected $guarded = [];

    public function customer_review()
    {
    	return $this->hasOne('App\User','id','from_user_id');
    }
}
