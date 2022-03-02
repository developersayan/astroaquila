<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RingSize extends Model
{
    //
    protected $table = 'ring_size';
    protected $guarded = [];
    public function system()
    {
        return $this->hasOne('App\Models\RingSystem', 'id', 'ring_size_system_id');
    }
}
