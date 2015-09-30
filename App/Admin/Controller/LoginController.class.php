<?php
namespace Admin\Controller;

use Think\Controller;

class LoginController extends Controller
{
    public function _empty()
    {
        if (!session('uid')) {
            redirect(U('Login/login'));
        } else {
            redirect(U('Index/index'));
        }
    }

    /**
     * 登录页面
     * @method login
     */
    public function login()
    {
        $this->display();
    }
    /**
     * 检测登录
     * @method checkLogin
     */
    public function checkLogin()
    {
        if (!IS_POST) {
            $this->error('非法访问');
        }
        $username = I('post.username');
        $password = I('post.password');

        if (empty($username)) {
            $this->error('请输入用户名');
        }

        if (empty($password)) {
            $this->error('请输入密码');
        }

        $info = D('Admin')->login($username, $password);

        if ($info) {
            session('uid', $info['id']);
            session('nickname', $info['nickname']);
            $this->success('登录成功', U('Index/index'));
        } else {
            $this->error(D('Admin')->getError());
        }
    }
    /**
     * 退出
     * @method logout
     * @return [type] [description]
     */
    public function logout()
    {
        session(null);
        cookie(null);
        session_regenerate_id();
        redirect(U('Login/login'));
    }
}