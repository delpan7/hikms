<?php
/**
 * Description of UserController
 *
 * @author delpan <delpan.sinasae.com>
 * @email 243334464@qq.com
 * @date 2014-4-7
 */
namespace Admin\Controller;
use Common\Core\Controller;
class BaseController extends Controller {
    
    public function _initialize(){
        if(service('Members')->isLogin()){
            $menus = D('Menu')->getMenus();
            $this->assign('menus', $menus);
        }else{
            $this->redirect('Public/login');
        }
    }
}