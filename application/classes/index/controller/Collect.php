<?php

namespace app\index\controller;
use app\common\controller\Frontend;

Class Collect extends Frontend
{
    Public function _initialize()
    {
       // parent::_initialize();
       $this->id = 2043;
       $this->log_err = LOG_PATH . 'collect_err.txt';
    }

    
	Public function index()
	{
		//file_put_contents($this->log_err,'未抓取到数据'.PHP_EOL,FILE_APPEND);
		echo 1;
		die();
		
		for($i = 1; $i < 16; $i++)
		{
			$url_list =  $this->get_url($i);
			if(!empty($url_list) && is_array($url_list))
			{
				foreach($url_list as $key => $val)
				{
					$this->id ++;
					$this->get_data($val);
					file_put_contents($this->log_err,'第'.$i.'页第'.$key.'条已经抓取到数据'.PHP_EOL,FILE_APPEND);
				}
			}else {
				file_put_contents($this->log_err,$i.'未抓取到数据'.PHP_EOL,FILE_APPEND);
			}
		}

		echo 'ok';
		die();
	}
	

	Public function get_url($page)
	{
		$url_list = array();
		header("Content-type:text/html;charset=utf-8");
		$url = 'http://www.duwenzhang.com/wenzhang/renshengzheli/list_6_'. $page .'.html';
		$html = file_get_contents($url);
		if(!empty($html)) $html = set_Chart($html);
		$preg = '/<a.*?href="(.*?)".*?class="ulink">(.*?)<\/a>/is';
		preg_match_all($preg,$html,$matches);
		if(!empty($matches[1]))
		{
			$url_list = $matches[1];
			unset($url_list[0]);
			 
		} 
		return $url_list;
	}




	Public function get_data($url)
	{
		$data = array();
		$html = file_get_contents($url);
		if(!empty($html)) $html = set_Chart($html);
		$preg = "/<tr.*?>(.*?)<\/tr>/ism";
		preg_match_all($preg,$html,$matches);
		//$data['type'] = 1;
		//$data['time'] = trim_html($matches[0][8]);
		
		$data['type'] = 11;
		$data['id'] = $this->id; 
		$data['title'] = trim_html($matches[0][7]);
		$data['content'] = trim_html($matches[0][9]);
		$result = model("ArticleCategoryCollect")->isUpdate(false)->allowField(true)->save($data);
		if(empty($result)) 
		{
			file_put_contents('log.txt',$url.'错误'.PHP_EOL,FILE_APPEND);
		}
	}



}
