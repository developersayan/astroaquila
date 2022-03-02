<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LanguageSpeak extends Model
{
    protected $table = 'language_speakes';
    protected $guarded = [];
	/**
	*Method:userDetails
	*Description:For fetching users related to expertise
	*Author:Madhuchandra
	*Date:2021-NOV-26
	*/
	public function userDetails()
    {
        return $this->hasMany('App\Models\AstrologerToLanguages','language_id','id');
    }
}
