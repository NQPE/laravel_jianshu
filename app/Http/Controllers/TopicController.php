<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostTopic;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TopicController extends Controller
{
    /**
     * 模板详情页
     * @param Request $request
     * @param Topic $topic
     */
    public function show(Request $request, Topic $topic)
    {
        //带文章数的专题
        $topic=Topic::withCount('postTopics')->find($topic->id);
        //专题下的文章
        $posts=$topic->posts()->paginate(5);
        //属于我的文章 但未投稿
        $myposts=Post::authorBy(Auth::id())->topicNotBy($topic->id)->get();

        return view('topic.show',compact('topic','posts','myposts'));
    }

    /**
     * 投稿
     * @param Request $request
     * @param Topic $topic
     */
    public function submit(Request $request, Topic $topic)
    {
        //验证
        $this->validate($request,[
           'post_ids'=>'required|array'
        ]);
        //逻辑
        $post_ids=$request->input('post_ids');
        $topic_id=$topic->id;
        foreach($post_ids as $post_id){
            PostTopic::firstOrCreate(compact('post_id','topic_id'));
        }
        //渲染
        return back();
    }
}
