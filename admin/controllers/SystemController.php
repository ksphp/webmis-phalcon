<?php
class SystemController extends ControllerBase{
	public function initialize(){
		$this->tag->setTitle('System');
		parent::initialize();
	}
	public function indexAction(){
		$Menus = $this->getMenus();
		$this->view->setVar('Menus',$Menus);
		//默认后台样式
		$this->view->setTemplateAfter(APP_THEMES.'/main');
	}
}
