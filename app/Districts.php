<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class districts extends Model
{
    protected $table = 'districts';

    public function getVillages()
    {
        return $this->hasMany('App\Villages','district_id','id');
    }
}
