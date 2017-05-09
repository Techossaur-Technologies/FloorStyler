<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class organization extends Model
{
    public function agencies()
    {
        return $this->hasMany('\App\model\agency')->where('status', '=', 'ALIVE')->orWhere('id', '=', '1');
    }
    public function users()
    {
        return $this->hasMany('\App\User')->where('status', '=', 'ALIVE');
    }
}
