<?php
use Phalcon\Paginator\Adapter\Model as PaginatorModel;
class SysMenusController extends ControllerBase{
	// Index
	public function indexAction(){
		// Page
		$currentPage = (int) $_GET["page"];
		$M = Menus;
		$data = $M::find();
		$paginator   = new PaginatorModel(array('data'=>$data,'limit'=>10,'page'=>$currentPage));
		$page = $paginator->getPaginate();
		$this->view->setVar('Page', $page);
		// Data
		$this->view->setVar('MenusLang',$this->inc->getLang('menus'));
		$this->view->setVar('Menus',$this->inc->getMenus());
		$this->tag->prependTitle($this->inc->Ctitle);
		$this->view->setVar('LoadJS', array('system/sys_menus.js'));
		$this->view->setTemplateAfter(APP_THEMES.'/main');
		$this->view->pick("system/menus/index");
	}
}