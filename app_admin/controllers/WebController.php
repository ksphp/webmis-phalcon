<?php
class WebController extends ControllerBase{
	// Index
	public function indexAction(){
		$Menus = $this->inc->getMenus();
		$this->tag->prependTitle($this->inc->Ctitle);
		$this->view->setVar('Menus',$Menus);
		$this->view->setTemplateAfter(APP_THEMES.'/main');
	}
}
