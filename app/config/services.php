<?php

use Phalcon\DI\FactoryDefault;
use Phalcon\Mvc\Url as UrlProvider;
use Phalcon\Session\Adapter\Files as SessionAdapter;

/* Framework */
$di = new FactoryDefault();

/*  URL */
$di->set('url', function() use ($config){
	$url = new UrlProvider();
	$url->setBaseUri($config->application->baseUri);
	return $url;
});

/* Database */
$di->set('db', function() use ($config) {
	$dbclass = 'Phalcon\Db\Adapter\Pdo\\' . $config->database->adapter;
	return new $dbclass(array(
		"host"      => $config->database->host,
		"username" => $config->database->username,
		"password" => $config->database->password,
		"dbname"   => $config->database->name,
		"charset"   => $config->database->charset
	));
});

/*  Session */
$di->set('session', function() {
	$session = new SessionAdapter();
	$session->start();
	return $session;
});

/* Library */
$di->set('inc', function () {
	return new Inc();
});