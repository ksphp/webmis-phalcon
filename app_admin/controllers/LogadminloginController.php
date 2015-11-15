<?php
class LogadminloginController extends ControllerBase{
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
			$data = LogAdminLogin::find(array($where,'order'=>'id desc'));
			$getUrl = $like['getUrl'];
		}else{
			$getUrl = '';
			$data = LogAdminLogin::find(array('order'=>'id desc'));
		}
		$page = $this->inc->getPage(array('data'=>$data,'getUrl'=>$getUrl));
		$this->view->setVar('Page', $page);
		// Data
		$this->view->setVar('Lang',$this->inc->getLang('log/log_login'));
		$this->view->setVar('LoadJS', array('log/log_admin_login.js'));
		// Menus
		$this->view->setVar('Menus',$this->inc->getMenus());
		$this->tag->prependTitle($this->inc->Ctitle);
		// View
		if($this->session->get('IsMobile')){
			$this->view->setTemplateAfter(APP_THEMES.'/main_m');
			$this->view->pick("log/admin/login/index_m");
		}else{
			$this->view->setTemplateAfter(APP_THEMES.'/main');
			$this->view->pick("log/admin/login/index");
		}
	}
	/* Search */
	public function seaAction(){
		$this->view->setVar('Lang',$this->inc->getLang('log/log_login'));
		$this->view->pick("log/admin/login/sea");
	}
	/* Del */
	public function delAction(){
		$this->view->pick("log/admin/login/del");
	}
	/* Data */
	public function DataAction($type=''){
		if($this->request->isPost()){
			// Delete
			if($type=='delete'){
				$id = $this->request->getPost('id');
				$arr = json_decode($id);
				foreach ($arr as $val){
					$data = LogAdminLogin::findFirst('id='.$val);
					if($data->delete()==FALSE){$this->response->redirect('Result/err');}
				}
				$this->response->redirect('Result/suc/LogAdminLogin');
			}
		}else{return FALSE;}
	}
}