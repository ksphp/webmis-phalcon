<?php
class SysMenusController extends ControllerBase{
	// Index
	public function indexAction(){
		$Menus = $this->getMenus();
		$this->tag->appendTitle($this->Ctitle);
		$this->view->setVar('Menus',$Menus);
		$this->view->setTemplateAfter(APP_THEMES.'/main');
		$this->view->pick("system/menus/index");
	}
}