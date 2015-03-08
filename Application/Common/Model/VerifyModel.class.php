<?php
/**
 * Description of UsersModel
 *
 * @author Administrator
 */
namespace Common\Model;
use Common\Core\Model;
use Think\Verify;
class VerifyModel{
    
    public function Verify($config = array()) {
        $Verify = new Verify($config);
        return $Verify->entry();
    }
}
