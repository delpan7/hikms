<?php
// +----------------------------------------------------------------------
// | AskCms 
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.askcms.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 百变的石头 tj.youxiang.2008@163.com
// +----------------------------------------------------------------------
// | ThinkPHP 3.2.2 模板与APP分离插件，便于集中皮肤管理和切换使用
// +----------------------------------------------------------------------

namespace Common\Behavior;
use Think\Behavior;

defined('THINK_PATH') or exit();

// 初始化模板信息，把模板配置到单独目录与APP分离，便于后续扩展多模板
class CheckLoginBehavior extends Behavior {

    // 行为扩展的执行入口必须是run
    public function run(&$default){
        
        // 获取当前主题名称
        $theme = $this->getTemplateTheme();

        // 获取当前模块
        $module   =  MODULE_NAME;
        
        //EXT_TMPL_PATH 自定义的配置项
        // 获取当前主题的模版路径
        if(!defined('THEME_PATH')){
            define('THEME_PATH', C('EXT_TMPL_ON') && C('EXT_TMPL_PATH') ? C('EXT_TMPL_PATH').'/'.$theme.$module.'/' : APP_PATH.$module.'/'.C('DEFAULT_V_LAYER').'/'.$theme);
        }
        
    }
    
    /**
     * 获取当前的模板主题
     * 摘自ThinkPHP/Library/Think/View.class.php
     * @access private
     * @return string
     */
    private function getTemplateTheme(){
            
            /* 获取模板主题名称 */
            $theme =  C('DEFAULT_THEME');
            if(C('TMPL_DETECT_THEME')) {// 自动侦测模板主题
                $t = C('VAR_TEMPLATE');
                if (isset($_GET[$t])){
                    $theme = strtolower( $_GET[$t] );
                }elseif(cookie('think_template')){
                    $theme = cookie('think_template');
                }
                if(!in_array(strtolower($theme),explode(',',  strtolower( C('THEME_LIST') ) ))){
                    $theme =  C('DEFAULT_THEME');
                }
                
                cookie('think_template',$theme,864000);
            }
            
            defined('THEME_NAME') || define('THEME_NAME',   $theme);                  // 当前模板主题名称
            return $theme?$theme . '/':'';
    }
    
    
}