<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerAddressBook extends Model
{
    //
    protected $table = 'customer_address_book';
    protected $guarded = [];

    public function countryDetails(){
        return $this->hasOne('App\Models\Country', 'id', 'country');
    }
    public function stateDetails(){
        return $this->hasOne('App\Models\State', 'id', 'state');
    }
    public function cityDetails(){
        return $this->hasOne('App\Models\City', 'id', 'city');
    }
    public function areaDetails(){
        return $this->hasOne('App\Models\Area', 'id', 'area');
    }
}
