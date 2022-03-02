<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WikiCategory extends Model
{
    protected $table = 'aquila_wiki_category';
    protected $guarded = [];
    public function parent()
    {
    	return $this->hasOne('App\Models\WikiCategory','id','parent_id')->where('parent_id','0');
    }
}
