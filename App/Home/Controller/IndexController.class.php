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
            //判断是否点赞
            $good_map['merchant_id'] = $id;
            $good_map['ip'] = get_client_ip();
            $good_info = D('Good')->_get($good_map);

            if ($good_info) {
                $info['is_good'] = 1;
            } else {
                $info['is_good'] = 0;
            }

            $this->success($info);
        } else {
            $this->error('查询不到此商家信息');
        }
    }

    public function good()
    {
        $merchant_id = I('merchant_id');
        $ip = get_client_ip();

        $map['merchant_id'] = $merchant_id;
        $map['ip'] = $ip;

        $good_info = D('Good')->_get($map);

        if ($good_info) {
            $this->error('你已经点过赞了');
        }
        $model = D('Merchant');
        $data['good_number'] = array('exp', 'good_number + 1');

        $model->startTrans();
        $add_good_result = D('Good')->insert($merchant_id);

        $result = $model->where(array('id'=>$merchant_id))->save($data);

        if ($add_good_result !== false && $result !== false) {
            $model->commit();
            $this->success('success');
        } else {
            $model->rollback();
            $this->error('error');
        }
    }
}
