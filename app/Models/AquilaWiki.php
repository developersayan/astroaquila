<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AquilaWiki extends Model
{
    protected $table = 'aquila_wiki';
    protected $guarded = [];

    public function getCategory()
    {
    	return $this->hasOne('App\Models\WikiCategory','id','category');
    }
    public function getSubCategory()
    {
    	return $this->hasOne('App\Models\WikiCategory','id','subcategory');
    }
    public function getTitle()
    {
    	return $this->hasOne('App\Models\WikiTitle','id','title');
    }
}
