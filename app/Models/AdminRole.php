<?php

namespace App\Models;


class AdminRole extends BaseModel
{
    protected $table='admin_roles';

    //当前角色的所有权限
    public function permissions()
    {
        return $this->belongsToMany(AdminPermission::class,'admin_permission_role','role_id','permission_id');
    }

    //给角色赋予权限
    public function addPermission($permission)
    {
        return $this->permissions()->attach($permission);
    }

    //删除角色的权限
    public function deletePermisssion($permission)
    {
        return $this->permissions()->detach($permission);
    }

    //判断角色是否有权限
    public function hasPermission($permission)
    {
        return $this->permissions->contains($permission);
    }

    /**
     * 将角色的权限只授权在给定的$permission_ids中
     * @param $permission_ids
     */
    public function editPermissionIds($permission_ids)
    {
        if(empty($permission_ids)){
            return $this->permissions()->detach();
        }
        $targetpermissions=AdminPermission::find($permission_ids);
        $originalpermissions=$this->permissions;
        $targetdiff=$targetpermissions->diff($originalpermissions);
        $originaldiff=$originalpermissions->diff($targetpermissions);
        $this->addPermission($targetdiff);
        $this->deletePermisssion($originaldiff);
        return true;

    }

}
