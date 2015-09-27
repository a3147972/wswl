<?php
namespace Admin\Controller;

use Admin\Controller\BaseController;

class MerchantImgController extends BaseController
{
    public function delAll()
    {
        $imgData = I('post.imgData');
        if (empty($imgData)) {
            $this->error('没有要删除的数据');
        }

        $imgData = explode('|', $imgData);
        $imgData = array_filter($imgData);

        $map['path'] = array('in', $imgData);

        $result = D('MerchantImg')->where($map)->delete();

        if ($result) {
            $this->success('清空成功');
        } else {
            $this->error('清空失败');
        }
    }
}