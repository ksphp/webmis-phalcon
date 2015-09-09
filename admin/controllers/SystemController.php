<?php
class SystemController extends ControllerBase{
	// Index
	public function indexAction(){
		$Menus = $this->getMenus();
		$this->tag->appendTitle($this->Ctitle);
		$this->view->setVar('Menus',$Menus);
		//默认后台样式
		$this->view->setTemplateAfter(APP_THEMES.'/main');
	}
}
