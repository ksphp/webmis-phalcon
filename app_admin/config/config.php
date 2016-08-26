<?php
return array(
	'database'=>array(
		'adapter'=>'Mysql',
		'host'=>'localhost',
		'username'=>'webmis',
		'password'=>'www.ksphp.com',
		'name'=>'pwebmis',
		'charset'=>'utf8'
	),'application'=>array(
		'controllersDir'=>'controllers',
		'modelsDir'=>'models',
		'viewsDir'=>'views',
		'pluginsDir'=>'plugins',
		'formsDir'=>'forms',
		'libraryDir'=>'library',
		'baseUri'=>'/admin/'
	),'webmis'=>array(
		'appTitle'=>'WebMIS Management',
		'appCopy'=>'<a href="http://www.ksphp.com/" target="_blank"><b>ksphp.com</b></a>',
		'defaultThemes'=>'default',
		'webmisThemes'=>'default',
		'jqueryName'=>'jquery-2.min.js',
		'backupDir'=>'/upload/backup/'
	)
);