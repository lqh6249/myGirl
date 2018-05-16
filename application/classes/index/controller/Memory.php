<?php

namespace app\index\controller;
use app\common\controller\Frontend;

Class Memory extends Frontend
{
	
	Public function _initialize()
    {
        parent::_initialize();		
    }
	
	/**
	**@慢生活 数据列表展示
	**@$type类型 文章类型 默认为空 展示全部
	**/
    Public function index()
    {
		//文章列表
		$type = input("param.type",0,'intval');
		if(!empty($type)){
			$where['type'] = array('eq',$type);
			$this->getRelatedList($this->m_re_limit,$type);
		}else{
			$where['type'] = array('neq',$this->m_nt_type);
			$this->getRelatedList($this->m_re_limit);
		}
		
		$data = $this->getCategoryListPage($where,$this->m_in_limit);
		
		$this->assign("list", $data['list']);
		$this->assign("page", $data['page']);
		
		return $this->fetch('index/article_list');
    }

	/**
	**@慢生活 获取文章详情
	*/
	Public function detail()
	{
		//根据ID获取文章类型 并获取推荐文章数据
		$id = input("param.id",0,'intval');
		if(empty($id ) || (0 > $id)) $this->redirect('/');
		model("ArticleCategory")->where('id',$id)->setInc('views',1);
		$type = model("ArticleCategory")->where('id',$id)->value('type');
		if(empty($type) || (0 > $type)) $this->redirect('/');
		//获取推荐数据和文章详情
		$this->getRelatedList($this->m_re_limit,$type);
		$this->getCategoryInfo($id);
		//获取相关文章数据
		$this->getNextInfo($id,$type);
		return $this->fetch('index/article_show');
	} 
	
	
	/**
	**@慢生活 获取推荐数据列表和点击排行
	**@$type类型 文章类型 默认为空 展示全部
	**/
	Protected function getRelatedList($limit,$type="")
	{
		//获取栏目推荐列表
		$this->getRecomCatList($limit,$type);
		//点击排行旁列表
		$this->getClickCatList($limit,$type);
	}
	
	
	/**
	**@慢生活 根据当前文章获取上一篇文章、下一篇文章及相关文章		
	**@$type类型 文章类型 默认为空 展示全部
	**/
	Protected function getNextInfo($id,$type)
	{
		$field = 'id,title';
 		//上一篇文章
		$where['id'] = array('lt',$id);
		$where['type'] = array('neq',$this->m_nt_type);
		$prev_info = $this->getCategoryOne($where,$field);
		//下一篇文章
		$where['id'] = array('gt',$id);
		$next_info = $this->getCategoryOne($where,$field);
		//相关文章
		unset($where);
		$where['type'] = array('eq',$type);
		$relate_list = $this->getCategoryList($where,$this->m_xg_limit);
		
		$this->assign("prev_info", $prev_info);
		$this->assign("next_info", $next_info);
		$this->assign("relate_list", $relate_list);
	}
	
	
	
	
	
}
