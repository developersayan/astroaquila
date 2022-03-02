<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AstrologerToExpertise extends Model
{
    //
    protected $table = 'astrologer_expertise';
    protected $guarded = [];

    public function experties()
    {
        return $this->hasOne('App\Models\Expertise','id','expertise_id');
    }
}
