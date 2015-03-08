<?php
/**
 * Description of UserController
 *
 * @author delpan <delpan.sinasae.com>
 * @email 243334464@qq.com
 * @date 2014-4-7
 */
namespace Admin\Controller;
class ArticleController extends BaseController {
    
    public function _initialize() {
        parent::_initialize();
        $this->Articles = D('Article');
    }
    public function indexAction(){
        $channel_id = I('get.channel_id', 0, 'intval');
        $list = $this->Articles->getList($channel_id);
        $this->assign($list);
        $this->display();
    }
    public function addAction(){
        if(IS_POST){
            $this->doAdd();
        }else{
            $model_id = 1;
            $fields = D('Models')->getModelFieldsByModelId($model_id);
            $this->assign('fields', $fields);
            $this->display();
        }
    }
    private function doAdd(){
        $data['title'] = I('post.title');
        $data['uid'] = session('uid');
        $data['thumb_pic'] = I('post.thumb_pic');
        $data['summary'] = I('post.summary');
        $data['channel_id'] = I('post.channel_id', 0, 'intval');
        $data['is_best'] = I('post.is_best', 0, 'intval');
        $data['is_bad'] = I('post.is_bad', 0, 'intval');
        $data['is_lock'] = I('post.is_lock', 0, 'intval');
        $data['content'] = I('post.content');
        $this->Articles->addArticle($data);
        $err = $this->Articles->getError();
        if($err){
            $this->error($err);
        }else{
            $jumpUrl = U('Admin/Article/index');
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
            $model_id = 1;
            $fields = D('Models')->getModelFieldsByModelId($model_id);
            $info = $this->Articles->getArticleById($id);
            $this->assign('fields', $fields);
            $this->assign('info',$info);
            $this->display('add');
        }
    }
    private function doEdit(){
        $data['id'] = I('get.id', 0, 'intval');
        $data['title'] = I('post.title');
        $data['uid'] = session('uid');
        $data['thumb_pic'] = I('post.thumb_pic');
        $data['summary'] = I('post.summary');
        $data['channel_id'] = I('post.channel_id', 0, 'intval');
        $data['is_best'] = I('post.is_best', 0, 'intval');
        $data['is_bad'] = I('post.is_bad', 0, 'intval');
        $data['is_lock'] = I('post.is_lock', 0, 'intval');
        $data['content'] = I('post.content');
        $this->Articles->updateArticle($data['id'], $data);
        $err = $this->Articles->getError();
        if($err){
            $this->error($err);
        }else{
            $jumpUrl = U('Admin/Article/index');
            $this->success('修改成功！', $jumpUrl);
        }
    }
    
    public function deleteAction(){
        $ids = I('post.id');
        $this->Articles->deleteArticle($ids);
        $err = $this->Articles->getError();
        if($err){
            $this->error($err);
        }else{
            $jumpUrl = U('Admin/Article/index');
            $this->success('删除成功！', $jumpUrl);
        }
    }
}