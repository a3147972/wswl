<?php
namespace Common\Model;

use Common\Model\BaseModel;

class GoodModel extends BaseModel
{
    protected $tableName = 'good';

    /**
     * 点赞写入数据表
     * @method insert
     * @param  int $merchant_id 商户id
     * @return bool             成功返回true,失败返回false
     */
    public function insert($merchant_id)
    {
        $data['ip'] = get_client_ip();
        $data['merchant_id'] = $merchant_id;
        $data['ctime'] = now();

        $result = $this->add($data);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}
