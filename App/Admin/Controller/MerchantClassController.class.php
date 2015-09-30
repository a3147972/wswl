<?php
namespace Admin\Controller;

use Admin\Controller\BaseController;

class MerchantClassController extends BaseController
{
    public function index()
    {
        $page = I('page', 1);
        $page_size = I('page_size', 10);
        $order = I('order', '');

        $model = D(CONTROLLER_NAME);

        //查询值
        $pk = $model->getPk();
        $order = empty($order) ? 'sort asc' : $order;
        $map = method_exists($this, '_filter') ? $this->_filter() : array();

        //查询数据
        $list = $model->_list($map, '', $order, $page, $page_size);
        $count = $model->_count($map);

        //分页处理
        $page_list = $this->page($count, $page, $page_size);

        $this->assign('page_list', $page_list);
        $this->assign('count', $count);
        $this->assign('list', $list);
        $this->display();
    }
    /**
     * 防止删除有商户的分类
     * @method _before_del
     */
    public function _before_del()
    {
        $id = I('get.id');

        $map['class_id'] = $id;

        $info = D('Merchant')->_get($map);

        if ($info) {
            $this->error('此分类下还有商户,请删除商户以后再删除分类');
        }
    }
}