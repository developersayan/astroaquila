<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GemstoneToTreatment extends Model
{
    protected $table = 'gemstone_to_treatment';
    protected $guarded = [];
    public function treatname()
    {
    	return $this->hasOne('App\Models\Treatment', 'slug', 'treatment');
    }
}
