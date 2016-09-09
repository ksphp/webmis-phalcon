<?php
return array(
	'database'=>array(
		'adapter'=>'Mysql',
		'host'=>'localhost',
		'username'=>'webmis',
		'password'=>'webmis',
		'name'=>'webmis',
		'charset'=>'utf8'
	),'application'=>array(
		'controllersDir'=>'controllers',
		'modelsDir'=>'models',
		'viewsDir'=>'views',
		'pluginsDir'=>'plugins',
		'formsDir'=>'forms',
		'libraryDir'=>'library',
		'baseUri'=>'/'
	),'webmis'=>array(
		'appTitle'=>'WebMIS Web Site',
		'appCopy'=>'<a href="http://www.ksphp.com/" target="_blank"><b>ksphp.com</b></a>',
		'defaultThemes'=>'default',
		'webmisThemes'=>'default',
		'jqueryName'=>'jquery-3.min.js'
	)
);