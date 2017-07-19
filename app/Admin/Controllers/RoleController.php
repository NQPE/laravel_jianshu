<?php
/**
 * Created by PhpStorm.
 * User: Levi
 * Date: 2017/7/18
 * Time: 10:16
 */

namespace App\Admin\Controllers;


use App\Common\Utils\FileUtil;
use App\Models\AdminPermission;
use App\Models\AdminRole;
use App\Models\AdminUser;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * 角色列表页面
     */
    public function index()
    {
        $roles=AdminRole::paginate(5);
        return view('admin.role.index',compact('roles'));
    }
    /**
     * 添加角色页面
     */
    public function create()
    {
        return view('admin.role.create');
    }
    /**
     * 添加角色逻辑
     */
    public function store(Request $request)
    {
        //验证
        $this->validate($request,[
            'name'=>'required|unique:admin_roles',
        ]);
        //逻辑
        $data['name']=$request->input('name');
        $data['desc']=$request->input('desc');

        AdminRole::create($data);

        //渲染
        return redirect('/admin/roles');
    }

    /**
     * 角色权限关联页面
     */
    public function permission(AdminRole $role)
    {
        $permissions=AdminPermission::all();
        foreach($permissions as &$permission){
            if($role->hasPermission($permission)){
                $permission->check=1;
                continue;
            }
            $permission->check=0;
        }
        return view('admin.role.role_permission',compact('role','permissions'));
    }

    /**
     * 角色权限关联操作
     * @param Request $request
     * @param AdminRole $role
     */
    public function storePermission(Request $request, AdminRole $role)
    {
        $permission_ids=$request->input('permissions');
        $role->editPermissionIds($permission_ids);

        return redirect('admin/roles');

    }
}