<?php
class SysAdminController extends ControllerBase{
	// Index
	public function indexAction(){
		// Page
		if(isset($_GET['search'])){
			$like = $this->inc->pageWhere();
			$where = '';
			foreach ($like['data'] as $key => $val){
				$where .= $key." LIKE '%".$val."%' AND ";
			}
			$where = rtrim($where,'AND ');
			$data = Admins::find(array($where,'order'=>'id'));
			$getUrl = $like['getUrl'];
		}else{
			$getUrl = '';
			$data = Admins::find(array('order'=>'id'));
		}
		$page = $this->inc->getPage(array('data'=>$data,'getUrl'=>$getUrl));
		$this->view->setVar('Page', $page);
		// Data
		$this->view->setVar('Lang',$this->inc->getLang('system/sys_admin'));
		$this->view->setVar('LoadJS', array('system/sys_admin.js'));
		// Menus
		$this->view->setVar('Menus',$this->inc->getMenus());
		$this->tag->prependTitle($this->inc->Ctitle);
		// View
		$this->view->setTemplateAfter(APP_THEMES.'/main');
		$this->view->pick("system/admin/index");
	}
}