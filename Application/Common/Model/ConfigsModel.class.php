<?php
/**
 * Description of ConfigsModel
 *
 * @author delpan <delpan.sinasae.com>
 * @email 243334464@qq.com
 * @date 2014-5-21
 */
namespace Common\Model;
use Common\Core\Model;
class ConfigsModel extends Model {
    
    /**
     * 获取所有配置项
     * @param int $group 分组id 为空显示所有
     * @return array  分组下的所有配置项
     */
    public function getConfigs() {
        $datas = $this->field('name, type, value')->order('sort asc')->select();
        foreach ($datas as $data) {
            if($data['type'] == 3){
                $configs[$data['name']] = optionStrToArr($data['value']);
            }
        }
        return $configs;
    }
    
}
