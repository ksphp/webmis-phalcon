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
	/* Search */
	public function seaAction(){
		$this->view->setVar('Lang',$this->inc->getLang('system/sys_admin'));
		$this->view->pick("system/admin/sea");
	}
	/* ADD */
	public function addAction(){
		$this->view->setVar('Lang',$this->inc->getLang('system/sys_admin'));
		$this->view->pick("system/admin/add");
	}
	/* Edit */
	public function editAction(){
		$id = $this->request->getPost('id');
		$data = Admins::findFirst(array('id='.$id));
		$this->view->setVar('Edit',$data);
		$this->view->setVar('Lang',$this->inc->getLang('system/sys_admin'));
		$this->view->pick("system/admin/edit");
	}
	/* Del */
	public function delAction(){
		$this->view->pick("system/admin/del");
	}
	/* Data */
	public function DataAction($type=''){
		if($this->request->isPost()){
			if($type=='add'){
				$post = $this->request->getPost();
				if(!empty($post['passwd'])){
					$post['password'] = md5($post['passwd']);
				}
				unset($post['passwd']);
				$post['rtime'] = date('Y-m-d H:i:s');
				$data = new Admins();
				return $data->save($post)?$this->Result('suc'):$this->Result('err');
			// Edit
			}elseif($type=='edit'){
				$post = $this->request->getPost();
				if(!empty($post['passwd'])){
					$post['password'] = md5($post['passwd']);
				}
				unset($post['passwd']);
				$data = new Admins();
				return $data->save($post)?$this->Result('suc'):$this->Result('err');
			// Delete
			}elseif($type=='delete'){
				$id = $this->request->getPost('id');
				$arr = json_decode($id);
				foreach ($arr as $val){
					$data = Admins::findFirst('id='.$val);
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
}