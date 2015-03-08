<?php
/**
 * 分类插件
 *
 * @author delpan
 * @email 243334464@qq.com
 * @date 2014-4-20
 */
namespace Common\Widget;
use Think\Controller;
class CateWidget extends Controller {
    
    public function getusers() {
        $res = $this->find();
        return $res;
    }
}
