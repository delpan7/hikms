<?php
/**
 * 字段显示插件
 *
 * @author delpan <delpan.sinasae.com>
 * @email 243334464@qq.com
 * @date 2014-5-9
 */
namespace Common\Widget;
use Common\Core\Widget;
class FieldWidget extends Widget {
    
    public function editor($data) {
        $this->assign($data);
        $this->display('editor');
    }
    
    public function image($data) {
        $this->assign($data);
        $this->display('image');
    }
    public function file($data) {
        $this->assign($data);
        $this->display('file');
    }
    
    public function _empty($method, $data) {
        $this->assign($data);
        $this->display($method);
    }
}
