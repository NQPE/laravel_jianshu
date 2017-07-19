<?php
/**
 * Created by PhpStorm.
 * User: Levi
 * Date: 2017/7/10
 * Time: 18:11
 */

namespace App\Http\Controllers\Test;


use App\Common\Utils\Htmldom;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestController extends Controller
{

    public function testfile()
    {
        return view('test/testfile');
    }

    public function uploadImages(Request $request)
    {
//        dd($request->allFiles());
//        $files=FileUtil::saveFileQiNiu($request->allFiles());
//        dd($files);

    }

    public function parseHtml()
    {
        $htmls='<p>图片</p><p><img src="http://osx552wfr.bkt.clouddn.com/upload/images/2017-07-12/025d310b25.jpg" style="max-width:100%;" class=""><br></p>';
        $html = new Htmldom();
        $html->str_get_html($htmls);
        foreach($html->find('img') as $element){
            $filter=$element->outertext();
            $htmls=str_replace($filter,'',$htmls);
        }
        dd($htmls);

    }
}