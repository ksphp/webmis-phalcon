<?php
class SysDBRestoreController extends ControllerBase{
	// Index
	public function indexAction(){
		// Menus
		$this->view->setVar('Menus',$this->inc->getMenus());
		$this->tag->prependTitle($this->inc->Ctitle);
		// Data
		$data = '';
		$this->view->setVar('Tables',$data);
		$this->view->setVar('Lang',$this->inc->getLang('system/sys_db'));
		$this->view->setVar('LoadJS', array('system/sys_db_backup.js'));
		// View
		$this->view->setTemplateAfter(APP_THEMES.'/main');
		// $this->view->pick("system/db/restore/index");
	}
}