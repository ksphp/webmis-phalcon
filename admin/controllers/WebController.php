<?php
class WebController extends ControllerBase{
	public function initialize(){
		$this->tag->setTitle('Web');
		parent::initialize();
	}
	public function indexAction(){
		$Menus = $this->getMenus();
		$this->view->setVar('Menus',$Menus);
		$this->view->setTemplateAfter(APP_THEMES.'/main');
	}
}
