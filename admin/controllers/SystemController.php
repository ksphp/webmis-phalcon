<?php
class SystemController extends ControllerBase{
	public function initialize(){
		$this->tag->setTitle('System');
		parent::initialize();
	}
	public function indexAction(){
		//默认后台样式
		$this->view->setTemplateAfter(APP_THEMES.'/main');
	}
}
