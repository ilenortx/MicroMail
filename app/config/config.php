<?php
/*
 * Modified: prepend directory path of current file, because of this file own different ENV under between Apache and command line.
 * NOTE: please remove this comment.
 */
defined('BASE_PATH') || define('BASE_PATH', getenv('BASE_PATH') ?: realpath(dirname(__FILE__) . '/../..'));
defined('APP_PATH') || define('APP_PATH', BASE_PATH . '/app');

return new \Phalcon\Config([
    'database' => [
        'adapter'     => 'Mysql',
        'host'        => '127.0.0.1',
        'username'    => 'root',
        'password'    => 'root',
        'dbname'      => 'micro_mail',
        'charset'     => 'utf8',
    ],
    'application' => [
        'appDir'         => APP_PATH . '/',
        'controllersDir' => APP_PATH . '/controllers/',
        'modelsDir'      => APP_PATH . '/models/',
        'migrationsDir'  => APP_PATH . '/migrations/',
        'viewsDir'       => APP_PATH . '/views/',
        'pluginsDir'     => APP_PATH . '/plugins/',
        'libraryDir'     => APP_PATH . '/library/',
        'cacheDir'       => BASE_PATH . '/cache/',
    	'controllerBaseDir'	=>	APP_PATH . '/controllers/controllerBase',
    	'apiDir'			=>	APP_PATH . '/controllers/api',
    	'adminDir'			=>	APP_PATH . '/controllers/admin',
    	'adminBaseDir'	=>	APP_PATH . '/controllers/admin/baseClass',
    	'baseClassDir'	 => APP_PATH . '/controllers/baseClass',
    	'wapAppDir'	 => APP_PATH . '/controllers/wapApp',
    		
    	'wechatDir'		 => APP_PATH. '/library/payment/wechat/',
    	'wechatLibDir'	 => APP_PATH. '/library/payment/wechat/lib/',	//微信支付lib
    	'wechatUnitDir'	 => APP_PATH. '/library/payment/wechat/unit/',	
    		
    	//'wxpayDir'			=>	APP_PATH . '/library/Vendor/wxpay/lib',

        // This allows the baseUri to be understand project paths that are not in the root directory
        // of the webpspace.  This will break if the public/index.php entry point is moved or
        // possibly if the web server rewrite rules are changed. This can also be set to a static path.
        'baseUri'        => preg_replace('/public([\/\\\\])index.php$/', '', $_SERVER["PHP_SELF"]),
    ],
    //微信配置参数
	'weixin'=>array(
		/* 'appid' =>'wx037610bf3e789682',
		 'secret'=>'78824d0281cc688ef7610dc524198cdd',
		 'mchid' => '1508152761',
		 'key' => 'sdjfklj12341AAJSDK234dkfjsjkflja', */
			'appid' =>'wxdf13b6ed712b9248',
			'secret'=>'1c2cf72abd7d6c3f1058925dc21e6ff1',
			'mchid' => '1494649292',
			'key' => 'sdfhnjk9w23ufkaSJF23jfksjadfklja',
				
		//这里是异步通知页面url，提交到项目的Pay控制器的notifyurl方法；
		'notify_url'=>'https://xxx.xxxx.com/index.php/Api/Wxpay/notify',
				
	),
]);
