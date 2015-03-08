<?php
defined('THINK_PATH') or exit();
return array(
	//'配置项'=>'配置值'
    'app_begin' => array('Behavior\CheckLangBehavior'),
    'view_filter' => array('Behavior\TokenBuildBehavior'),
    
);