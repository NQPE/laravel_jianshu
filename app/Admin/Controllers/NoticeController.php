<?php
/**
 * Created by PhpStorm.
 * User: Levi
 * Date: 2017/7/18
 * Time: 10:16
 */

namespace App\Admin\Controllers;


use App\Common\Utils\FileUtil;
use App\Jobs\SendMessage;
use App\Models\AdminPermission;
use App\Models\AdminUser;
use App\Models\Notice;
use App\Models\Topic;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    /**
     * 专题列表页面
     */
    public function index()
    {
        $notices=Notice::paginate(5);
        return view('admin.notice.index',compact('notices'));
    }
    /**
     * 添加专题页面
     */
    public function create()
    {
        return view('admin.notice.create');
    }
    /**
     * 添加专题逻辑
     */
    public function store(Request $request)
    {
        //验证
        $this->validate($request,[
            'title'=>'required',
            'content'=>'required',
        ]);
        //逻辑
        $data['title']=$request->input('title');
        $data['content']=$request->input('content');

        $notice=Notice::create($data);

        //通过队列 发送通知给前台用户
        dispatch(new SendMessage($notice));

        //渲染
        return redirect('/admin/notices');
    }


}