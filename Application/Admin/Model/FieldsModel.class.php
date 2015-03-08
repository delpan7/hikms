<?php
/**
 * Description of FieldsModel
 *
 * @author delpan <delpan.sinasae.com>
 * @email 243334464@qq.com
 * @date 2014-5-6
 */
namespace Admin\Model;
use Common\Core\Model;
class FieldsModel extends Model {
    
    protected $_validate = array(
        array('model_id', 'require', '请输入模型id！', self::MUST_VALIDATE, 'function'), //模型id必填
        array('name', 'require', '请输入字段名！', self::MUST_VALIDATE, 'function', self::MODEL_INSERT), //字段名必填
        array('name', '/\w+/', '字段名必须由下划线和单词字符组成！', self::MUST_VALIDATE, 'regex', self::MODEL_INSERT), //字段名 只能由包括下划线和单词字符组成
        array('name', '', '字段名已经存在！', self::MUST_VALIDATE, 'unique', self::MODEL_INSERT), //字段名唯一 新增时验证
        array('title', 'require', '请输入字段标题！', self::MUST_VALIDATE, 'function'), //字段标题必填
        array('type', 'require', '请输入字段类型！', self::MUST_VALIDATE), // 字段类型必填
        array('model_id', '/\d+/', '模型id只能为整数！', self::MUST_VALIDATE, 'regex',), // 模型id必填
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
    public function getFieldList($model_id, $model_type = false) {
        if(!$model_type){
            $map['model_id'] = array('in', array(0, intval($model_id)));
        }else{
            $map['model_id'] = intval($model_id);
        }
        $field_list = $this->where($map)->select();
        return formatArrByValue($field_list, 'id');
    }
    
    public function getFieldById($id) {
        $map['id'] = intval($id);
        return $this->where($map)->find();
    }
    
    public function addField($data) {
        if($this->create($data)){
            if($id = $this->add()){
                return $id;
            }
        }
        return FALSE;
    }
    public function updateField($id, $data) {
        $map['id'] = intval($id);
        if($this->create($data)){
            if($this->where($map)->save($data)){
                return TRUE;
            }
        }
        return FALSE;
    }
    function deleteField($ids) {
        $map['id'] = whereCan($ids);
        return $this->where($map)->delete();
    }
}
