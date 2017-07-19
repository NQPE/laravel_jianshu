<?php
/**
 * Created by PhpStorm.
 * User: Levi
 * Date: 2017/7/18
 * Time: 10:16
 */

namespace App\Admin\Controllers;


use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     *文章列表
     */
    public function index()
    {
        $posts=Post::withoutGlobalScope('avaiable')
            ->where('status',0)
            ->orderBy('created_at','desc')
            ->paginate(10);
        return view('admin.post.index',compact('posts'));
    }

    /**
     * 修改文章状态
     * @param Post $post
     */
    public function status(Request $request,Post $post)
    {
        //验证
        $this->validate($request,[
            'status'=>'required|integer'
        ]);
        //逻辑
        $post->status=$request->input('status');
        $post->save();

        return [
            'error'=>0,
            'msg'=>''
        ];
    }


}