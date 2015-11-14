<?php
class SysMenusActionController extends ControllerBase{
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
			$data = MenuAction::find(array($where,'order'=>'id'));
			$getUrl = $like['getUrl'];
		}else{
			$getUrl = '';
			$data = MenuAction::find(array('order'=>'id'));
		}
		$page = $this->inc->getPage(array('data'=>$data,'getUrl'=>$getUrl));
		$this->view->setVar('Page', $page);
		// Data
		$this->view->setVar('MenusLang',$this->inc->getLang('menus'));
		$this->view->setVar('Lang',$this->inc->getLang('system/sys_menu_action'));
		$this->view->setVar('LoadJS', array('system/sys_menus_action.js'));
		// Menus
		$this->view->setVar('Menus',$this->inc->getMenus());
		$this->tag->prependTitle($this->inc->Ctitle);
		// View
		$this->view->setTemplateAfter(APP_THEMES.'/main');
		$this->view->pick("system/menus/action/index");
	}
	/* Search */
	public function seaAction(){
		$this->view->setVar('Lang',$this->inc->getLang('system/sys_menu_action'));
		$this->view->pick("system/menus/action/sea");
	}
	/* ADD */
	public function addAction(){
		$this->view->setVar('Lang',$this->inc->getLang('system/sys_menu_action'));
		$this->view->pick("system/menus/action/add");
	}
	/* Edit */
	public function editAction(){
		$id = $this->request->getPost('id');
		$data = MenuAction::findFirst(array('id='.$id));
		$this->view->setVar('Edit',$data);
		$this->view->setVar('Lang',$this->inc->getLang('system/sys_menu_action'));
		$this->view->pick("system/menus/action/edit");
	}
	/* Del */
	public function delAction(){
		$this->view->pick("system/menus/action/del");
	}
	/* Data */
	public function DataAction($type='save'){
		if($this->request->isPost()){
			// Add
			if($type=='add'){
				$post = $this->request->getPost();
				$data = new MenuAction();
				if($data->save($post)){
					header("Location: ".$this->url->get('index/Result/suc/SysMenusAction'));
				}else{
					header("Location: ".$this->url->get('index/Result/err'));
				}
			// Edit
			}if($type=='edit'){
				$id = $this->request->getPost('id');
				$data = MenuAction::findFirst('id='.$id);
				$data->name = $this->request->getPost('name');
				$data->perm = $this->request->getPost('perm');
				$data->ico = $this->request->getPost('ico');
				if($data->save()){
					header("Location: ".$this->url->get('index/Result/suc/SysMenusAction'));
				}else{
					header("Location: ".$this->url->get('index/Result/err'));
				}
			// Delete
			}elseif($type=='delete'){
				$id = $this->request->getPost('id');
				$arr = json_decode($id);
				foreach ($arr as $val){
					$data = MenuAction::findFirst('id='.$val);
					if($data->delete()==FALSE){header("Location: ".$this->url->get('index/Result/err'));}
				}
				header("Location: ".$this->url->get('index/Result/suc/SysMenusAction'));
			}
		}else{return FALSE;}
	}
}