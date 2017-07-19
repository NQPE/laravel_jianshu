<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Builder;
use Laravel\Scout\Searchable;

class Post extends BaseModel
{
    //使用ES的搜索
    use Searchable;

    protected $table='posts';

    /**
     * 关联用户
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
    }

    /**
     * 关联评论
     */
    public function comments()
    {
        return $this->hasMany(Comment::class,'post_id','id')->orderBy('created_at','desc');
    }

    /**
     * 和用户的点赞关联
     */
    public function zan($user_id)
    {
        return $this->hasOne(Zan::class)->where('user_id',$user_id);
    }
    /**
     * 文章的所有赞
     */
    public function zans()
    {
        return $this->hasMany(Zan::class);
    }
    
    /**
     * 属于某个作者的文章
     */
    public function scopeAuthorBy(Builder $query,$user_id)
    {
        return $query->where('user_id',$user_id);
    }
    
    //关联专题 文章
    public function postTopics()
    {
        return $this->hasMany(PostTopic::class,'post_id','id');
    }
    
    /**
     * 不属于某个专题的文章
     */
    public function scopeTopicNotBy(Builder $query,$topic_id)
    {
        return $query->doesntHave('postTopics','and',function($q)use($topic_id){
            $q->where('topic_id',$topic_id);
        });
    }

    //全局的scope
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('avaiable',function(Builder $builder){
            $builder->whereIn('status',[0,1]);
        });
    }
}
