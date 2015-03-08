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
class MembersModel extends Model {
    protected $_validate = array(
        array('username', 'require', '请输入用户名！', self::MUST_VALIDATE, 'function', self::MODEL_INSERT), //模型标识必填
        array('username', '/[\w@]+/', '用户名必须由下划线、单词、@字符组成！', self::MUST_VALIDATE, 'regex', self::MODEL_INSERT), //用户名 只能由包括下划线和单词字符组成
        array('username', '', '用户名已经存在！', self::MUST_VALIDATE, 'unique', self::MODEL_INSERT), //模型标识唯一 新增时验证
        array('password', 'require', '密码不能为空！', self::MUST_VALIDATE), // 模型项名称必填
        array('email', 'email', '邮箱格式错误！', self::EXISTS_VALIDATE, 'regex',), // 模型id必填
    );
    
    protected $_auto = array(
        array('password', 'md5', self::MODEL_BOTH, 'function'),
        array('reg_date', 'time', self::MODEL_INSERT, 'function'),
    );
    
    /**
     * 获取用户列表
     * @return type
     */
    public function getUsers() {
        $users = $this->where()->findPage(20);
        return $users;
    }
    
    /**
     * 获取单个用户信息
     * @param int $uid
     * @return array
     */
    public function getUserByUid($uid) {
        $map['uid'] = intval($uid);
        return $this->where($map)->find();
    }
    
    /**
     * 添加模型
     * @param array $data
     * @return boolean
     */
    public function addUser($data) {
        if($this->create($data)){
            if($uid = $this->add()){
                return $uid;
            }
        }
        return FALSE;
    }
    
    /**
     * 修改模型信息
     * @param int $uid
     * @param array $data
     * @return boolean
     */
    public function updateUser($uid, $data) {
        $map['uid'] = intval($uid);
        if($this->create($data)){
            if($this->where($map)->save($data)){
                return TRUE;
            }
        }
        return FALSE;
    }
    
    /**
     * 删除一个或多个模型
     * @param mixed $uids  要删除的模型id 支持逗号分割的字符和数组
     * @return boolean
     */
    function deleteUser($uids) {
        $map['uid'] = whereCan($uids);
        return $this->where($map)->delete();
    }
}
