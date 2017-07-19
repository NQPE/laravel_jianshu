<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as AuthUser;

class User extends AuthUser
{
    /**
     * 软删除
     */
    use SoftDeletes;
    /**
     * 不可被批量赋值的属性。
     *
     * @var array
     */
    protected $guarded = [];

    //用户文章列表
    public function posts()
    {
        return $this->hasMany(Post::class,'user_id','id')->orderBy('created_at','desc');
    }

    //关注我的Fan模型
    public function fans()
    {
        return $this->hasMany(Fan::class,'star_id','id');
    }

    //我关注的Fan模型
    public function stars()
    {
        return $this->hasMany(Fan::class,'fan_id','id');
    }
    
    //关注某人
    public function doFan($uid)
    {
        $fan=new Fan();
        $fan->star_id=$uid;
        return $this->stars()->save($fan);
    }
    
    //取关某人
    public function doUnfan($uid)
    {
        $fan=new Fan();
        $fan->star_id=$uid;
        return $this->stars()->delete($fan);
    }

    //当前用户是否被uid关注了
    public function hasFan($uid)
    {
        return $this->fans()->where('fan_id',$uid)->count();
    }

    //当前用户是否关注了uid
    public function hasStar($uid)
    {
        return $this->stars()->where('star_id',$uid)->count();
    }

    //系统通知
    public function notices()
    {
        return $this->belongsToMany(Notice::class,'user_notice','user_id','notice_id');
    }

    //给用户增加通知
    public function addNotice($notice)
    {
        return $this->notices()->save($notice);
    }

}
