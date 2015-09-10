<?php
error_reporting(E_ALL);

use Phalcon\Mvc\Application;
use Phalcon\Config\Adapter\Ini as ConfigIni;

try {
	define('APP_PATH', realpath('..') . '/app_web/');

	/**
	 * Read the configuration
	 */
	$config = new ConfigIni(APP_PATH . 'config/config.ini');
	
	/**
	 * Constant
	 */
	define('APP_NAME', $config->application->baseUri);
	define('APP_TITLE', $config->webmis->appTitle);
	define('APP_COPY', $config->webmis->appCopy);
	define('APP_THEMES', $config->webmis->defaultThemes);
	define('WEBMIS_THEMES', $config->webmis->webmisThemes);
	define('JQUERY_NAME', $config->webmis->jqueryName);
	// Project URL
	function base_url($url=''){
		$base_url = $_SERVER['SERVER_PORT']=='443'?'https://':'http://';
		$base_url .= $_SERVER['HTTP_HOST'].APP_NAME.$url;
		echo $base_url;
	}

	/**
	 * Auto-loader configuration
	 */
	require APP_PATH .'/config/loader.php';

	/**
	 * Load application services
	 */
	require APP_PATH .'/config/services.php';
	$application = new Application($di);
	echo $application->handle()->getContent();

} catch (Exception $e){
	echo $e->getMessage();
}
