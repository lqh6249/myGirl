<?php

namespace app\index\controller;
use app\common\controller\Frontend;

Class Index extends Frontend
{
    Public function _initialize()
    {
        parent::_initialize();
    }
	
	/**
	**@首页 数据列表展示
	**/
    Public function index()
    {
		//获取首页5条文章数据
		$this->getIndexCatList($this->m_in_limit);
		//获取推荐文章列表
		$this->getRecomCatList($this->m_re_limit);
		//获取最新的文章
		$this->getNewsCatList($this->m_re_limit);
		
		return $this->fetch();
    }

}
