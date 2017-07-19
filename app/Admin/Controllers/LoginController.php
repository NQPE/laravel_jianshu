<?php
/**
 * Created by PhpStorm.
 * User: Levi
 * Date: 2017/7/18
 * Time: 10:16
 */

namespace App\Admin\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * 登录页面
     */
    public function index()
    {
        return view('admin.login.index');
    }

    /**
     * 登录逻辑
     * @param Request $request
     */
    public function login(Request $request)
    {
//验证
        $this->validate($request,[
            'name'=>'required',
            'password'=>'required',
        ]);
        //逻辑
        $user=$request->only(['name','password']);
        if(!Auth::guard('admin')->attempt($user)){
            return redirect()->back()->withErrors('用户名密码不匹配')->withInput();
        }

        //渲染
        return redirect('/admin/index');
    }

    /**
     * 登出逻辑
     * @param Request $request
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        return redirect('/admin/login');
    }
}