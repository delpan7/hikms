<?php
/**
 * Description of ModelController
 *
 * @author delpan <delpan.sinasae.com>
 * @email 243334464@qq.com
 * @date 2014-5-4
 */
namespace Admin\Controller;
class ModelController extends BaseController {
    
    private $models;
    
    public function _initialize() {
        parent::_initialize();
        $this->models = D('Models');
    }
    
    public function indexAction() {
        $model_list = $this->models->getModels();
        
        $this->assign('model_list', $model_list);
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
        $data['name'] = I('post.name');
        $data['title'] = I('post.title');
        $data['type'] = I('post.type', 0, 'intval');
        $data['need_pk'] = I('post.need_pk');
        $data['engine_type'] = I('post.engine_type');
        $this->models->addModel($data);
        $err = $this->models->getError();
        if($err){
            $this->error($err);
        }else{
            $jumpUrl = U('Admin/Model/index');
            $this->success('添加成功！', $jumpUrl);
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
            $model = $this->models->getModelById($id);
            $this->assign('model',$model);
            $this->display('add');
        }
    }
    
    private function doEdit(){
        $data['id'] = I('get.id', 0, 'intval');
//        $data['name'] = I('post.name');
        $data['title'] = I('post.title');
//        $data['type'] = I('post.type', 0, 'intval');
//        $data['need_pk'] = I('post.need_pk');
//        $data['engine_type'] = I('post.engine_type');
        $this->models->updateModel($data['id'], $data);
        $err = $this->models->getError();
        if($err){
            $this->error($err);
        }else{
            $jumpUrl = U('Admin/Model/index');
            $this->success('修改成功！', $jumpUrl);
        }
    }
    
    public function deleteAction(){
        $ids = I('post.id', 0, 'intval');
        $this->models->deleteModel($ids);
        $err = $this->models->getError();
        if($err){
            $this->error($err);
        }else{
            $jumpUrl = U('Admin/Model/index');
            $this->success('删除成功！', $jumpUrl);
        }
    }
    
    public function createModelAction(){
        $ids = I('post.id');
        $this->models->createModels($ids);
        $err = $this->models->getError();
        if($err){
            $this->error($err);
        }else{
            $this->success('生成模型成功！');
        }
    }
    
}
