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
		'baseUri'=>'/data/'
	),'webmis'=>array(
		'appTitle'=>'WebMIS APP Data',
		'appCopy'=>'<a href="https://ksphp.github.io/" target="_blank"><b>WebMIS</b></a>'
	)
);