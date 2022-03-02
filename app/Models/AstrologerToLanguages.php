<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AstrologerToLanguages extends Model
{
    protected $table = 'astrologer_to_languages';
    protected $guarded = [];
    
    public function languages()
    {
    	return $this->hasOne('App\Models\LanguageSpeak', 'id', 'language_id');
    }
}
