<?php
$loader = new \Phalcon\Loader();
/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerDirs(
	array(
		APP_PATH . $config->application->controllersDir,
		APP_PATH . $config->application->pluginsDir,
		APP_PATH . $config->application->libraryDir,
		APP_PATH . $config->application->modelsDir,
		APP_PATH . $config->application->formsDir,
	)
)->register();

/* Constant */
define('APP_NAME', $config->application->baseUri);
define('APP_BACKUP', $config->webmis->backupDir);
define('APP_TITLE', $config->webmis->appTitle);
define('APP_COPY', $config->webmis->appCopy);
define('APP_THEMES', $config->webmis->defaultThemes);
define('WEBMIS_THEMES', $config->webmis->webmisThemes);
define('JQUERY_NAME', $config->webmis->jqueryName);
