<?php

namespace App\Models;


class Fan extends BaseModel
{
    protected $table='fans';

    //粉丝
    public function fuser()
    {
        return $this->hasOne(User::class,'id','fan_id');
    }
    //关注者
    public function suser()
    {
        return $this->hasOne(User::class,'id','star_id');
    }
}
