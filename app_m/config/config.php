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
		'baseUri'=>'/m/'
	),'webmis'=>array(
		'appTitle'=>'WebMIS Mobile Phone',
		'appCopy'=>'<a href="https://ksphp.github.io/" target="_blank"><b>WebMIS</b></a>',
		'defaultThemes'=>'default',
		'webmisThemes'=>'default',
		'jqueryName'=>'jquery-3.min.js'
	)
);