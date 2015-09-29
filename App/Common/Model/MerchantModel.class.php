<?php
namespace Common\Model;

use Common\Model\BaseModel;

class MerchantModel extends BaseModel
{
    protected $tableName = 'merchant';

    protected $_validate = array(
        array('name', 'require', '请输入商户名称'),
        array('contact', 'require', '请输入联系方式'),
        array('phone', 'require', '请输入电话号码'),
        array('address', 'require', '请输入商户地址'),
        array('coordinate', 'require', '请选择商户坐标'),
        array('authorization_start_time', 'require', '请选择授权开始时间'),
        array('authorization_end_time', 'require', '请选择授权结束时间'),
    );

    protected $_auto = array(
        array('ctime', 'now', 1, 'function'),
        array('mtime', 'now', 3, 'function'),
        array('good_number', 0, 1, 'string'),
    );

    /**
     * 查询商户列表
     * @method getMerchantList
     * @param  array           $map 查询条件
     * @return array                查询出的数据
     */
    public function getMerchantList($map = array())
    {
        $map['audit_status'] = 1;
        $map['authorization_end_time'] = array('gt', now());

        $list = $this->_list($map);

        return $list;
    }
}
