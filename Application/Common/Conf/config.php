<?php
return array(
	//'配置项'=>'配置值'

    'DB_TYPE'               =>  'mysql',     // 数据库类型
    'DB_HOST'               =>  '127.0.0.1', // 服务器地址
    'DB_NAME'               =>  'shop',          // 数据库名
    'DB_USER'               =>  'root',      // 用户名
    'DB_PWD'                =>  'root',          // 密码
    'DB_PORT'               =>  '3306',        // 端口
    'DB_PREFIX'             =>  'shop_',    // 数据库表前缀
    'DB_CHARSET'            =>  'utf8',      // 数据库编码默认采用utf8

    /***********图片相关配置 *******************/
    'IMG_maxSize'           =>  '3M',
    'IMG_exts'              => array('jpg','pjpeg','bmp','gif','png','jpeg'),
    'IMG_rootPath'          => './Public/Uploads/',
    /***********修改I函数底层过滤时使用的函数***********/
    /*默认使用htmlspecialchars*/
    'DEFAULT_FILTER'        => 'trim,removeXSS',
    //'SHOW_PAGE_TRACE' =>true,
    /***********MD5_KEY******************/
    'MD5_KEY'   =>'siodbbdosodk!sfds54351',

    /************** 发邮件的配置 ***************/
    'MAIL_ADDRESS' => '18659328891@163.com',   // 发货人的email
    'MAIL_FROM' => '曾焕新',      // 发货人姓名
    'MAIL_SMTP' => 'smtp.163.com',      // 邮件服务器的地址
    'MAIL_LOGINNAME' => '18659328891@163.com',
    'MAIL_PASSWORD' => 'zhx509509',//163邮箱用的授权码

);