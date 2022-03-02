<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Remedy extends Model
{
    //
    protected $table = 'remedies';
    protected $guarded = [];

     public function remedytype()
    {
        return $this->hasOne('App\Models\Expertise', 'id', 'type_id');
    }
}
