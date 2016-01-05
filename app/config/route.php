<?php
use Phalcon\Mvc\Micro\Collection as MicroCollection;

// 获取网站
$app->get('/getUrl', function () use ($app) {
	echo $app->url->get('');
});

/* 控制器  */
$posts = new MicroCollection();

// 首页
$posts->setHandler('IndexController', true)->setPrefix('/index');
$posts->get('/', 'index');
$posts->get('/show/{slug}', 'show');
$app->mount($posts);

// 测试
$posts->setHandler('TestController', true)->setPrefix('/test');
$posts->get('/', 'index');
$posts->get('/show/{text}', 'show');
$app->mount($posts);

