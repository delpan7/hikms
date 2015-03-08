<?php
/**
 * Description of Settings
 *
 * @author delpan <delpan.sinasae.com>
 * @email 243334464@qq.com
 * @date 2014-5-2
 */
namespace Admin\Model;
use Common\Core\Model;
class ConfigsModel extends Model {
    
    protected $_validate = array(
        array('name', 'require', '请输入配置项标识！', self::MUST_VALIDATE, 'function'), //配置项标识必填
        array('name', '', '配置项标识已经存在！', self::MUST_VALIDATE, 'unique', self::MODEL_INSERT), //配置项标识唯一 新增时验证
        array('title', 'require', '请输入配置项名称！', self::MUST_VALIDATE), // 配置项名称必填
        array('group', 'number', '请选择配置项分组！', self::MUST_VALIDATE), // 验证配置项分组是数字
        array('type', 'number', '请选择配置项类型！', self::MUST_VALIDATE), // 验证配置项类型是数字
    );
    
    protected $_auto = array(
        array('create_time', 'time', self::MODEL_INSERT, 'function'),
        array('update_time', 'time', self::MODEL_BOTH, 'function'),
    );
    
    /**
     * 根据分组id返回分组下的所有配置项
     * @param int $group 分组id 为空显示所有
     * @return array  分组下的所有配置项
     */
    public function getConfigItems(int $group) {
        $map = array();
        if($group !== ''){
            $map['group'] = $group;
        }
        $configs = $this->where($map)->order('sort asc')->select();
        foreach ($configs as &$config) {
            $config['options'] = $this->parse($config['type'], $config['options']);
        }
        return $configs;
    }
    
    /**
     * 根据id返回配置项信息
     * @param int $id 配置项id
     * @return array  返回配置项信息
     */
    public function getConfigItemById(int $id) {
        $map['id'] = intval($id);
        $config = $this->where($map)->find();
        return $config;
    }
    
    /**
     * 根据字段名获取配置项信息
     * @param string $name 字段名
     * @return array 配置项信息数组
     */
    public function getConfigByName(string $name) {
        $key = 'sys_config_'.$name;
        $config = S($key);
        if(!$config){
            $map['name'] = $name;
            $config = $this->where($map)->field('type,value')->find();
            if($config['type'] == 3){
                $config['value'] = $this->parseByDate($config['value']);
            }
            $config = $config['value'];
            S($key, $config);
        }
        return $config;
    }
    
    /**
     * 根据配置类型解析配置
     * @param  integer $type  配置类型
     * @param  string  $value 配置值
     */
    private function parse($type, $value){
        switch ($type) {
            case 4: //枚举
            case 5: //多选
                $value = optionStrToArr($value);
                break;
        }
        return $value;
    }

    /**
     * 添加配置项
     * @param array $data
     * @return boolean 
     */
    public function addConfigItem(array $data = array()) {
        if($this->create($data)){
            if($id = $this->add()){
                return $id;
            }
        }
        return FALSE;
    }
    
    /**
     * 修改单个配置项信息
     * @param int $id 配置项id 
     * @param array $data 要修改的配置项
     * @return boolean
     */
    public function updateConfigItem(int $id, array $data = array()) {
        $map['id'] = $id;
        if($this->create($data)){
            if($this->where($map)->save($data)){
                return TRUE;
            }
        }
        return FALSE;
    }
    
    public function deleteConfigItem($ids) {
        $map['id'] = whereCan($ids);
        return $this->where($map)->delete();
    }
    
    /**
     * 保存配置项的值
     * @param array $datas 要修改的配置项数组，二维数组
     * @return boolean
     */
    public function updateConfigs(array $datas = array()) {
        foreach ($datas as $data) {
            $map['name'] = $data['name'];
            if(!$this->where($map)->save(array('value'=>$data['value']))){
                return FALSE;
            }
        }
        return TRUE;
    }
}
