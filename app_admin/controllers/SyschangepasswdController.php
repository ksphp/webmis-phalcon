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
				return $data->save()?$this->Result('suc'):$this->Result('err');
			}else{return $this->Result('err');}
		}
	}
	private function Result($type=''){
		$lang = $this->inc->getLang('msg');
		if($type=='suc'){
			return $this->response->setJsonContent(array("status"=>"y","url"=>"SysChangePasswd","title"=>$lang->_("msg_title"),"msg"=>$lang->_("msg_suc"),"text"=>$lang->_('msg_auto_close')));
		}elseif($type=='err'){
			return $this->response->setJsonContent(array("status"=>"n","title"=>$lang->_("msg_title"),"msg"=>$lang->_("msg_err"),"text"=>$lang->_('msg_auto_close')));
		}
	}
}