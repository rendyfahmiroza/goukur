<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provinces extends Model
{
    protected $table = 'provinces';
    
    public function getRegencies()
    {
        return $this->hasMany('App\Regencies','province_id','id');
    }
}
