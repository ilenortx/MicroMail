<?php

$router = $di->getRouter();

if (gettype(strpos($_SERVER['SERVER_NAME'], 'admin'))=='integer' && strpos($_SERVER['SERVER_NAME'], 'www')>=0){
	$router->add("/",array( "controller"=>"Admin", "action"=>"index"));
}

$router->handle();
