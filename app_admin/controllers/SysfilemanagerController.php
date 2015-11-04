<?php
class SysFilemanagerController extends ControllerBase{
	public function initialize(){
		parent::initialize();
		$this->FileRoot = $_SERVER['DOCUMENT_ROOT'].'/../';
	}
	// Index
	public function indexAction(){
		$path = trim($this->request->getQuery('path'));
		$File = new File();
		$File->file_root = $this->FileRoot;
		$this->view->setVar('filelist',$File->lists($path));
		// Data
		$this->view->setVar('Lang',$this->inc->getLang('system/sys_file'));
		$this->view->setVar('LoadJS', array('system/sys_filemanager.js'));
		// Menus
		$this->view->setVar('Menus',$this->inc->getMenus());
		$this->tag->prependTitle($this->inc->Ctitle);
		// View
		$this->view->setTemplateAfter(APP_THEMES.'/main');
		$this->view->pick("system/filemanager/index");
	}
}