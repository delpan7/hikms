<?php

/**
 * Description of MenuModel
 *
 * @author delpan <delpan.sinasae.com>
 * @email 243334464@qq.com
 * @date 2014-5-3
 */
namespace Admin\Model;
use Common\Core\Model;
class MenuModel extends Model {
    
    /**
     * 
     * @param int $pid
     * @param boolean $is_show
     * @return type
     */
    public function getMenus($pid='', $is_show=TRUE) {
        $map = array();
        if($pid !== ''){
            $map['pid'] = $pid;
        }
        if($is_show){
            $map['hide'] = 0;
        }
        $menus = $this->where($map)->order('pid DESC,sort ASC')->select();
        $menus = $this->getFormatTree($menus);
        return $menus;
    }
    /**
     * 将一个数组格式化成树结构
     * @param array $arrs
     * @return array
     */
    function getFormatTree(array $arrs) {
        foreach($arrs as $f_key=>$f_arr){
            foreach($arrs as $key=>$arr){
                $urls = explode('?', $arr['url']);
                $arr['url'] = U($urls[0],$urls[1]);//菜单URL
                //子级菜单$arr['active'] == 1 或者 当前链接与 $arr['url'] 相等 将菜单设为作用
                $arr['active'] = intval($arr['active'] || (strtolower(MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME) == strtolower($urls[0])) ? 1 : 0);//菜单焦点
                
                if($f_arr['id'] == $arr['pid']){
                    $arrs[$f_key]['children'][] = $arr;
                    $arrs[$f_key]['active'] = intval($arrs[$f_key]['active'] || $arr['active']);//菜单焦点
                    unset($arrs[$key]);
                }
            }
            $children = $arrs[$f_key]['children'];
            if(isset($children) && !empty($children)){
                $arrs[$f_key]['children'] = $this->getFormatTree($children);
            }
        }
        return $arrs;
    }
}
