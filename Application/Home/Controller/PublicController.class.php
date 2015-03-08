<?php
/**
 * Description of PublicController
 *
 * @author delpan
 * @email 243334464@qq.com
 * @date 2014-4-20
 */
namespace Home\Controller;
use Think\Controller;
class PublicController extends Controller {
    
    public function verifyAction($config = array()){
        $this->display(create_verify($config));
    }
    public function adminVerifyAction() {
        $config = array(
            'length'=> 4,
            'useZh' => true,
            'useImgBg' => true,
        );
        $this->verifyAction($config);
    }
    
    public function loginAction() {
        if(IS_POST){
            if(!check_verify(I('post.verify'))){
                $msg = '验证码错误，请重新输入！';
                $this->error($msg);
            }
            
            $username = I('post.username');
            $password = I('post.password');
            $remember = I('post.remember');
            $login = service('Member');
            $msg = $login->login($username, $password, $remember);
            
            if($msg){
                $message = "登陆成功";
                $this->success($message);
            }else{
                $this->error($login->error);
            }
        }else{
            $this->display();
        }
    }
    
    public function register() {
        if(IS_POST){
            
        }else{
            $this->display();
        }
    }
}
