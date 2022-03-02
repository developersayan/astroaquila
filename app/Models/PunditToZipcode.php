<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PunditToZipcode extends Model
{
    //
    protected $table = 'pundit_to_zipcode';
    protected $guarded = [];

    public function zip()
    {
        return $this->hasOne('App\Models\ZipMaster', 'id', 'zipcode_id');
    }
}
