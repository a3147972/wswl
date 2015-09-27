<?php
namespace Home\Controller;

use Home\Controller\BaseController;

class MerchantController extends BaseController
{
    public function in()
    {
        $class_list = D('MerchantClass')->_list();
        $this->assign('class_list', $class_list);
        $this->display();
    }
}