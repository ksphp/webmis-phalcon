<?php
class SysMenusController extends ControllerBase{
	/* Index */
	public function indexAction(){
		// Page
		if(isset($_GET['search'])){
			$like = $this->inc->pageWhere();
			$where = '';
			foreach ($like['data'] as $key => $val){
				$where .= $key." LIKE '%".$val."%' AND ";
			}
			$where = rtrim($where,'AND ');
			$data = Menus::find(array($where,'order'=>'fid desc,sort desc'));
			$getUrl = $like['getUrl'];
		}else{
			$getUrl = '';
			$data = Menus::find(array('order'=>'fid desc,sort desc'));
		}
		$page = $this->inc->getPage(array('data'=>$data,'getUrl'=>$getUrl));
		$this->view->setVar('Page', $page);
		// Data
		$this->view->setVar('MenusLang',$this->inc->getLang('menus'));
		$this->view->setVar('Lang',$this->inc->getLang('system/sys_menu'));
		$this->view->setVar('LoadJS', array('system/sys_menus.js'));
		// Menus
		$this->view->setVar('Menus',$this->inc->getMenus());
		$this->tag->prependTitle($this->inc->Ctitle);
		// View
		$this->view->setTemplateAfter(APP_THEMES.'/main');
		$this->view->pick("system/menus/index");
	}
	
	/* Search */
	public function seaAction(){
		$this->view->setVar('Lang',$this->inc->getLang('system/sys_menu'));
		$this->view->pick("system/menus/sea");
	}
	/* ADD */
	public function addAction(){
		$this->view->setVar('MLang',$this->inc->getLang('menus'));
		$this->view->setVar('Action',MenuAction::find());
		$this->view->setVar('Lang',$this->inc->getLang('system/sys_menu'));
		$this->view->pick("system/menus/add");
	}
	/* Edit */
	public function editAction(){
		$id = $this->request->getPost('id');
		$this->view->setVar('Edit',Menus::findFirst(array('id='.$id)));
		$this->view->setVar('MLang',$this->inc->getLang('menus'));
		$this->view->setVar('Action',MenuAction::find());
		$this->view->setVar('Lang',$this->inc->getLang('system/sys_menu'));
		$this->view->pick("system/menus/edit");
	}
	/* Del */
	public function delAction(){
		$this->view->pick("system/menus/del");
	}
	/* Data */
	public function DataAction($type=''){
		if($this->request->isPost()){
			// Add
			if($type=='add'){
				$post = $this->request->getPost();
				$post['ctime'] = date('Y-m-d H:i:s');
				$data = new Menus();
				if($data->save($post)){
					$this->response->redirect('Result/suc/SysMenus');
				}else{
					$this->response->redirect('Result/err');
				}
			// Edit
			}elseif($type=='edit'){
				$id = $this->request->getPost('id');
				$data = Menus::findFirst('id='.$id);
				$data->fid = $this->request->getPost('fid');
				$data->title = $this->request->getPost('title');
				$data->url = $this->request->getPost('url');
				$data->ico = $this->request->getPost('ico');
				$data->perm = $this->request->getPost('perm');
				$data->remark = $this->request->getPost('remark');
				$data->sort = $this->request->getPost('sort');
				if($data->save()){
					$this->response->redirect('Result/suc/SysMenus');
				}else{
					$this->response->redirect('Result/err');
				}
			// Delete
			}elseif($type=='delete'){
				$id = $this->request->getPost('id');
				$arr = json_decode($id);
				foreach ($arr as $val){
					$data = Menus::findFirst('id='.$val);
					if($data->delete()==FALSE){$this->response->redirect('Result/err');}
				}
				$this->response->redirect('Result/suc/SysMenus');
			}
		}else{return FALSE;}
	}
	/* GetMenu */
	public function getMenuAction(){
		$fid = $this->request->getPost('fid');
		$data = '';
		$Menus = Menus::find(array("fid='".$fid."'"));
		$MLang = $this->inc->getLang('menus');
		foreach ($Menus as $val){
			$data[] = array('id'=>$val->id,'title'=>$MLang->_($val->title));
		}
		return $this->response->setJsonContent($data);
	}
}