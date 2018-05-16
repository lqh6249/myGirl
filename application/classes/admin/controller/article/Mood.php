<?php

namespace app\admin\controller\article;

use app\common\controller\Backend;

/**
 * 每日一言管理
 *
 * @icon fa fa-list
 * @remark 用于统一管理网站的所有分类,分类可进行无限级分类
 */
class Mood extends Backend
{
    public function _initialize()
    {
        parent::_initialize();
        $this->request->filter(['strip_tags']);
        $this->model = model('ArticleMood');
    }

}
