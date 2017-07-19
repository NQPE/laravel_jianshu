<?php

namespace App\Providers;

use App\Models\AdminPermission;
use App\Models\Post;
use App\Policies\PostPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
//        'App\Model' => 'App\Policies\ModelPolicy',
        Post::class=>PostPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //注册权限
        $permissions=AdminPermission::all();
        foreach($permissions as $permission){
            Gate::define($permission->name,function($user)use($permission){
                return $user->hasPermission($permission);
            });
        }
    }
}
