<?php
/**
 * Description of UsersModel
 *
 * @author delpan
 * @email 243334464@qq.com
 * @date 2014-4-20
 */
namespace Common\Model;
use Common\Core\Model;
class UsersModel extends Model {
    
    public function getusers() {
        $res = $this->find();
        return $res;
    }
    
    public function userLogin() {
        
    }
}
