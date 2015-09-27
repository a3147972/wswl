<?php
namespace Common\Model;

use Common\Model\BaseModel;

class MerchantImgModel extends BaseModel
{
    protected $tableName = 'merchant_img';

    /**
     * 插入商户图片
     * @method insert
     * @param  array $path          图片路径数组
     * @param  int $merchant_id     商户id
     * @return bool                 成功返回true,失败返回false
     */
    public function insert($path, $merchant_id)
    {
        $data = array();
        foreach ($path as $_k => $_v) {
            $data[$_k]['path'] = $_v;
            $data[$_k]['merchant_id'] = $merchant_id;
            $data[$_k]['ctime'] = now();
            $data[$_k]['mtime'] = now();
        }

        $result = $this->addAll($data);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 更新商户图片信息
     * @method update
     * @param  int $id      图片id
     * @param  string $path 新路径
     * @return bool         成功返回true,失败返回false
     */
    public function update($imgData, $merchant_id) {
        $map['id'] = $merchant_id;
        $map['path'] = array('in', $imgData);

        $list = $this->_list($map);
        $path_list = array_column($list, 'path');

        $diff = array_diff($imgData, $path_list);

        if (empty($diff)) {
            return true;
        }
        $data = array();
        foreach ($diff as $_k => $_v) {
            $_data['path'] = $_v;
            $_data['merchant_id'] = $merchant_id;
            $_data['ctime'] = now();
            $_data['mtime'] = now();
            array_push($data, $_data);
        }

        $result = $this->addAll($data);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}
