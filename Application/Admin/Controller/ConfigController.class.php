<?php
/**
 * 系统设置
 *
 * @author delpan <delpan.sinasae.com>
 * @email 243334464@qq.com
 * @date 2014-4-7
 */
namespace Admin\Controller;
class ConfigController extends BaseController {
    
    private $configs;
    private $config_group;

    public function _initialize() {
        parent::_initialize();
        $this->configs = D('Configs');
        $this->config_group = C('CONFIG_GROUP_LIST');
        $this->assign('config_group', $this->config_group);
    }
    public function indexAction(){
        $groups = array_merge(array(0=>'未分组'), $this->config_group);//加入0未分组
        $this->assign('groups', $groups);
        if(isset($_GET['group'])){
            $group = I('get.group', 0, 'intval');
            if(array_key_exists($group, $groups)){
                 $map['group'] = $group;
                $this->assign('group', $group);
            }
        }
        
        $config_items = $this->configs->where($map)->findPage(2);
        
        $this->assign('config_items', $config_items);
        $this->display();
    }
    
    public function settingAction(){
        $group = I('get.group');
        if(!array_key_exists($group, $this->config_group)){
            $group = 1;
        }
        $config_items = $this->configs->getConfigItems($group);
        
        $this->assign('group', $group);
        $this->assign('config_items', $config_items);
        
        $this->display();
    }
    
    
    public function addAction() {
        if(IS_POST){
            if(I('post.id') > 0){
                $this->doEdit();
            }else{
                $this->doAdd();
            }
        }else{
            $this->assign('config_type', C('CONFIG_TYPE_LIST'));
            $this->display();
        }
    }
    
    private function doAdd(){
        $data['name'] = strtoupper(I('post.name'));
        $data['title'] = I('post.title');
        $data['remark'] = I('post.remark');
        $data['group'] = I('post.group');
        $data['type'] = I('post.type');
        if($data['type'] > 3){
            $data['options'] = I('post.options');
        }
        $this->configs->addConfigItem($data);
        $err = $this->configs->getError();
        if($err){
            $this->error($err);
        }else{
            $this->success('修改成功！');
        }
    }
    
    public function editAction() {
        if(IS_POST){
            $this->doEdit();
        }else{
            
            $id = I('get.id', 0, 'intval');
            if(!$id){
                $this->error('参数错误！');
            }
            $config = $this->configs->getConfigItemById($id);
            $this->assign('config_type', C('CONFIG_TYPE_LIST'));
            $this->assign('config',$config);
            $this->display('add');
        }
    }
    
    private function doEdit(){
        $id = I('get.id');
//        $data['name'] = I('post.name');
        $data['title'] = I('post.title');
        $data['remark'] = I('post.remark');
        $data['group'] = I('post.group');
        $data['type'] = I('post.type');
        if($data['type'] > 3){
            $data['options'] = I('post.options');
        }
        $this->configs->updateConfigItem($id, $data);
        $err = $this->configs->getError();
        if($err){
            $this->error($err);
        }else{
            $this->success('修改成功！');
        }
    }
    
    public function deleteAction(){
        $ids = I('post.id');
        $this->configs->deleteConfigItem($ids);
        $err = $this->configs->getError();
        if($err){
            $this->error($err);
        }else{
            $this->success('删除成功！');
        }
    }
}