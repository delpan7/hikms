<?php

defined('THINK_PATH') or exit();
return array(
    //'配置项'=>'配置值'
    'TMPL_CACHE_ON' => false,
    'DB_FIELDS_CACHE' => false,
    // 设置禁止访问的模块列表
    'MODULE_DENY_LIST' => array('Common', 'Api'),
    // 设置可以访问的模块列表
    'MODULE_ALLOW_LIST' => array('Home', 'Admin', 'User'),
    'DEFAULT_MODULE' => 'Home',
    // 加载扩展配置文件
    'LOAD_EXT_CONFIG' => 'db',
    // 显示页面Trace信息
    'SHOW_PAGE_TRACE' => true,
    
    //布局模板
    'LAYOUT_ON' => true,
    'LAYOUT_ON' => 'layout',
    
    //视图目录指定到最外层的Theme目录下面
//    'VIEW_PATH' => './Themes/',
    // 设置默认的模板主题
    'DEFAULT_THEME' => 'default',
    //启用差异主题定义方式,设置的主题下找不到指定模板时使用默认主题的模板
    'TMPL_LOAD_DEFAULTTHEME' => true,
    
    'LANG_SWITCH_ON' => true, // 开启语言包功能
    'LANG_AUTO_DETECT' => true, // 自动侦测语言 开启多语言功能后有效
    'LANG_LIST' => 'zh-cn,en', // 允许切换的语言列表 用逗号分隔
    'VAR_LANGUAGE' => 'l', // 默认语言切换变量
    
    'ACTION_SUFFIX' => 'Action',
    
//    'TOKEN_ON' => true, // 是否开启令牌验证 默认关闭
//    'TOKEN_NAME' => '__hash__', // 令牌验证的表单隐藏字段名称，默认为__hash__
//    'TOKEN_TYPE' => 'md5', //令牌哈希验证规则 默认为MD5
//    'TOKEN_RESET' => true, //令牌验证出错后是否重置令牌 默认为true
    
    'URL_MODEL' => 2,
    'URL_CASE_INSENSITIVE' => true,
    
    'COOKIE_PREFIX' => 'tt_',
    'COOKIE_EXPIRE' => 604800,//cookie 有效期7天
    'COOKIE_DOMAIN' => 'delpan.com',
    
    'SESSION_PREFIX' => 'tt_',
//    'SESSION_TYPE' => 'Db',
    'SESSION_EXPIRE' => 1800,//session 有效期30分钟
    
    'DATA_CRYPT_TYPE' => 'Base64',
    'DATA_CRYPT_KEY' => 'delpan', //加密key自定义
    
//    'DATA_CACHE_TYPE' => 'Memcache',//缓存类型
    
    
    'WIDGET_PATH' => './Application/Common/Widget/',
    
//    'AUTOLOAD_NAMESPACE' => array(
//        'Addons' => SITE_URL . 'Addons',
//    )
);
