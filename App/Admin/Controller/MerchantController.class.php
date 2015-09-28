<?php
namespace Admin\Controller;

use Admin\Controller\BaseController;

class MerchantController extends BaseController
{
    public function _filter()
    {
        $map = array();
        $audit_status = isset($_GET['audit_status']) ? $_GET['audit_status'] : '';

        if ($audit_status !== '') {
            $map['audit_status'] = $audit_status;
        }

        if (I('get.overdue') == 1) {
            $map['authorization_end_time'] = array('lt', now());
        }
        return $map;
    }
    public function _before_add()
    {
        $class_list = D('MerchantClass')->_list();
        $this->assign('class_list', $class_list);
    }

    public function _before_edit()
    {
        //商户图片
        $id = I('get.id');
        $map['merchant_id'] = $id;
        $img_list = D('MerchantImg')->_list($map, '', 'id asc');
        $this->assign('img_list', $img_list);

        $filepath = array_column($img_list, 'path');
        $imgData = implode('|', $filepath) . '|';
        $this->assign('imgData', $imgData);

        //商户分类
        $this->_before_add();
    }

    /**
     * 新增商户
     * @method insert
     */
    public function insert()
    {
        $model = D('Merchant');

        if (!$model->create()) {
            $this->error($model->getError());
        }

        $imgData = I('post.imgData');

        if (empty($imgData)) {
            $this->error('请上传商户图片');
        }
        $imgData = explode('|', $imgData);
        $imgData = array_filter($imgData);

        $model->startTrans();
        $merchant_id = $model->add();
        $insert_img = D('MerchantImg')->insert($imgData, $merchant_id);

        if ($merchant_id !== false && $insert_img !== false) {
            $model->commit();
            $this->success('新增成功', U('Merchant/index'));
        } else {
            $model->rollback();
            $this->error('新增失败');
        }
    }

    public function update()
    {
        $model = D('Merchant');

        if (!$model->create()) {
            $this->error($model->getError());
        }

        $imgData = I('post.imgData');

        if (empty($imgData)) {
            $this->error('请上传商户图片');
        }

        $imgData = explode('|', $imgData);
        $imgData = array_filter($imgData);
        $merchant_id = I('post.id');

        $map['id'] = $merchant_id;
        $model->startTrans();
        $update_result = $model->where($map)->save();
        $update_img_result = D('MerchantImg')->update($imgData, $merchant_id);

        if ($update_result !== false && $update_img_result !== false) {
            $model->commit();
            $this->success('操作成功', U('Merchant/index'));
        } else {
            $model->rollback();
            $this->error('操作失败');
        }
    }

    public function audit_status()
    {
        $id = I('get.id');
        $audit_status = I('get.audit_status');

        $map['id'] = $id;
        $data['audit_status'] = $audit_status;

        $result = D('Merchant')->where($map)->save($data);

        if ($result) {
            $this->success('审核成功', U('Merchant/index'));
        } else {
            $this->error('审核失败');
        }
    }

    public function position()
    {
        $address = I('k');
        $merchant_list = D('Merchant')->getMerchantList();
        $this->assign('merchant_list', $merchant_list);
        $this->assign('address', $address);
        $this->display();
    }

    public function getKeywords()
    {
        $id = I('id');
        $map['id'] = $id;

        $info = D('MerchantClass')->_get($map);

        if ($info) {
            $keywords = $info['keywords'];
            $keywords = explode(',', $keywords);
            $keywords = array_filter($keywords);
            $this->success($keywords);
        } else {
            $this->error('获取关键词失败');
        }
    }
}
