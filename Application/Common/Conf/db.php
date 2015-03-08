<?php
return array(
	//'配置项'=>'配置值'
    'TMPL_CACHE_ON'         =>  false,
    'DB_FIELDS_CACHE'       =>  false,
	//分布式数据库配置定义
	'DB_DEPLOY_TYPE'=> 1, // 设置分布式数据库支持
	'DB_TYPE'       => 'mysqli', //分布式数据库类型必须相同
	'DB_HOST'       => '127.0.0.1,127.0.0.1',
	'DB_NAME'       => 'think_test', //如果相同可以不用定义多个
	'DB_USER'       => 'root',
	'DB_PWD'        => '',
	'DB_PORT'       => '3306',
	'DB_PREFIX'     => 'tt_',
    
//	'DB_TYPE'       => 'mysqli', //分布式数据库类型必须相同
//	'DB_HOST'       => SAE_MYSQL_HOST_M. ','.SAE_MYSQL_HOST_S,
//	'DB_NAME'       => SAE_MYSQL_DB, //如果相同可以不用定义多个
//	'DB_USER'       => SAE_MYSQL_USER,
//	'DB_PWD'        => SAE_MYSQL_PASS,
//    'DB_PORT'       =>  SAE_MYSQL_PORT,
    
    'DB_RW_SEPARATE'=>true,//设置读写分离
);