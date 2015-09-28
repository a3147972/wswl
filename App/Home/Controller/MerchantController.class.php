<?php
namespace Home\Controller;

use Home\Controller\BaseController;

class MerchantController extends BaseController
{
    public function in()
    {
        $class_list = D('MerchantClass')->_list();
        $this->assign('class_list', $class_list);

        $merchant_list = D('Merchant')->getMerchantList();
        $this->assign('merchant_list', $merchant_list);
        $this->display();
    }

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
}