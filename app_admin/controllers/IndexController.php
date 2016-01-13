<?php
use Phalcon\Mvc\Controller;
class IndexController extends Controller{
	public function initialize(){
		// URL
		$this->url->setStaticBaseUri($this->inc->BaseUrl());
		$this->url->setBaseUri($this->inc->BaseUrl(APP_NAME));
	}
	public function indexAction(){
		// ISmobile
		$mode = $this->request->getQuery('mode');
		if($mode=='pc'){
			$this->session->set('IsMobile', FALSE);
		}elseif($mode=='mobile'){
			$this->session->set('IsMobile', TRUE);
		}else{
			$this->session->set('IsMobile', $this->inc->IsMobile());
		}
		// Lang
		$this->view->setVar('incLang',$this->inc->getLang('inc'));
		$lang = $this->session->get('Lang');
		$Name = new Names();
		$this->view->setVar('LangName',$lang.' | '.$Name->getName('lang',$lang));
		$this->view->setVar('LangAll',$Name->getName('lang'));
		if($this->session->get('IsMobile')){
			$this->view->setTemplateAfter(APP_THEMES.'/login_m');
		}else{
			$this->view->setTemplateAfter(APP_THEMES.'/login');
		}
	}

	/* Login */
	public function loginAction(){
		if ($this->request->isPost()) {
			$uname = $this->request->getPost('uname');
			$password = $this->request->getPost('passwd');
			// User Data
			$admin = Admins::findFirst(array("(uname = :uname: OR email = :uname:) AND password = :password:",
				'bind' => array('uname' => $uname, 'password' => md5($password))));
			// Return JSON
			$lang = $this->inc->getLang('msg');
			if(!count($admin)){
				//$this->loginLog('Error',$uname);
				return $this->response->setJsonContent(array("status"=>"n","title"=>$lang->_("msg_title"),"msg"=>$lang->_("msg_isUser"),"text"=>$lang->_('msg_auto_close')));
			}
			if($admin->state=='1'){
				$this->_registerSession($admin);
				//$this->loginLog('Login',$uname);
				return $this->response->setJsonContent(array("status"=>"y"));
			}else{
				//$this->loginLog('Disable',$uname);
				return $this->response->setJsonContent(array("status"=>"n","title"=>$lang->_("msg_title"),"msg"=>$lang->_("msg_isDisable"),"text"=>$lang->_('msg_auto_close')));
			}
		}
	}
	// Save Session
	private function _registerSession(Admins $admin){
		// User Perm
		$arr = explode(' ', $admin->perm);
		foreach($arr as $val) {
			$num = explode(':', $val);
			$menu = Menus::findFirst(array("id = :id:",'bind' => array('id' => $num[0])));
			$data[$menu->url] = $num[1];
		}
		// Save
		$this->session->set('Admin', array(
			'id' => $admin->id,
			'uname' => $admin->uname,
			'name' => $admin->name,
			'department' => $admin->department,
			'position' => $admin->position,
			'perm' => $admin->perm,
			'ltime' => time()+1800,
			'logged_in' => TRUE,
			'perm_s' => $data
		));
    }
	
	/* LoginOut */
	public function loginOutAction(){
		$admin = $this->session->get('Admin');
		if(isset($admin['uname'])){
			$this->loginLog('Logout',$admin['uname']);
			$this->session->remove('Admin');
		}
		return $this->dispatcher->forward(array('controller' =>'index','action' =>'index'));
	}
	
	/* LoginLog */
	private function loginLog($type,$uname){
		$data = array('type'=>$type,'uname'=>$uname,'ip'=>$this->request->getClientAddress(),'time'=>date('Y-m-d H:i:s'),'agent'=>$this->request->getUserAgent());
		$DB = new LogAdminLogin();
		$DB->save($data);
	}
}
