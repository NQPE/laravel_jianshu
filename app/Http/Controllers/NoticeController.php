<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoticeController extends Controller
{
    public function index()
    {
        $notices=Auth::user()->notices()->orderBy('created_at','desc')->paginate(5);
        return view('notice.index',compact('notices'));
    }
}
