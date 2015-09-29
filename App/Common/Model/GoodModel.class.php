<?php
namespace Common\Model;

use Common\Model\BaseModel;

class GoodModel extends BaseModel
{
    protected $tableName = 'good';

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
