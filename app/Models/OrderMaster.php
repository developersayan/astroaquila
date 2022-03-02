<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderMaster extends Model
{
    //
    protected $table = 'ordermaster';
    protected $guarded = [];


    public function customer()
    {
        return $this->hasOne('App\User', 'id', 'customer_id');
    }
    public function astrologer()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
    public function pundit()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
    public function pujas()
    {
        return $this->hasOne('App\Models\Puja', 'id', 'puja_id');
    }
    public function horoscope()
    {
        return $this->hasOne('App\Models\Horoscope', 'id', 'horoscope_id');
    }

    public function review()
    {
        return $this->hasOne('App\Models\Review', 'ordermaster_id', 'id');
    }

    public function orderDetails()
    {
        return $this->hasMany('App\Models\OrderDetails', 'order_master_id', 'id')->with('product');
    }

    public function country(){
        return $this->hasOne('App\Models\Country', 'id', 'shipping_country');
    }

    public function country_horoscope(){
        return $this->hasOne('App\Models\Country', 'id', 'country_id');
    }


    public function state(){
        return $this->hasOne('App\Models\State', 'id', 'shipping_state');
    }
    public function city(){
        return $this->hasOne('App\Models\City', 'id', 'shipping_city');
    }
    public function area(){
        return $this->hasOne('App\Models\Area', 'id', 'shipping_area');
    }
    public function billingCountry(){
        return $this->hasOne('App\Models\Country', 'id', 'billing_country');
    }
    public function billingState(){
        return $this->hasOne('App\Models\State', 'id', 'billing_state');
    }
    public function billingCity(){
        return $this->hasOne('App\Models\City', 'id', 'billing_city');
    }
    public function billingArea(){
        return $this->hasOne('App\Models\Area', 'id', 'billing_area');
    }

    public function expertise_name(){
        return $this->hasOne('App\Models\Expertise','id','expertise');
    }
	/**
	*Method: mantraDetails
	*Description: For fetching additional mantra added
	*Author: Madhuchandra
	*Date: 2021-SEPT-03
	*/
	public function mantraDetails()
    {
        return $this->hasMany('App\Models\OrderPujaMantra', 'order_master_id', 'id')->with('mantra');
    }

    /**
    *Method: currencyDetails
    *Description: For fetching currency symbol
    *Author: Sayan
    *Date: 2021-SEPT-22
    */

    public function currencyDetails()
    {
         return $this->hasOne('App\Models\Currencys', 'id', 'currency_id');
    }


    /**
    *Method: callHistory
    *Description: For fetching call history table data
    *Author: Sayan
    *Date: 2021-DEC-3
    */

    public function callHistory()
    {
         return $this->hasOne('App\Models\CallHistory', 'order_id', 'id');
    }
    /**
     *   Method      : orderPujaNames
     *   Description : for fetching order puja names
     *   Author      : Argha
     *   Date        : 2021-DEC-14
     **/
	public function orderPujaNames()
    {
        return $this->hasOne('App\Models\OrderPujaNames', 'ordermaster_id', 'id');
    }
}
