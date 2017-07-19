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
use App\Models\AdminUser;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * 权限列表页面
     */
    public function index()
    {
        $permissions=AdminPermission::paginate(5);
        return view('admin.permission.index',compact('permissions'));
    }
    /**
     * 添加权限页面
     */
    public function create()
    {
        return view('admin.permission.create');
    }
    /**
     * 添加权限逻辑
     */
    public function store(Request $request)
    {
        //验证
        $this->validate($request,[
            'name'=>'required|unique:admin_permissions',
        ]);
        //逻辑
        $data['name']=$request->input('name');
        $data['desc']=$request->input('desc');

        AdminPermission::create($data);

        //渲染
        return redirect('/admin/permissions');
    }
}