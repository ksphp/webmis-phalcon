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
		$this->view->setTemplateAfter(APP_THEMES.'/main');
		$this->view->pick('welcome/sys_change_passwd');
	}
	/* Data */
	public function DataAction($type=''){
		if($this->request->isPost()){
			$pwd1 = $this->request->getPost('password');
			$pwd2 = $this->request->getPost('passwd');
			$data = Admins::findFirst('id='.@$_SESSION['Admin']['id']);
			if(md5($pwd1)==$data->password){
				$data->password = md5($pwd2);
				if($data->save()){
					header("Location: ".$this->url->get('index/Result/suc/SysChangePasswd'));
				}else{
					header("Location: ".$this->url->get('index/Result/err'));
				}
			}else{header("Location: ".$this->url->get('index/Result/err'));}
		}
	}
}