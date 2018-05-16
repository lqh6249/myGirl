<?php

namespace app\index\controller;
use app\common\controller\Frontend;

Class User extends Frontend
{
    Public function _initialize()
    {
        parent::_initialize();
    }

    
	Public function about()
	{
		return $this->fetch('index/about');
	}
	

}
