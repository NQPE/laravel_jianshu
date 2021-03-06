<?php

namespace App\Models;


class AdminPermission extends BaseModel
{
    protected $table='admin_permissions';

    //权限属于那些角色
    public function roles()
    {
        return $this->belongsToMany(AdminRole::class,'admin_permission_role','permission_id','role_id');
    }
}
