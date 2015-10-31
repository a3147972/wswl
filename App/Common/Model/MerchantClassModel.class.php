<?php
namespace Common\Model;

use Common\Model\BaseModel;

class MerchantClassModel extends BaseModel
{
    protected $tableName = 'merchant_class';

    protected $_validate = array(
        array('name', 'require', '请输入分类名称'),
        array('keywords', 'require', '请输入分类关键词'),
        array('name', '', '分类已存在', 0, 'unique', 1),
    );

    protected $_auto = array(
        array('ctime', 'now', 1, 'function'),
        array('mtime', 'now', 3, 'function'),
    );
}
