<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class regencies extends Model
{
    protected $table = 'regencies';

    public function getDistricts()
    {
        return $this->hasMany('App\Districts','regency_id','id');
    }
}
