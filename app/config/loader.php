<?php

$loader = new \Phalcon\Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerDirs(
    [
    	$config->application->controllersDir,
    	$config->application->controllerBaseDir,
    	$config->application->modelsDir,
    	$config->application->apiDir,
    	$config->application->libraryDir,
    	$config->application->adminDir,
    	$config->application->adminBaseDir,
    	$config->application->baseClassDir,
    	$config->application->wapAppDir,
    	//$config->application->wxpayDir
    		
    	$config->application->wechatDir,
    	$config->application->wechatLibDir,
    	$config->application->wechatUnitDir,
    ]
)->register();
