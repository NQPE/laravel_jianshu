<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }


    /**
     * 判断用户是否有更新文章的权限
     * @param User $user
     * @param Post $post
     * @return bool
     */
    public function update(User $user,Post $post)
    {
        return $user->id===$post->user_id;
    }

    /**
     * 判断用户是否有删除文章的权限
     * @param User $user
     * @param Post $post
     * @return bool
     */
    public function delete(User $user,Post $post)
    {
        return $user->id===$post->user_id;
    }
}
