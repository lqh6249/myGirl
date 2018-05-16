<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2017 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

//------------------------
//自定义 助手函数
//-------------------------
function set_Chart ($data) 
{
    if (!empty($data))
    {
        $array_type = array('UTF-8','GBK','LATIN1','BIG5');
        $file_type = mb_detect_encoding($data , $array_type) ;
        if ('UTF-8' <> $file_type)
        {
            $data = mb_convert_encoding($data ,'utf-8' , $file_type);
        }
    }
    return $data;
}

function trim_html($str)
{
    if(!empty($str))
    {
        $search = array("\r\n","\n","\r","\t","\0");
        $str = htmlspecialchars(trim(strip_tags($str)));
        $str = str_replace($search, '', $str);
    }
    return $str;
}

function get_image($img_path)
{
    $info = getimagesize($img_path);
    if(!empty($info)) return $info[3];
}