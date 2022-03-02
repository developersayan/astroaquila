<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cirtificate extends Model
{
    //
    protected $table = 'cirtification';
    protected $guarded = [];

    public function certificate_name()
    {
    	return $this->hasOne('App\Models\CertificationName', 'id', 'certificate_id');
    }
}
