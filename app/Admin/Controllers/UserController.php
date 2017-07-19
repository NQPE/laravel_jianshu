<?php
/**
 * Created by PhpStorm.
 * User: Levi
 * Date: 2017/7/18
 * Time: 10:16
 */

namespace App\Admin\Controllers;


use App\Common\Utils\FileUtil;
use App\Models\AdminRole;
use App\Models\AdminUser;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * 人员列表页面
     */
    public function index()
    {
        $users = AdminUser::paginate(5);
        return view('admin.user.index', compact('users'));
    }

    /**
     * 添加人员页面
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * 添加人员逻辑
     */
    public function store(Request $request)
    {
        //验证
        $this->validate($request, [
            'name' => 'required|unique:admin_users',
            'password' => 'required',
        ]);
        //逻辑
        $data['name'] = $request->input('name');
        $data['password'] = bcrypt($request->input('password'));
        if (!empty($request->allFiles())) {
            $avatars = FileUtil::saveFileQiNiu($request->allFiles());
            foreach ($avatars as $avatar) {
                $data['avatar'] = FileUtil::getPathComplete($avatar);
                break;
            }
        }
        AdminUser::create($data);

        //渲染
        return redirect('/admin/users');
    }

    /**
     * 用户关联页面
     */
    public function role(AdminUser $user)
    {
        $roles = AdminRole::all();
        foreach ($roles as &$role) {
            if ($user->hasRole($role)) {
                $role->check = 1;
                continue;
            }
            $role->check = 0;
        }
        return view('admin.user.user_role', compact('user', 'roles'));
    }

    /**
     * 角色权限关联操作
     * @param Request $request
     * @param AdminRole $role
     */
    public function storeRole(Request $request, AdminUser $user)
    {
        $role_ids = $request->input('roles');
        $user->editRoleIds($role_ids);
        return redirect('admin/users');

    }
}