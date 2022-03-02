<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PujaToPurpose extends Model
{
    //
    protected $table = 'puja_to_purpose';
    protected $guarded = [];

    public function purpose()
    {
        return $this->hasOne('App\Models\Purpose', 'id','purpose_id');
    }
}
