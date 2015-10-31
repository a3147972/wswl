<?php
namespace Home\Controller;

use Home\Controller\BaseController;

class MerchantController extends BaseController
{
    /**
     * 商户入驻
     * @method in
     * @return [type] [description]
     */
    public function in()
    {
        $class_list = D('MerchantClass')->_list();
        $this->assign('class_list', $class_list);

        $merchant_list = D('Merchant')->getMerchantList();
        $this->assign('merchant_list', $merchant_list);
        $this->display();
    }

    /**
     * 商户提交入驻申请
     * @method insert
     */
    public function insert()
    {
        $model = D('Merchant');

        if (!$model->create()) {
            $this->error($model->getError());
        }
        $model->authorization_start_time = now();
        $model->authorization_end_time = date('Y-m-d H:i:s', strtotime('+1 month', time()));

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
            $this->success('新增成功', U('Index/index'));
        } else {
            $model->rollback();
            $this->error('新增失败');
        }
    }
}