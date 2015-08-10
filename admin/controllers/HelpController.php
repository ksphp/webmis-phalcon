<?php
class HelpController extends ControllerBase{
	public function initialize(){
		$this->tag->setTitle('Help');
		parent::initialize();
	}
	public function indexAction(){
		//默认后台样式
		$this->view->setTemplateAfter(APP_THEMES.'/main');
	}
}
