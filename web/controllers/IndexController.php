<?php
class IndexController extends ControllerBase{
	public function initialize(){
		$this->tag->setTitle('Home');
		parent::initialize();
	}
	public function indexAction() {
		$this->view->setVar('css',array('index.css'));
		$this->view->setVar('js',array('index.js'));
		$this->view->setTemplateAfter(APP_THEMES.'/main');
	}
}
