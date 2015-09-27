<?php
namespace Admin\Controller;

use Common\Tools\Upload;
use Think\Controller;

class PublicController extends Controller
{
    public function webuploader()
    {
        $size = 3145728;
        $exts = array('jpg', 'gif', 'png', 'jpeg');
        $path = './Uploads/';
        $info = $this->upload($path, $size, $exts);

        if (is_array($info)) {
            $data = array();
            foreach ($info as $_k => $_v) {
                $data[$_k]['filepath'] = $path . $info[$_k]['savepath'] . $info[$_k]['savename'];
            }
            $ajaxInfo['status'] = 1;
            $ajaxInfo['data'] = $data;
        } else {
            $ajaxInfo['status'] = 0;
            $ajaxInfo['error'] = $info;
        }
        die(json_encode($ajaxInfo));
    }

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
