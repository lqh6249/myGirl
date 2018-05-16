<?php

namespace app\admin\controller\article;

use app\common\controller\Backend;
use app\common\model\ArticleType as ArticleType;
use fast\Tree;

/**
 * 分类管理
 *
 * @icon fa fa-list
 * @remark 用于统一管理网站的所有分类,分类可进行无限级分类
 */
class Type extends Backend
{

    protected $model = null;
    protected $categorylist = [];
    protected $noNeedRight = ['selectpage'];

    public function _initialize()
    {
        parent::_initialize();
        $this->request->filter(['strip_tags']);
        $this->model = model('ArticleType');
		
        $tree = Tree::instance();
		$arr_info = collection($this->model->order('weigh desc,id desc')->select())->toArray();
		
        $tree->init($arr_info, 'pid');
        $this->categorylist = $tree->getTreeList($tree->getTreeArray(0), 'title');
        $categorydata = [0 => ['type' => 'all', 'title' => __('None')]];
		
        foreach ($this->categorylist as $k => $v)
        {
            $categorydata[$v['id']] = $v;
        }
       
        $this->view->assign("parentList", $categorydata);
    }

    /**
     * 查看
     */
    public function index()
    {
        if ($this->request->isAjax())
        {
            $search = $this->request->request("search");
            //构造父类select列表选项数据
            $list = [];
            if ($search)
            {
                foreach ($this->categorylist as $k => $v)
                {
                    if (stripos($v['title'], $search) !== false)
                    {
                        $list[] = $v;
                    }
                }
            }
            else
            {
                $list = $this->categorylist;
            }
            $total = count($list);
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
