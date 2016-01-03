<?php
$loader = new \Phalcon\Loader();
/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerDirs(
	array(
		APP_PATH . $config->application->controllersDir,
		APP_PATH . $config->application->modelsDir,
		APP_PATH . $config->application->libraryDir,
	)
)->register();

/* Constant */
define('APP_NAME', $config->application->baseUri);
define('APP_TITLE', $config->webmis->appTitle);
define('APP_COPY', $config->webmis->appCopy);
