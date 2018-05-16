<?php

namespace app\index\controller;
use app\common\controller\Frontend;

Class Mood extends Frontend
{
	Public function _initialize() 
    {
        parent::_initialize();
        $this->m_limit = 10; //默认显示的数据条数
        $this->model = model("ArticleMood");//数据模型
    }

    Public function index()
	{
		$list = $this->getDataList($this->model,$where=null,$this->m_limit);
		$this->assign("mood_list", $list);
		return $this->fetch('index/mood');
	}
	

	/**
	**底部下拉无限加载
	**/
	Public function moodPageList()
	{
		$page = input("param.page",0,'intval');
		if(!empty($page) && (1 < $page))
		{
			$list =$this->model
			  ->where($where=null)
			  ->limit($this->m_limit)
			  ->page($page)
			  ->cache($this->cache_time)
			  ->select();
		}
		else
		{
			$list = array();
		}
		$this->assign("mood_list", $list);
		return $this->fetch('common/mood_list');
	}
	
	
}
