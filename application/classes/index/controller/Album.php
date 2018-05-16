<?php

namespace app\index\controller;
use app\common\controller\Frontend;

Class Album extends Frontend
{
    Public function _initialize()   
    {
        parent::_initialize();
    }

    
	Public function index()
	{
		$data = array(
			'/uploads/20180102/1.jpg',
			'/uploads/20180102/2.jpg',
			'/uploads/20180102/4.jpg',
			'/uploads/20180102/5.jpg',
			'/uploads/20180102/6.jpg',
			'/uploads/20180102/7.jpg',
			'/uploads/20180102/8.jpg',
			'/uploads/20180102/9.jpg',
			'/uploads/20180102/10.jpg'	
		);
		$this->assign("album_list", $data);
		return $this->fetch('index/album_list');
	}
}
