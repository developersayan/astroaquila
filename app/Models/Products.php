<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    //
    protected $table = 'products';
    protected $guarded = [];
    public function productscat()
    {
        return $this->hasOne('App\Models\ProductCategory','id','category_id');
    }
    public function products_subcat()
    {
        return $this->hasOne('App\Models\ProductCategory','id','sub_category_id');
    }
    public function productdefault()
    {
        return $this->hasOne('App\Models\ProductToImage', 'product_id', 'id')->where('is_default','Y')->where('type','I');
    }
     public function productVideo()
    {
        return $this->hasOne('App\Models\ProductToImage', 'product_id', 'id')->where('type','V');
    }
    public function productimgs()
    {
        return $this->hasMany('App\Models\ProductToImage', 'product_id', 'id')->where('type','I');
    }

    public function productPlanets()
    {
        return $this->hasMany('App\Models\ProductToPlanet', 'product_id', 'id');
    }

    public function productRashi()
    {
        return $this->hasMany('App\Models\ProductToRashi', 'product_id', 'id');
    }
    public function productTreatment()
    {
        return $this->hasMany('App\Models\GemstoneToTreatment', 'gemstone_id', 'id');
    }

    public function productDeity()
    {
        return $this->hasMany('App\Models\ProductToDeity', 'product_id', 'id');
    }

    public function productNakshtra()
    {
        return $this->hasMany('App\Models\ProductToNakshatras', 'product_id', 'id');
    }

    public function country_name()
    {
        return $this->hasOne('App\Models\Country', 'id', 'country_of_origin');
    }
    public function purpose_name()
    {
        return $this->hasOne('App\Models\Purpose', 'id', 'purpose_id');
    }

     public function seller()
    {
        return $this->hasOne('App\Models\SellerMaster','id','seller_id');
    }
	public function gemstoneTreatment()
    {
        return $this->hasMany('App\Models\GemstoneToTreatment', 'gemstone_id', 'id');
    }

    public function gemcategory()
    {
         return $this->hasOne('App\Models\GemstoneCategory','id','category_id');
    }

    public function subtitle()
    {
        return $this->hasOne('App\Models\GemstoneTitle','id','subtitle_id');
    }

   public function title()
   {
        return $this->hasOne('App\Models\GemstoneTitle','id','title_id');
   }
    public function stone()
    {
        return $this->hasOne('App\Models\StoneType','slug','stone_type');
    }

    public function shape()
    {
        return $this->hasOne('App\Models\GemstoneShape','id','shape_id');
    }

    public function cut()
    {
        return $this->hasOne('App\Models\GemstoneCut','id','cut_id');
    }
    
    public function colors()
    {
        return $this->hasOne('App\Models\GemstoneColor','id','color_id');
    }
	public function gemstoneFaq()
    {
        return $this->hasMany('App\Models\Faq','product_id','id')->where('type','G');
    }

    public function labname()
    {
        return $this->hasOne('App\Models\CertificationName','id','laboratory_name');
    }



   
}
