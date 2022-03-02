<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    //
    protected $table = 'faq';
    protected $guarded = [];

    public function category()
    {
    	return $this->hasOne('App\Models\FaqCategory','id','category_id');
    }
    public function subcategory()
    {
    	return $this->hasOne('App\Models\FaqCategory','id','subcategory_id');
    }
}
