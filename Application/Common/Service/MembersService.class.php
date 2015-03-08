<?php

/**
 * 系统登陆服务
 *
 * @author delpan
 * @email 243334464@qq.com
 * @date 2014-4-20
 */
namespace Common\Service;
use Think\Model;
class MembersService extends Model{
    
    protected $error = '';
    
    public function login($username, $password, $remember = FALSE) {
        $map = array( 'username' => $username );
        $user_info = $this->where($map)->find();
        if(empty($user_info) || $user_info['password'] !== md5($password)){
            $this->error = '用户名或密码错误，请重新输入！';
            return FALSE;
        }
        
        $this->autoLogin($user_info, $remember);
        
        return $user_info['uid'];
    }
    
    public function isLogin() {
        //判断SESSION是否生效
        if(session('?user_auth')){
            $user_auth = session('user_auth');
            $user_auth_sign = session('user_auth_sign');
            if(data_auth_sign($user_auth) == $user_auth_sign){
                return $user_auth['uid'];
            }
        }
        
        //判断COOKIE是否生效
        $user_auth = cookie('user_auth');
        if($user_auth){
            $user_auth = sys_decrypt(cookie('user_auth'));
            $user_auth_sign = cookie('user_auth_sign');
            if(data_auth_sign($user_auth) == $user_auth_sign){
                $this->autoLogin($user_auth);
                return $user_auth['uid'];
            }
        }
        
        return FALSE;
    }
    
    public function logout() {
        session('user_auth', null);
        session('user_auth_sign', null);
    }
    
    /**
     * 自动登录用户
     * @param  integer $user 用户信息数组
     */
    private function autoLogin($user, $remember = FALSE){
        /* 更新登录信息 */
        $data = array(
            'uid'             => $user['uid'],
            'login'           => array('exp', '`login`+1'),
            'last_login_time' => NOW_TIME,
            'last_login_ip'   => get_client_ip(1),
        );
        $this->save($data);
        
        /* 记录登录SESSION和COOKIES */
        $auth = array(
            'uid'             => $user['uid'],
            'username'        => $user['nickname'] ? $user['nickname'] : $user['username'],
            'last_login_time' => NOW_TIME,
        );

        session('user_auth', $auth);
        session('user_auth_sign', data_auth_sign($auth));
        
        if($remember){
            cookie('user_auth', sys_encrypt($auth));
            cookie('user_auth_sign', data_auth_sign($auth));
        }
    }
}
