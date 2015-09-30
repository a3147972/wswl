<?php
namespace Admin\Controller;

use Admin\Controller\BaseController;

class MerchantClassController extends BaseController
{
    /**
     * 防止删除有商户的分类
     * @method _before_del
     */
    public function _before_del()
    {
        $id = I('get.id');

        $map['merchant_id'] = $id;

        $info = D('Merchant')->_get($map);

        if ($info) {
            $this->error('此分类下还有商户,请删除商户以后再删除分类');
        }
    }
}