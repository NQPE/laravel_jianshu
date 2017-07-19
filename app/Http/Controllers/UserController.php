<?php

namespace App\Http\Controllers;

use App\Common\Utils\FileUtil;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    /**
     * 个人中心页面
     * @param Request $request
     */
    public function index(Request $request,User $user)
    {
        $posts=$user->posts()->paginate(5);
        $user->load('posts','fans','stars');
        return view('user.index',compact('user','posts'));
    }

    /**
     * 个人设置页面
     * @param Request $request
     */
    public function setting(Request $request)
    {
        $user=Auth::user();
        return view('user.setting',compact('user'));
    }
    /**
     * 个人设置操作
     * @param Request $request
     */
    public function settingStore(Request $request)
    {
        //验证
        $this->validate($request,[
           'name'=>'required',
        ]);
        //逻辑
        $user=Auth::user();
        $data['name']=$request->input('name');
        if(!empty($request->allFiles())){
            $avatars=FileUtil::saveFileQiNiu($request->allFiles());
            foreach($avatars as $avatar){
                $data['avatar']=FileUtil::getPathComplete($avatar);
                break;
            }
        }
        $user->update($data);

        return redirect('/posts');
    }

    //关注某人
    public function fan(Request $request,User $user)
    {
        $me=Auth::user();
        $me->doFan($user->id);
        return ['error'=>0,
        'msg'=>''];
    }

    //取关某人
    public function unfan(Request $request,User $user)
    {
        $me=Auth::user();
        $me->doUnfan($user->id);
        return ['error'=>0,
            'msg'=>''];
    }
}
