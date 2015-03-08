<?php
/**
 * Description of ArticlesModel
 *
 * @author delpan <delpan.sinasae.com>
 * @email 243334464@qq.com
 * @date 2014-5-6
 */
namespace Admin\Model;
use Common\Core\Model;
class ArticleModel extends Model {
    
    protected $_validate = array(
        array('title', 'require', '请输入标题！', self::MUST_VALIDATE, 'function'), //字段标题必填
    );
    
    protected $_auto = array(
        array('create_time', 'time', self::MODEL_INSERT, 'function'),
        array('update_time', 'time', self::MODEL_BOTH, 'function'),
    );
    
    /**
     * 根据模型id获取模型字段列表
     * @param int $model_id
     * @param bool $model_type 模型类型 文档模型为false 独立模型为true
     * @return type
     */
    public function getList($channel_id = 0) {
        $map = array();
        if($channel_id){
            $map['channel_id'] = intval($channel_id);
        }
        $list = $this->where($map)->findPage(20);
        return $list;
    }
    public function getArticleById($id) {
        $map['id'] = intval($id);
        return $this->where($map)->find();
    }
    
    public function addArticle($data) {
        if($this->create($data)){
            if($this->add()){
                return TRUE;
            }
        }
        return FALSE;
    }
    public function updateArticle($id, $data) {
        $map['id'] = intval($id);
        if($this->create($data)){
            if($this->where($map)->save($data)){
                return TRUE;
            }
        }
        return FALSE;
    }
    function deleteArticle($ids) {
        $map['id'] = whereCan($ids);
        return $this->where($map)->delete();
    }
    
}
