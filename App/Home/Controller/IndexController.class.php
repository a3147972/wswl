<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;

use Home\Controller\BaseController;

class IndexController extends BaseController
{
    public function index()
    {
        $keywords = I('post.keywords', '');

        if (!empty($keywords)) {

        }

        $class_list = D('MerchantClass')->_list();
        $this->assign('class_list', $class_list);
        $this->display();
    }
}
