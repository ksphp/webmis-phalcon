<?php
class LogController extends ControllerBase{
	public function initialize(){
		$this->tag->setTitle('Log');
		parent::initialize();
	}
	public function indexAction(){
		//默认后台样式
		$this->view->setTemplateAfter(APP_THEMES.'/main');
	}
}
