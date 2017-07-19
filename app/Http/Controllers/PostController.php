<?php

namespace App\Http\Controllers;

use App\Common\Utils\FileUtil;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Zan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * 文章列表页面
     * @param Request $request
     */
    public function index(Request $request)
    {
        $posts=Post::orderBy('created_at','desc')->with('user')->withCount('comments','zans')->paginate(5);
        return view('post.index',compact('posts'));
    }
    /**
     * 文章详情页面
     * @param Request $request
     */
    public function show(Request $request,Post $post)
    {
        //预加载
        $post->load('comments','comments.user');
        return view('post.show',compact('post'));
    }
    /**
     * 创建文章页面
     * @param Request $request
     */
    public function create(Request $request)
    {
        return view('post.create');
    }
    /**
     * 创建文章存储逻辑
     * @param Request $request
     */
    public function store(Request $request)
    {
//        dd($request->input());
        //验证
        $validator=$this->getPostValidator($request);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        //逻辑
        $param=$request->only(['title','content']);
        $user_id=Auth::id();
        $param=array_merge($param,compact('user_id'));
        Post::create($param);
        //渲染
        return redirect('/posts');
    }
    /**
     * 编辑文章页面
     * @param Request $request
     */
    public function edit(Request $request,Post $post)
    {
        return view('post.edit',compact('post'));
    }
    /**
     * 编辑更新逻辑
     * @param Request $request
     */
    public function update(Request $request,Post $post)
    {
        //用户是否授权
        $this->authorize('update',$post);
        //验证
        $validator=$this->getPostValidator($request);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        //逻辑
        $param=$request->only(['title','content']);
//        $post->title=$request->input('title');
//        $post->content=$request->input('content');
        $ret=$post->update($param);
        //渲染
        return redirect('/posts');
    }
    /**
     * 删除文章
     * @param Request $request
     */
    public function delete(Request $request,Post $post)
    {
        //用户是否授权
        $this->authorize('update',$post);

        $post->delete();
        return redirect('/posts');
    }

    /**
     * 写文章时
     * 上传图片
     * @param Request $request
     */
    public function uploadImages(Request $request)
    {
        $files=FileUtil::saveFileQiNiu($request->allFiles());
        $data['errno']=0;
        foreach($files as $file){
            if($file){
                $data['data'][]=FileUtil::getPathComplete($file);
            }
        }
        return json_encode($data);
    }

    /**
     * 检验上传的post数据的合法性
     * @param $request
     * @return mixed
     */
    private function getPostValidator($request){
        $validator =Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
        ]);

        $validator->after(function ($validator) use ($request) {
            $content_text=$request->input('content_text');
            $content_text=trim(str_replace('&nbsp;','',$content_text));
            if (empty($content_text)) {
                $validator->errors()->add('content', '内容必须要有文字信息');
            }
        });

        return $validator;
    }

    /**
     * 评论文章
     * @param Request $request
     * @param Post $post
     * @return \Illuminate\Http\RedirectResponse
     */
    public function comment(Request $request,Post $post){
        //验证
        $this->validate($request,[
           'content'=>'required'
        ]);
        //逻辑
        $comment=new Comment();
        $comment->content=$request->input('content');
        $comment->user_id=Auth::id();
        $post->comments()->save($comment);
        //渲染
        return back();
    }

    /**
     * 赞文章
     * @param Request $request
     * @param Post $post
     */
    public function zan(Request $request, Post $post)
    {
        $data=[
            'user_id'=>Auth::id(),
            'post_id'=>$post->id,
        ];
        $zan=Zan::firstOrCreate($data);
        return back();
    }
    /**
     * 取消赞文章
     * @param Request $request
     * @param Post $post
     */
    public function unzan(Request $request, Post $post)
    {
        $post->zan(Auth::id())->delete();

        return back();
    }

    public function search()
    {
        //验证
        $query=request('query');
        //逻辑
        $posts=Post::search($query)->paginate(2);
        //渲染
        return view('post.search',compact('query','posts'));
    }
}
