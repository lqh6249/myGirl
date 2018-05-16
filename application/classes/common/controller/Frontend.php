<?php

namespace app\common\controller;

use think\Config;
use think\Controller;
use think\Lang;

Class Frontend extends Controller
{
    
	Private $index_tag = 5;//首页文章列表获取数据类型type
	Private $recom_tag = 1;//获取推荐文章列表获取数据状态
	Private $status = 'normal'; //获取文章状态值 为可用
	Protected $m_nt_type = 8; //默认不查询的文章类型
	Protected $m_re_limit = 8; //默认显示推荐/点击/最新的数据条数
    Protected $m_in_limit = 6; //默认显示列表中的分页条数
	Protected $m_xg_limit = 10; //默认详情中显示的相关文章条数
	Protected $cache_time = 3600; //默认查询时缓存的时间 
	
	
	Public function _initialize()
    {
        $module_name = $this->request->module();
        $controller_name = strtolower($this->request->controller());
        $action_name = strtolower($this->request->action());
		$this->assign("controller_name", $controller_name);
    }

    /**
	**@根据条件获取数据列表 （不分页）
	**/
    Protected function getDataList($model,$where,$limit,$order="create_time desc")
    {
    	$map['status'] = array('eq',$this->status);
    	$list = $model
			->where($map)
            ->where($where)
            ->order($order)
            ->limit($limit)
			->cache($this->cache_time)
            ->select();
		
		return $list;
    }

	/**
	**@根据条件获取数据列表 （分页）
	**/
	Protected function getDataPage($model,$where,$limit,$order="create_time desc")
	{
		$data = array();
		$map['status'] = array('eq',$this->status);
		$list = $model
			->where($map)
            ->where($where)
            ->order($order)
            ->limit($limit)
			->cache($this->cache_time)
            ->paginate($limit);
		
		$data['list'] = $list;
		$data['page'] = $list->render();
		
		return $data;
	}

	/**
	**@根据条件获取单条数据 
	**/
	Protected function getOne($model,$where,$field)
	{
		$map['status'] = array('eq',$this->status);
		$info = $model
			 ->where($map)
			 ->where($where)
			 ->field($field)
			 ->cache($this->cache_time)
			 ->find();
		
		return $info;
	}
    
	/**
	**@根据条件获取文章列表 （不分页）
	**/
	
	Protected function getCategoryList($where,$limit,$order="create_time desc")
	{
		$map['status'] = array('eq',$this->status);
		$list = model("ArticleCategory")
			->with('ArticleType')
			->where($map)
            ->where($where)
            ->order($order)
            ->limit($limit)
			->cache($this->cache_time)
            ->select();
		
		return $list;
	}
	
	/**
	**@根据条件获取单条文章数据 
	**/
	Protected function getCategoryOne($where,$field)
	{
		$map['status'] = array('eq',$this->status);
		$info = model("ArticleCategory")
			 ->where($map)
			 ->where($where)
			 ->field($field)
			 ->cache($this->cache_time)
			 ->find();
		
		return $info;
	}	
	
	/**
	**@根据条件获取文章列表 （分页）
	**/
	Protected function getCategoryListPage($where,$limit,$order="create_time desc")
	{
		$data = array();
		$map['status'] = array('eq',$this->status);
		$list = model("ArticleCategory")
			->with('ArticleType')
			->where($map)
            ->where($where)
            ->order($order)
            ->limit($limit)
			->cache($this->cache_time)
            ->paginate($limit);
		
		$data['list'] = $list;
		$data['page'] = $list->render();
		
		return $data;
	}
	
	/**
	**@获取首页文章列表
	**/
	Protected function getIndexCatList($limit)
	{
		$where['type'] = array('eq',$this->index_tag);
		$list = $this->getCategoryList($where,$limit);
		$this->assign("index_list", $list);
	}
	
	/**
	**@获取最新文章列表
	**/
	Protected function getNewsCatList($limit)
	{
		$list = $this->getCategoryList($where="",$limit);
		$this->assign("news_list", $list);
	}
	
	/**
	**@获取推荐文章列表
	**/
	Protected function getRecomCatList($limit,$type='')
	{
		if(!empty($type)) $where['type'] = array('eq',$type);
		$where['is_recmoend'] = array('eq',$this->recom_tag);
		$list = $this->getCategoryList($where,$limit);
		$this->assign("recom_list", $list);
	}
	
	/**
	**@获取点击排行列表
	**/
	Protected function getClickCatList($limit,$type='')
	{
		$where = "";
		if(!empty($type)) $where['type'] = array('eq',$type);
		$list = $this->getCategoryList($where,$limit,'views desc,create_time desc');
		$this->assign("click_list", $list);
	}
	
	/**
	**根据条件获取文章详情
	**/
	Protected function getCategoryInfo($id)
	{
		$info = model("ArticleCategory")->get($id);
		if(empty($info)) $this->redirect('/');
		$this->assign("info", $info);
	}
	

}
