<?php
class HelpSystemController extends ControllerBase{
	// Index
	public function indexAction(){
		$Menus = $this->getMenus();
		$this->tag->appendTitle($this->Ctitle);
		$this->view->setVar('Menus',$Menus);
		$this->view->setTemplateAfter(APP_THEMES.'/main');
		$this->view->pick("help/system/index");
	}
}