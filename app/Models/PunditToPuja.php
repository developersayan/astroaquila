<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PunditToPuja extends Model
{
    //
    protected $table = 'pundit_to_pujas';
    protected $guarded = [];

    public function pujas()
    {
        return $this->hasOne('App\Models\Puja', 'id', 'puja_id');
    }
    public function users()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
    public function zipcode()
    {
        return $this->hasMany('App\Models\PunditToZipcode', 'pundit_id','user_id');
    }
}
