<?php
namespace Admin\Controller;

use Admin\Controller\BaseController;

class IndexController extends BaseController
{
    public function index()
    {
        $merchant_list = $this->getMerchantList();
        $this->assign('merchant_list', $merchant_list);

        $this->display();
    }

    public function getMerchantList()
    {
        $model = D('Merchant');

        $map['audit_status'] = 1;
        $map['authorization_end_time'] = array('gt', now());

        $list = $model->_list($map, '', '', 1, 10);

        return $list;
    }
}