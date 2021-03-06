<?php
use Phalcon\Di\FactoryDefault;

error_reporting(E_ALL);

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');
define('UPLOAD_FILE', BASE_PATH . '/public/files/uploadFiles/');

define('PAYMENT', APP_PATH . '/library/payment');
define('WECHAT', PAYMENT. '/wechat');

date_default_timezone_set("Asia/Shanghai");

try {

    /**
     * The FactoryDefault Dependency Injector automatically registers
     * the services that provide a full stack framework.
     */
    $di = new FactoryDefault();

    /**
     * Handle routes
     */
    include APP_PATH . '/config/router.php';

    /**
     * Read services
     */
    include APP_PATH . '/config/services.php';

    /**
     * Get config service for use in inline setup below
     */
    $config = $di->getConfig();

    /**
     * Include Autoloader
     */
    include APP_PATH . '/config/loader.php';
    
    /**
     * Handle the request
     */
    $application = new \Phalcon\Mvc\Application($di);
    
    //echo str_replace(["\n","\r","\t"], '', $application->handle()->getContent());
    echo $application->handle()->getContent();

} catch (\Exception $e) {
    echo $e->getMessage() . '<br>';
    echo '<pre>' . $e->getTraceAsString() . '</pre>';
}
