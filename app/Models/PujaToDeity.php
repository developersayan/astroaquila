<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PujaToDeity extends Model
{
    //
    protected $table = 'puja_to_deity';
    protected $guarded = [];
    public function deity()
    {
        return $this->hasOne('App\Models\Deity', 'id','deity_id');
    }
}
