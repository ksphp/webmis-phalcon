<?php
class SysMenusController extends ControllerBase{
	// Index
	public function indexAction(){
		// Page
		$page = $this->inc->getPage(array('model'=>'Menus','where'=>array('order'=>'fid desc,sort desc')));
		$this->view->setVar('Page', $page);
		// Data
		$this->view->setVar('MenusLang',$this->inc->getLang('menus'));
		$this->view->setVar('Menus',$this->inc->getMenus());
		$this->tag->prependTitle($this->inc->Ctitle);
		$this->view->setVar('LoadJS', array('system/sys_menus.js'));
		// View
		$this->view->setTemplateAfter(APP_THEMES.'/main');
		$this->view->pick("system/menus/index");
	}
}