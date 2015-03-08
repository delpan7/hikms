<?php
/**
 * Description of PublicController
 *
 * @author delpan
 * @email 243334464@qq.com
 * @date 2014-4-20
 */
namespace Admin\Controller;
use Think\Controller;
class PublicController extends Controller {
    
    public function _initialize() {
//        dump(session());
    }
    
    public function verifyAction(){
        $config = array(
//            'length'=> 5,
//            'useZh' => true,
//            'useImgBg' => true,
//            'fontttf' => '5.ttf',
        );
        $this->display(create_verify($config));
    }
    
    public function loginAction(){
        if(IS_POST){
            if(!check_verify(I('post.verify'))){
                $msg = '验证码错误，请重新输入！';
                $jumpUrl = U('Admin/Public/login');
                $this->error($msg, $jumpUrl);
            }
            
            $username = I('post.username');
            $password = I('post.password');
            $login = service('Members');
            $login->login($username, $password);
            $err = $login->getError();
            if(!$err){
                $message = "登陆成功";
                $jumpUrl = U('Admin/Index/index');
                $this->success($message,$jumpUrl);
            }else{
                $jumpUrl = U('Admin/Public/login');
                $this->error($err, $jumpUrl);
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
