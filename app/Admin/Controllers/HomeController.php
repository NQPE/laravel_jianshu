<?php
/**
 * Created by PhpStorm.
 * User: Levi
 * Date: 2017/7/18
 * Time: 10:16
 */

namespace App\Admin\Controllers;


use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * 首页
     */
    public function index()
    {
        return view('admin.home.index');
    }


}