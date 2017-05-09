<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class assignment extends Model
{
    public function organization()
    {
    	return $this->belongsTo('\App\model\organization');
    }
    public function user()
    {
    	return $this->belongsTo('\App\User');
    }
    public function agency()
    {
    	return $this->belongsTo('\App\model\agency');
    }
    public function raw_plan()
    {
        return $this->hasMany('App\model\raw_plan');
    }
}
