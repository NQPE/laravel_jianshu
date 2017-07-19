<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /**
     * 注册页面
     * @param Request $request
     */
    public function index(Request $request)
    {
        return view('register/index');
    }
    /**
     * 注册操作
     * @param Request $request
     */
    public function register(Request $request)
    {
        //验证
        $this->validate($request,[
           'name'=>'required',
           'email'=>'required|email|unique:users',
           'password'=>'required|confirmed|min:6|max:20',
        ]);
        //逻辑
        $data['name']=$request->input('name');
        $data['email']=$request->input('email');
        $data['password']=bcrypt($request->input('password'));
        User::create($data);

        //渲染
        return redirect('/posts');
    }
}
