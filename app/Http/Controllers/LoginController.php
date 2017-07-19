<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * 登录页面
     * @param Request $request
     */
    public function index(Request $request)
    {
        return view('login/index');
    }

    /**
     * 登录操作
     * @param Request $request
     */
    public function login(Request $request)
    {
        //验证
        $this->validate($request,[
            'email'=>'required|email',
            'password'=>'required|min:6|max:20',
            'is_remember'=>'integer',
        ]);
        //逻辑
        $user=$request->only(['email','password']);
        $is_remember=boolval($request->input('is_remember'));
        if(!Auth::attempt($user,$is_remember)){
            return redirect()->back()->withErrors('邮箱密码不匹配')->withInput();
        }

        //渲染
        return redirect('/posts');

    }

    /**
     * 登出操作
     * @param Request $request
     */
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/login');
    }
}
