<?php
class SysConfigController extends ControllerBase{
	// Index
	public function indexAction(){
		$this->view->setVar('Lang',$this->inc->getLang('system/sys_config'));
		$this->view->setVar('LoadJS', array('system/sys_config.js'));
		// Menus
		$this->view->setVar('Menus',$this->inc->getMenus());
		$this->tag->prependTitle($this->inc->Ctitle);
		// View
		$this->view->setTemplateAfter(APP_THEMES.'/main');
		$this->view->pick("system/config/index");
	}
}