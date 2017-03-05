<?php
return array(
	//'配置项'=>'配置值'

    'DB_TYPE'               =>  'mysql',     // 数据库类型
    'DB_HOST'               =>  '127.0.0.1', // 服务器地址
    'DB_NAME'               =>  'hr',          // 数据库名
    'DB_USER'               =>  'root',      // 用户名
    'DB_PWD'                =>  '',          // 密码
    'DB_PREFIX'	            =>	'h_',

    'DEFAULT_MODULE' => 'Home', // 默认模块
    'MODULE_ALLOW_LIST' => array('Home'),

    'URL_MODEL' =>2, // URL模式

    //'URL_ROUTER_ON' => true,

    'TMPL_PARSE_STRING' =>
        array(
            'PUBLIC' => '/Public',
            'CSS_PATH' => '/Public/css',
            'JS_PATH' => '/Public/js',
            'IMG_PATH' => '/Public/images',
            'UPLOAD' => '/uploads',
            'FILEPATH'=>'/Public/Uploads'
        ),


    //I方法 安全过滤

   'DEFAULT_FILTER'        =>  'strip_tags,stripslashes',





);