<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Puja extends Model
{
    //
    protected $table = 'pujas';
    protected $guarded = [];

    public function pujaDeity()
    {
        return $this->hasMany('App\Models\PujaToDeity', 'puja_id', 'id');
    }

    public function pujaPurpose()
    {
        return $this->hasMany('App\Models\PujaToPurpose', 'puja_id', 'id');
    }

    public function category()
    {
        return $this->hasOne('App\Models\PujaCategory', 'id', 'puja_category')->where('parent_id',0);
    }
        public function subcategory()
    {
        return $this->hasOne('App\Models\PujaCategory', 'id', 'puja_sub_category')->where('parent_id','!=',0);
    }
    public function pujaPandit()
    {
        return $this->hasMany('App\Models\PunditToPuja', 'puja_id', 'id');
    }
	public function pujaPlanet()
    {
        return $this->hasMany('App\Models\PujaToPlanet', 'puja_id', 'id');
    }
	public function pujaRashi()
    {
        return $this->hasMany('App\Models\PujaToRashi', 'puja_id', 'id');
    }
	public function pujaNakshatra()
    {
        return $this->hasMany('App\Models\PujaToNakshatra', 'puja_id', 'id');
    }
     public function pujaName()
    {
        return $this->hasOne('App\Models\PujaName', 'id', 'puja_id');
    }
}
