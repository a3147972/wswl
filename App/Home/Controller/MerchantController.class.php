<?php
namespace Home\Controller;

use Home\Controller\BaseController;

class MerchantController extends BaseController
{
    public function in()
    {
        $class_list = D('MerchantClass')->_list();
        $this->assign('class_list', $class_list);

        $merchant_list = $this->getMerchantList();
        $this->assign('merchant_list', $merchant_list);
        $this->display();
    }

    /**
     * 查询商户列表
     * @method getMerchantList
     * @param  array           $map 查询条件
     * @return array                查询出的数据
     */
    public function getMerchantList($map = array())
    {
        $map['audit_status'] = 1;
        $map['authorization_end_time'] = array('gt', now());

        $list = D('Merchant')->_list($map);

        return $list;
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