<?php
namespace Admin\Controller;

use Admin\Controller\BaseController;

class IndexController extends BaseController
{
    /**
     * 首页显示正常商家
     * @method index
     */
    public function index()
    {
        $merchant_list = D('Merchant')->getMerchantList();
        $this->assign('merchant_list', $merchant_list);

        $this->display();
    }
}