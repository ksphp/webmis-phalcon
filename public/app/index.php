<?php
error_reporting(E_ALL);

use Phalcon\Mvc\Micro;
use Phalcon\Config\Adapter\Ini as ConfigIni;

try {
	define('APP_PATH', realpath('../..') . '/app/');
	$config = new ConfigIni(APP_PATH . 'config/config.ini');
	require APP_PATH .'config/loader.php';
	require APP_PATH .'config/services.php';
	/* 创建APP */
	$app = new Micro($di);
	/*  URL */
	$app->url->setStaticBaseUri($app->inc->BaseUrl());
	$app->url->setBaseUri($app->inc->BaseUrl(APP_NAME));
	/*  City */
	$city = $app->session->get('City');
	if(empty($city)){$app->inc->getCity();}
	
	/*  路由表 */
	require APP_PATH .'config/route.php';
	
	/* 生成结果 */
	$app->handle();

} catch (Exception $e){
	echo $e->getMessage();
}
