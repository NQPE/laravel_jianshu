<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as AuthUser;

class AdminUser extends AuthUser
{
    protected $table='admin_users';

    protected $rememberTokenName = '';
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

    //用户有哪些角色
    public function roles()
    {
        return $this->belongsToMany(AdminRole::class,'admin_role_user','user_id','role_id');
    }

    //判断是否有某个角色 某些角色
    public function isInRoles(Collection $roles){
        return !!$roles->intersect($this->roles)->count();
    }

    //判断用户是否有角色
    public function hasRole($role)
    {
        return $this->roles->contains($role);
    }

    //给用户分配角色
    public function addRole($role)
    {
        return $this->roles()->attach($role);
    }

    //取消用户的某个角色
    public function deleteRole($role)
    {
        return $this->roles()->detach($role);
    }
    
    //用户是否有权限
    public function hasPermission($permission)
    {
        return $this->isInRoles($permission->roles);
    }

    /**
     * 将用户的角色只分配在给定的$role_ids中
     * @param $role_ids
     */
    public function editRoleIds($role_ids)
    {
        if(empty($role_ids)){
            return $this->roles()->detach();
        }
        $targetroles=AdminRole::find($role_ids);
        $originalroles=$this->roles;
        $targetdiff=$targetroles->diff($originalroles);
        $originaldiff=$originalroles->diff($targetroles);
        $this->addRole($targetdiff);
        $this->deleteRole($originaldiff);
        return true;

    }
}
