<?php
namespace Admin\Controller;

use Admin\Controller\BaseController;

class MerchantImgController extends BaseController
{

    /**
     * 删除商户关键词
     * @method del
     */
    public function del()
    {
        $model = D('MerchantImg');
        $id = I('id');
        $map['id'] = $id;

        $info = $model->_get($map);

        $result = $model->where($map)->delete();

        if ($result) {
            $this->success($info['path']);
        } else {
            $this->error('删除失败');
        }
    }
}