<?php
namespace Admin\Controller;

use Common\Tools\Upload;
use Think\Controller;
use Common\Tools\Image;

class PublicController extends Controller
{
    /**
     * 多图上传方法
     * @method webuploader
     */
    public function webuploader()
    {
        $size = 3145728;
        $exts = array('jpg', 'gif', 'png', 'jpeg');
        $path = './Uploads/';
        $info = $this->upload($path, $size, $exts);

        if (is_array($info)) {
            $data = array();
            foreach ($info as $_k => $_v) {
                $filepath= $path . $info[$_k]['savepath'] . $info[$_k]['savename'];
                $new_filepath = $path.$info[$_k]['savepath'] . 's_'.$info[$_k]['savename'];
                $image = new Image();
                $image->open($filepath);
                $image->thumb(500,500)->save($new_filepath);
                $data[$_k]['filepath'] = $new_filepath;
            }
            $ajaxInfo['status'] = 1;
            $ajaxInfo['data'] = $data;
        } else {
            $ajaxInfo['status'] = 0;
            $ajaxInfo['error'] = $info;
        }
        die(json_encode($ajaxInfo));
    }

    /**
     * 上传私有方法
     * @method upload
     * @param  string  $path 上传目录
     * @param  integer $size 文件大小
     * @param  array   $exts 允许格式
     * @return array         成功返回数据,失败返回false
     */
    private function upload($path = './Uploads/', $size = 3145728, $exts = array('jpg', 'gif', 'png', 'jpeg'))
    {
        $upload = new Upload();
        $upload->maxSize = $size;
        $upload->exts = $exts;

        $subName = array('date', 'Ymd');

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        $upload->rootPath = $path;
        $upload->subName = $subName;
        $info = $upload->upload();

        return $info;
    }
}
