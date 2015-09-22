<?php
use Phalcon\Mvc\Controller;
class IndexController extends Controller{
	public function initialize(){
		// URL
		$this->url->setStaticBaseUri($this->inc->BaseUrl());
		$this->url->setBaseUri($this->inc->BaseUrl(APP_NAME));
	}
	public function indexAction(){
		// Lang
		$this->view->setVar('incLang',$this->inc->getLang('inc'));
		$lang = $this->session->get('Lang');
		$this->view->setVar('LangName',$lang.' | '.$this->names->getName('lang',$lang));
		$this->view->setVar('LangAll',$this->names->getName('lang'));
		// Login Template
		$this->view->setTemplateAfter(APP_THEMES.'/login');
		// echo $this->inc->IsMobile();
		
	}
	// Get Lang
	public function getLangAction($type=''){
		$lang = $this->inc->getLang($type);
		$name = $this->request->getQuery();
		foreach ($name as $key=>$val){
			$data[$key] = $lang->_($key);
		}
		echo json_encode($data);
	}

	// Login
	public function loginAction(){
		if ($this->request->isPost()) {
			$uname = $this->request->getPost('uname');
			$password = $this->request->getPost('passwd');
			// User Data
			$admin = Admins::findFirst(array("(uname = :uname: OR email = :uname:) AND password = :password:",
				'bind' => array('uname' => $uname, 'password' => md5($password))
			));
			// Return JSON
			if($admin){
				if($admin->state=='1'){
					$this->_registerSession($admin);
					echo '{"status":"y"}';
				}else{echo '{"status":"n","msg":"该用户已被禁用！"}';}
			}else{echo '{"status":"n","msg":"帐号或密码有误！"}';}
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
	// LoginOut
	public function loginOutAction(){
		$this->session->remove('Admin');
		return $this->dispatcher->forward(array('controller' =>'index','action' =>'index'));
	}
}
