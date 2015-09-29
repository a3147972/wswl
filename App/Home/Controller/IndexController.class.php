<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;

use Home\Controller\BaseController;

class IndexController extends BaseController
{
    public function index()
    {
        //关键词搜索
        $k = I('k', '');
        $class_id = I('class_id', '');
        if (!empty($k)) {
            $map['keywords|name'] = array('like', '%'.$k.'%');
        }

        if (!empty($class_id)) {
            $map['class_id'] = $class_id;
        }

        $list = D('Merchant')->getMerchantList($map);

        $class_list = D('MerchantClass')->_list();
        //查询分类下数量
        $map['audit_status'] = 1;
        $map['authorization_end_time'] = array('gt', now());

        $merchant_count = D('Merchant')->where($map)->group('class_id')->field('class_id,count(id) as count')->select();

        $merchant_count = array_column($merchant_count, 'count', 'class_id');

        foreach ($class_list as $_k => $_v) {
            $class_list[$_k]['count'] = isset($merchant_count[$_v['id']]) ? $merchant_count[$_v['id']] : 0;
        }

        $this->assign('list', $list);
        $this->assign('class_list', $class_list);
        $this->display();
    }

    public function getInfo()
    {
        $id = I('id');
        $map['id'] = $id;

        $info = D('Merchant')->_get($map);

        if ($info) {
            $img_list = D('MerchantImg')->_list(array('merchant_id'=>$id));
            $img_list = array_column($img_list, 'path');
            $info['img_list'] = $img_list;
            $this->success($info);
        } else {
            $this->error('查询不到此商家信息');
        }
    }
}
