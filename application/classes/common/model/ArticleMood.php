<?php

namespace app\common\model;

use think\Model;

/**
 * 分类模型
 */
class ArticleMood Extends Model
{

    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';
    // 定义时间戳字段名
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';
	
}
