<?php

/**
 * Description of Controller
 *
 * @author delpan <delpan.sinasae.com>
 * @email 243334464@qq.com
 * @date 2014-5-22
 */

namespace Common\Core;

class Controller extends \Think\Controller {

    /**
     * 架构函数 取得模板对象实例
     * @access public
     */
    public function __construct() {
        $configs = model('Configs')->getConfigs();
        C($configs);
        
        parent::__construct();
    }
    
    public function getTitleAndNav($data) {
        
    }
}
