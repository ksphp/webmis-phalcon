<?php
class LogController extends ControllerBase{
	public function initialize(){
		$this->tag->setTitle('Log');
		parent::initialize();
	}
	public function indexAction(){
		$Menus = $this->getMenus();
		$this->view->setVar('Menus',$Menus);
		$this->view->setTemplateAfter(APP_THEMES.'/main');
	}
}
