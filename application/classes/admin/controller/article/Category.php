<?php

namespace app\admin\controller\article;

use app\common\controller\Backend;
use fast\Tree;

/**
 * 分类管理
 *
 * @icon fa fa-list
 * @remark 用于统一管理网站的所有分类,分类可进行无限级分类
 */
class Category extends Backend
{

    protected $model = null;
    protected $categorylist = [];
    protected $noNeedRight = ['selectpage'];

    public function _initialize()
    {
		parent::_initialize();
        $this->request->filter(['strip_tags']);
        $this->model = model('ArticleCategory');
		
        $tree = Tree::instance(); 
		$arr_info = collection(model('ArticleType')->order('weigh desc,id desc')->select())->toArray();
		
        $tree->init($arr_info, 'pid');
        $this->categorylist = $tree->getTreeList($tree->getTreeArray(0), 'title');
		
        foreach ($this->categorylist as $k => $v)
        {
            $categorydata[$v['id']] = $v;
        }
	    $this->categorydata = $categorydata;
        $this->view->assign("parentList", $categorydata);
    }

    /**
     * 查看
     */
    public function index()
    {
        if ($this->request->isAjax())
        {
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
			$total = $this->model
                    ->where($where)
                    ->order($sort, $order)
                    ->count();

            $list = $this->model
                    ->where($where)
                    ->order($sort, $order)
                    ->limit($offset, $limit)
                    ->select();
			$category_type = $this->categorydata;
			foreach ($list as $k => $v){
				$list[$k]['category_name'] = $category_type[$v['type']]['title'];
			}
			$result = array("total" => $total, "rows" => $list);
            return json($result);
        }
        return $this->view->fetch();
    }

    /**
     * Selectpage搜索
     * 
     * @internal
     */
    public function selectpage()
    {
        return parent::selectpage();
    }

}
