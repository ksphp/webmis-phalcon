<?php
class SysChangePasswdController extends ControllerBase{
	// Index
	public function indexAction(){
		// Data
		$this->view->setVar('Lang',$this->inc->getLang('welcome/sys_change_passwd'));
		$this->view->setVar('LoadJS', array('welcome/sys_change_passwd.js'));
		// Menus
		$this->view->setVar('Menus',$this->inc->getMenus());
		$this->tag->prependTitle($this->inc->Ctitle);
		// View
		if($this->session->get('IsMobile')){
			$this->view->setTemplateAfter(APP_THEMES.'/main_m');
			$this->view->pick("welcome/sys_change_passwd_m");
		}else{
			$this->view->setTemplateAfter(APP_THEMES.'/main');
			$this->view->pick('welcome/sys_change_passwd');
		}
	}
	/* Data */
	public function DataAction($type=''){
		if($this->request->isPost()){
			$pwd1 = $this->request->getPost('password');
			$pwd2 = $this->request->getPost('passwd');
			$data = Admins::findFirst(array('id=:id:','bind'=>array('id'=>$this->session->get('Admin')['id'])));
			if(md5($pwd1)==$data->password){
				$data->password = md5($pwd2);
				if($data->save()){
					$this->response->redirect('Result/suc/SysChangePasswd');
				}else{
					$this->response->redirect('Result/err');
				}
			}else{$this->response->redirect('Result/err');}
		}
	}
}