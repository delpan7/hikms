<?php
/**
 * 公用分类服务
 *
 * @author delpan
 * @email 243334464@qq.com
 * @date 2014-4-20
 */
namespace Common\Service;
use Think\Model;
class CategoryService extends Model {
    
    public function getusers() {
        $res = $this->find();
        return $res;
    }
}
