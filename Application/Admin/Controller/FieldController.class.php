<?php

/**
 * Description of FieldController
 *
 * @author delpan <delpan.sinasae.com>
 * @email 243334464@qq.com
 * @date 2014-5-21
 */
namespace Admin\Controller;
class FieldController extends BaseController {
    
    private $fields;
    
    public function _initialize() {
        parent::_initialize();
        $this->fields = D('Fields');
    }
    
    public function indexAction() {
        $model_id = I('get.model_id', 0, 'intval');
        if(!$model_id){
            $this->error('参数错误！');
        }
        $fields = D('Models')->getModelFieldsByModelId($model_id);
        $this->assign('model_id', $model_id);
        $this->assign('fields', $fields);
        $this->display();
    }
    
    public function addAction() {
        if(IS_POST){
            $this->doAdd();
        }else{
            $model_id = I('get.model_id', 0, 'intval');
            if(!$model_id){
                $this->error('参数错误！');
            }
            $this->assign('field_types', C('MODEL_FIELD_TYPE'));
            $this->display();
        }
    }
    
    private function doAdd(){
        $data['model_id'] = I('post.model_id', 0, 'intval');
        $data['name'] = I('post.name');
        $data['title'] = I('post.title');
        $data['type'] = I('post.type');
        $data['len'] = I('post.len', 0, 'intval');
        $data['options'] = I('post.options');
        $data['default_value'] = I('post.default_value');
        $id = $this->fields->addField($data);
        $err = $this->fields->getError();
        if($err){
            $this->error($err);
        }else{
            D('Models')->updateSort($data['model_id'], $id);
            $err = D('Models')->getError();
            if($err){
                $this->error($err);
            }else{
                $jumpUrl = U('Admin/Field/index', array('model_id'=>$data['model_id']));
                $this->success('添加成功！', $jumpUrl);
            }
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
            $model = $this->fields->getFieldById($id);
            $this->assign('field_types', C('MODEL_FIELD_TYPE'));
            $this->assign('model',$model);
            $this->display('add');
        }
    }
    
    private function doEdit(){
        $model_id = I('post.model_id', 0, 'intval');
        $data['id'] = I('get.id', 0, 'intval');
//        $data['name'] = I('post.name');
        $data['type'] = I('post.type');
        $data['len'] = I('post.len', 0, 'intval');
        $data['options'] = I('post.options');
        $data['default_value'] = I('post.default_value');
        $this->fields->updateField($data['id'], $data);
        $err = $this->fields->getError();
        if($err){
            $this->error($err);
        }else{
            $jumpUrl = U('Admin/Field/index', array('model_id'=>$model_id));
            $this->success('修改成功！', $jumpUrl);
        }
    }
    
    public function deleteAction(){
        $model_id = I('get.model_id', 0, 'intval');
        $ids = I('post.id');
        $this->fields->deleteField($ids);
        $err = $this->fields->getError();
        if($err){
            $this->error($err);
        }else{
            $jumpUrl = U('Admin/Field/index', array('model_id'=>$model_id));
            $this->success('删除成功！', $jumpUrl);
        }
    }
    
}
