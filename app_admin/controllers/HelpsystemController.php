<?php
class HelpSystemController extends ControllerBase{
	// Index
	public function indexAction(){
		// Menus
		$this->view->setVar('Menus',$this->inc->getMenus());
		$this->tag->prependTitle($this->inc->Ctitle);
		// View
		$this->view->setTemplateAfter(APP_THEMES.'/main');
		$this->view->pick("help/system/index");
	}
}