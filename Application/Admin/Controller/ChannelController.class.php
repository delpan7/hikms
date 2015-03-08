<?php
/**
 * Description of UserController
 *
 * @author delpan <delpan.sinasae.com>
 * @email 243334464@qq.com
 * @date 2014-4-7
 */

namespace Admin\Controller;

class ChannelController extends BaseController {
    
    public function _initialize() {
        parent::_initialize();
        $this->channels = D('Channels');
    }
    
    public function indexAction() {
        $channels = $this->channels->getChannels();
        $channel_tree = getTree($channels);
        $channel_tree_str = D('Channels', 'Logic')->getFormatTree($channel_tree);
        $this->assign('channel_tree', $channel_tree_str);
        $this->display();
    }
    public function addAction(){
        if(IS_POST){
            $this->doAdd();
        }else{
            $models = D('Models')->getModels();
            $model_id = I('get.model_id', 0, 'intval');
            $this->assign('models', $models);
            $this->assign('model_id', $model_id);
            $this->display();
        }
    }
    private function doAdd(){
        $data['fid'] = I('post.fid', 0, 'intval');
        $data['name'] = I('post.name');
        $data['model_id'] = I('post.model_id', 0, 'intval');
        $data['keywords'] = I('post.keywords');
        $data['description'] = I('post.description');
        $data['url'] = I('post.url');
        $data['content'] = I('post.content');
        $this->channels->addChannel($data);
        $err = $this->channels->getError();
        if($err){
            $this->error($err);
        }else{
            $jumpUrl = U('Admin/Channel/index');
            $this->success('添加成功！', $jumpUrl);
        }
    }
    public function editAction(){
        if(IS_POST){
            $this->doEdit();
        }else{
            $id = I('get.id', 0, 'intval');
            if(!$id){
                $this->error('参数错误！');
            }
            $channel = $this->channels->getChannelById($id);
            $this->assign($channel);
            $this->display('add');
        }
    }
    private function doEdit(){
        $data['id'] = I('post.id', 0, 'intval');
        $data['fid'] = I('post.fid', 0, 'intval');
        $data['name'] = I('post.name');
        $data['model_id'] = I('post.model_id', 0, 'intval');
        $data['keywords'] = I('post.keywords');
        $data['description'] = I('post.description');
        $data['url'] = I('post.url');
        $data['content'] = I('post.content');
        $this->channels->updateChannel($data['id'], $data);
        $err = $this->channels->getError();
        if($err){
            $this->error($err);
        }else{
            $jumpUrl = U('Admin/Channel/index');
            $this->success('修改成功！', $jumpUrl);
        }
    }
    
    public function deleteAction(){
        $ids = I('post.id');
        $this->channels->deleteChannel($ids);
        $err = $this->channels->getError();
        if($err){
            $this->error($err);
        }else{
            $jumpUrl = U('Admin/Channel/index');
            $this->success('删除成功！', $jumpUrl);
        }
    }
}
