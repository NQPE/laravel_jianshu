<?php
use App\Common\Utils\Htmldom;

if (! function_exists('filterImgTagHtml')) {
    /**
     * 将html里面的img标签去掉
     * @param $html
     * @return mixed
     */
    function filterImgTagHtml($html){
        $parse = new Htmldom();
        $parse->str_get_html($html);
        foreach($parse->find('img') as $element){
            $filter=$element->outertext();
            $html=str_replace($filter,'',$html);
        }
        return $html;
    }
}
