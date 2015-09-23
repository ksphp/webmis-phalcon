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
		// Menus
		$this->view->setVar('Menus',$this->inc->getMenus());
		$this->tag->prependTitle($this->inc->Ctitle);
		// Data
		$this->view->setVar('MenusLang',$this->inc->getLang('menus'));
		$this->view->setVar('Lang',$this->inc->getLang('system/sys_menu'));
		$this->view->setVar('LoadJS', array('system/sys_menus.js'));
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
		$this->view->setVar('Action',Menuaction::find());
		$this->view->setVar('Lang',$this->inc->getLang('system/sys_menu'));
		$this->view->pick("system/menus/add");
	}
	/* Edit */
	public function editAction(){
		$id = $this->request->getPost('id');
		$data = Menus::findFirst(array('id='.$id));
		$this->view->setVar('Edit',$data);
		$this->view->setVar('MLang',$this->inc->getLang('menus'));
		$this->view->setVar('Action',Menuaction::find());
		$this->view->setVar('Lang',$this->inc->getLang('system/sys_menu'));
		$this->view->pick("system/menus/edit");
	}
	/* Del */
	public function delAction(){
		$this->view->pick("system/menus/del");
	}
	/* Data */
	public function DataAction($type='save'){
		if($this->request->isPost()){
			// Add and Edit
			if($type=='save'){
				$post = $this->request->getPost();
				$post['ctime'] = date('Y-m-d H:i:s');
				$data = new Menus();
				return $data->save($post)?$this->Result('suc'):$this->Result('err');
			// Delete
			}elseif($type=='delete'){
				$id = $this->request->getPost('id');
				$arr = json_decode($id);
				foreach ($arr as $val){
					$data = Menus::findFirst('id='.$val);
					if($data->delete()==FALSE){$this->Result('err');}
				}
				return $this->Result('suc');
			}
		}else{return FALSE;}
	}
	private function Result($type=''){
		$lang = $this->inc->getLang('msg');
		if($type=='suc'){
			return $this->response->setJsonContent(array("status"=>"y"));
		}elseif($type=='err'){
			return $this->response->setJsonContent(array("status"=>"n","title"=>$lang->_("msg_title"),"msg"=>$lang->_("msg_err"),"text"=>$lang->_('msg_auto_close')));
		}
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
		echo json_encode($data);
	}
}