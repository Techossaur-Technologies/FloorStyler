<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class agency extends Model
{
    public function organization()
    {
    	return $this->belongsTo('\App\model\organization');
    }
}
