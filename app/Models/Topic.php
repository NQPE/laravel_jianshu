<?php

namespace App\Models;



class Topic extends BaseModel
{
    //专题下所拥有的文章
    public function posts()
    {
        return $this->belongsToMany(Post::class,'post_topics','topic_id','post_id')->orderBy('created_at','desc');
    }
    //专题的文章数 用于withCount
    public function postTopics()
    {
        return $this->hasMany(PostTopic::class,'topic_id');
    }
}
