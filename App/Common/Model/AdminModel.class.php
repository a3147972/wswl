<?php
namespace Common\Model;

use Common\Model\BaseModel;

class AdminModel extends BaseModel
{
    protected $tableName = 'admin';
    protected $_validate = array(
        array('username', 'require', '请输入用户名'),
        array('password', 'require', '请输入密码', 0, 'regex', 1),
        array('nickname', 'require', '请输入昵称'),
        array('username', '', '用户名已存在', 0, 'unique', 1),
    );

    protected $_auto = array(
        array('ctime', 'now', 1, 'function'),
        array('mtime', 'now', 3, 'function'),
        array('password', 'auto_password', 3, 'callback'),
        array('password', '', 2, 'ignore'),
    );

    protected function auto_password()
    {
        $password = I('post.password');

        if (empty($password)) {
            return '';
        } else {
            return md5($password);
        }
    }

    /**
     * 登录方法
     * @method login
     * @param  string $username 用户名
     * @param  string $password 密码
     * @return array|bool           登录成功返回数组,失败返回false
     */
    public function login($username, $password)
    {
        $map['username'] = $username;

        $info = $this->_get($map);

        if (!$info) {
            $this->error = '此账户不存在';
            return false;
        }

        if ($info['password'] != md5($password)) {
            $this->error = '密码不正确';
            return false;
        }

        return $info;
    }
}
