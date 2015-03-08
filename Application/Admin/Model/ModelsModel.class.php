<?php

/**
 * Description of ModelModel
 *
 * @author delpan <delpan.sinasae.com>
 * @email 243334464@qq.com
 * @date 2014-5-4
 */
namespace Admin\Model;
use Common\Core\Model;
class ModelsModel extends Model {
    
    protected $_validate = array(
        array('name', 'require', '请输入模型标识！', self::MUST_VALIDATE, 'function', self::MODEL_INSERT), //模型标识必填
        array('name', '/\w+/', '模型标识必须由下划线和单词字符组成！', self::MUST_VALIDATE, 'regex', self::MODEL_INSERT), //模型标识 只能由包括下划线和单词字符组成
        array('name', '', '模型标识已经存在！', self::MUST_VALIDATE, 'unique', self::MODEL_INSERT), //模型标识唯一 新增时验证
        array('title', 'require', '请输入模型名称！', self::MUST_VALIDATE), // 模型项名称必填
    );
    
    protected $_auto = array(
        array('create_time', 'time', self::MODEL_INSERT, 'function'),
        array('update_time', 'time', self::MODEL_BOTH, 'function'),
    );
    
    /**
     * 获取模型列表
     * @return array
     */
    public function getModels() {
        return $this->select();
    }
    
    /**
     * 获取单个模型信息
     * @param int $id
     * @return array
     */
    public function getModelById($id) {
        $map['id'] = intval($id);
        return $this->where($map)->find();
    }
    
    /**
     * 添加模型
     * @param array $data
     * @return boolean
     */
    public function addModel($data) {
        if($this->create($data)){
            if($id = $this->add()){
                return $id;
            }
        }
        return FALSE;
    }
    
    /**
     * 修改模型信息
     * @param int $id
     * @param array $data
     * @return boolean
     */
    public function updateModel($id, $data) {
        $map['id'] = intval($id);
        if($this->create($data)){
            if($this->where($map)->save($data)){
                return TRUE;
            }
        }
        return FALSE;
    }
    
    /**
     * 删除一个或多个模型
     * @param mixed $ids  要删除的模型id 支持逗号分割的字符和数组
     * @return boolean
     */
    function deleteModel($ids) {
        $map['id'] = whereCan($ids);
        return $this->where($map)->delete();
    }
    
    /**
     * 生成一个或多个模型表
     * @param mixed $model_ids 模型支持字符串和数组
     */
    public function createModels($model_ids) {
        if(!is_array($model_ids)){
            $model_ids = explode(',', filterStrPunc($model_ids));
        }
        foreach($model_ids as $model_ids){
            $this->createModelTable($model_ids);
        }
    }
    
    public function getModelFieldsByModelId($model_id) {
        $model_info = $this->getModelById($model_id);
        $fields = D('Fields')->getFieldList($model_id, $model_info['type']);
        $field_order = array_filter(explode(',', $model_info['field_order']));
        if($field_order){
            foreach ($field_order as &$value) {
                $value = $fields[$value];
            }
        }
        return $field_order;
    }
    
    public function updateSort($model_id, $field_id) {
        $model_info = $this->getModelById($model_id);
        $model_info['field_order'] = $model_info['field_order'] ? $model_info['field_order'].','.$field_id : $field_id;
        $this->where('id='.$model_id)->save(array('field_order' => $model_info['field_order']));
    }
    
    /**
     * 生成单个模型表
     * @param int $model_id
     */
    public function createModelTable($model_id) {
        $model = $this->getModelById($model_id);
        $fields = D('Fields')->getFieldList($model_id);
        $fields_str = $fields_primary = '';
        if($model['need_pk']){
            $fields_str = '`id` int(11) unsigned NOT NULL AUTO_INCREMENT,';
            $fields_primary = ",PRIMARY KEY (`id`)";
        }
        
        $fields_str_arr = array();
        foreach($fields as $field){
            $func = "get{$field['type']}FieldStr";
            $fields_str_arr[] = $this->$func($field);
        }
        $fields_str .= implode(',', $fields_str_arr);
        $fields_str .= $fields_primary;
        $table_name = C('DB_PREFIX')."document_".$model['name'];
        $delete_table_sql = "DROP TABLE IF EXISTS `{$table_name}`";
        $create_table_sql = "CREATE TABLE `{$table_name}` (
  $fields_str
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
        M()->execute($delete_table_sql);
        M()->execute($create_table_sql);
    }
    
    /**
     * 生成建表数字字段sql
     * @param array $field_data
     * @return string
     */
    private function getNumberFieldStr($field_data) {
        $len = $field_data['len'] ? : 10;
        switch ($field_data['len']) {
            case $field_data['len'] < 4:
                $type = 'tinyint';
                break;
            case $field_data['len'] < 6:
                $type = 'smallint';
                break;
            case $field_data['len'] < 9:
                $type = 'mediumint';
                break;
            case $field_data['len'] < 11:
                $type = 'int';
                break;
            case $field_data['len'] > 11:
                $type = 'bigint';
                break;
        }
        $default = intval($field_data['default_value']) ? : 0;
        $res = "`{$field_data['name']}` {$type}({$len}) unsigned NOT NULL DEFAULT '{$default}' COMMENT '{$field_data['title']}'";
        return $res;
    }
    
    private function getStringFieldStr($field_data) {
        $len = $field_data['len'] ? : 30;
        if($len <= 30){
            $type = "char";
        }else{
            $type = "varchar";
        }
        $default = $field_data['default_value'] ? : '';
        $res = "`{$field_data['name']}` {$type}({$len}) COLLATE utf8_bin NOT NULL DEFAULT '{$default}' COMMENT '{$field_data['title']}'";
        return $res;
    }
    
    private function getTextareaFieldStr($field_data) {
        $field_data['len'] = ($field_data['len'] > 100) ? intval($field_data['len']) : 255;
        return $this->getStringFieldStr($field_data);
    }
    
    private function getDatetimeFieldStr($field_data) {
        $field_data['len'] = 10;
        return $this->getNumberFieldStr($field_data);
    }
    private function getBoolFieldStr($field_data) {
        $field_data['len'] = 1;
        return $this->getNumberFieldStr($field_data);
    }
    private function getSelectFieldStr($field_data) {
        $field_data['options'] = optionStrToArr($field_data['options']);
        $is_int = TRUE;
        foreach($field_data['options'] as $key => $option){
            if(!is_intstr($key)){
                $is_int = FALSE;
            }
        }
        if($is_int){
            $field_data['len'] = intval($field_data['len']) ? : 3;
            return $this->getNumberFieldStr($field_data);
        }else{
            $enums = implode("','", array_keys($field_data['options']));
            $default = $field_data['default_value'] ? : '';
            $res = "`{$field_data['name']}` enum('{$enums}') COLLATE utf8_bin NOT NULL DEFAULT '{$default}' COMMENT '{$field_data['title']}'";
            return $res;
        }
    }
    private function getRadioFieldStr($field_data) {
        return $this->getSelectFieldStr($field_data);
    }
    private function getCheckboxFieldStr($field_data) {
        $sets = implode("','", array_keys($field_data['options']));
        $default = $field_data['default_value'] ? : '';
        $res = "`{$field_data['name']}` set('{$sets}') COLLATE utf8_bin NOT NULL DEFAULT '{$default}' COMMENT '{$field_data['title']}'";
        return $res;
    }
    
    private function getEditorFieldStr($field_data) {
        $res = "`{$field_data['name']}` text COLLATE utf8_bin NOT NULL COMMENT '{$field_data['title']}'";
        return $res;
    }
    
    private function getImageFieldStr($field_data) {
        $field_data['len'] = 10;
        $field_data['default_value'] = '';
        return $this->getNumberFieldStr($field_data);
    }
    
    private function getMultiimageFieldStr($field_data) {
        $field_data['len'] = 255;
        $field_data['default_value'] = '';
        return $this->getStringFieldStr($field_data);
    }
    private function getFileFieldStr($field_data) {
        $field_data['len'] = 255;
        $field_data['default_value'] = '';
        return $this->getStringFieldStr($field_data);
    }
}
