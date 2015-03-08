<?php
/**
 * Description of UserController
 *
 * @author delpan <delpan.sinasae.com>
 * @email 243334464@qq.com
 * @date 2014-4-7
 */
namespace Admin\Controller;
class UserController extends BaseController{
    
    public function _initialize() {
        parent::_initialize();
        $this->members = D('Members');
    }
    public function indexAction() {
        $users = $this->members->getUsers();
        $this->assign($users);
        $this->display();
    }
    
    public function addAction() {
        if(IS_POST){
            $this->doAdd();
        }else{
            $this->display();
        }
    }
    
    private function doAdd(){
        $data['username'] = I('post.username');
        $data['password'] = I('post.password');
        $data['nickname'] = I('post.nickname', 0, 'intval');
        $data['email'] = I('post.email');
        $data['reg_ip'] = get_client_ip(1);
        $uid = $this->members->addUser($data);
        $err = $this->members->getError();
        if($err){
            $this->error($err);
        }else{
            $jumpUrl = U('Admin/User/index');
            $this->success('添加成功！', $jumpUrl);
        }
    }
    
    public function editAction() {
        if(IS_POST){
            $this->doEdit();
        }else{
            $uid = I('get.uid', 0, 'intval');
            if(!$uid){
                $this->error('参数错误！');
            }
            $user_info = $this->members->getUserByUid($uid);
            $this->assign('user_info',$user_info);
            $this->display('add');
        }
    }
    
    private function doEdit(){
        $data['uid'] = I('get.uid', 0, 'intval');
        $data['username'] = I('post.username');
        $data['password'] = I('post.password');
        $data['nickname'] = I('post.nickname', 0, 'intval');
        $data['email'] = I('post.email');
        $this->members->updateUser($data['uid'], $data);
        $err = $this->members->getError();
        if($err){
            $this->error($err);
        }else{
            $jumpUrl = U('Admin/User/index');
            $this->success('修改成功！', $jumpUrl);
        }
    }
    
    public function deleteAction(){
        $ids = I('post.uid');
        $this->members->deleteUser($ids);
        $err = $this->members->getError();
        if($err){
            $this->error($err);
        }else{
            $jumpUrl = U('Admin/User/index');
            $this->success('删除成功！', $jumpUrl);
        }
    }
}
