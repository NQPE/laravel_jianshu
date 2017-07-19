<?php

namespace App\Models;


class Zan extends BaseModel
{
    /**
     * 关联文章
     */
    public function post()
    {
        return $this->belongsTo(Post::class,'post_id');
    }

    /**
     * 关联用户
     */
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
