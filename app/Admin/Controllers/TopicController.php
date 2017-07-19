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
use App\Models\Topic;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    /**
     * 专题列表页面
     */
    public function index()
    {
        $topics=Topic::paginate(5);
        return view('admin.topic.index',compact('topics'));
    }
    /**
     * 添加专题页面
     */
    public function create()
    {
        return view('admin.topic.create');
    }
    /**
     * 添加专题逻辑
     */
    public function store(Request $request)
    {
        //验证
        $this->validate($request,[
            'name'=>'required|unique:topics',
        ]);
        //逻辑
        $data['name']=$request->input('name');

        Topic::create($data);

        //渲染
        return redirect('/admin/topics');
    }

    /**
     * 删除专题
     * @param Topic $topic
     * @return array
     * @throws \Exception
     */
    public function delete(Topic $topic)
    {
        $topic->delete();
        return [
            'error'=>0,
            'msg'=>''
        ];
    }
}