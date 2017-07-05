<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * 文章列表页面
     * @param Request $request
     */
    public function index(Request $request)
    {
        return view('post.index');
    }
    /**
     * 文章详情页面
     * @param Request $request
     */
    public function show(Request $request,Post $post)
    {

    }
    /**
     * 创建文章页面
     * @param Request $request
     */
    public function create(Request $request)
    {

    }
    /**
     * 创建文章存储逻辑
     * @param Request $request
     */
    public function save(Request $request)
    {

    }
    /**
     * 编辑文章页面
     * @param Request $request
     */
    public function edit(Request $request,Post $post)
    {

    }
    /**
     * 编辑更新逻辑
     * @param Request $request
     */
    public function update(Request $request,Post $post)
    {

    }
    /**
     * 删除文章
     * @param Request $request
     */
    public function delete(Request $request,Post $post)
    {

    }
}
