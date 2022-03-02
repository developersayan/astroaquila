<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaqCategory extends Model
{
    protected $table = 'faq_category';
    protected $guarded = [];
	
    public function parent()
    {
    	return $this->hasOne('App\Models\FaqCategory','id','parent_id')->where('parent_id','0');
    }
	
	/**
	*Method:gemFaqDetails
	*Description:For fetching gemstones faq related to category
	*Author:Madhuchandra
	*Date:2021-NOV-18
	*/
	public function gemFaqDetails()
    {
        return $this->hasMany('App\Models\Faq','subcategory_id','id')->where('product_id',0)->where('type','G')->where('show_in_search','Y')->orderBy('display_order','desc');
    }
	/**
	*Method:astroFaqDetails
	*Description:For fetching astro product faq related to category
	*Author:Madhuchandra
	*Date:2021-NOV-18
	*/
	public function astroFaqDetails()
    {
        return $this->hasMany('App\Models\Faq','subcategory_id','id')->where('product_id',0)->where('type','P')->where('show_in_search','Y')->orderBy('display_order','desc');
    }
	/**
	*Method:pujaFaqDetails
	*Description:For fetching puja faq related to category
	*Author:Madhuchandra
	*Date:2021-NOV-18
	*/
	public function pujaFaqDetails()
    {
        return $this->hasMany('App\Models\Faq','subcategory_id','id')->where('puja_id',0)->where('type','PU')->where('show_in_search','Y')->orderBy('display_order','desc');
    }
	/**
	*Method:horoscopeFaqDetails
	*Description:For fetching horoscope faq related to category
	*Author:Madhuchandra
	*Date:2021-NOV-30
	*/
	public function horoscopeFaqDetails()
    {
        return $this->hasMany('App\Models\Faq','subcategory_id','id')->where('horoscope_id',0)->where('type','H')->where('show_in_search','Y')->orderBy('display_order','desc');
    }
	
	/**
	*Method:astrologerFaqDetails
	*Description:For fetching astrologer faq related to category
	*Author:Madhuchandra
	*Date:2021-NOV-30
	*/
	public function astrologerFaqDetails()
    {
        return $this->hasMany('App\Models\Faq','subcategory_id','id')->where('astrologer_id',0)->where('type','A')->where('show_in_search','Y')->orderBy('display_order','desc');
    }

    /**
	*Method:dataDetails
	*Description:For fetching horoscope faq related to data bank
	*Author:Sayan
	*Date:2021-DEC-20
	*/
	public function dataDetails()
    {
        return $this->hasMany('App\Models\Faq','subcategory_id','id')->where('type','D')->where('show_in_search','Y')->orderBy('display_order','desc');
    }
	
	
}
