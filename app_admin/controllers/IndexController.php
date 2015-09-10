<?php
use Phalcon\Mvc\Controller;
class IndexController extends Controller{
	public function indexAction(){
		// Login Template
		$this->view->setTemplateAfter(APP_THEMES.'/login');
		//$this->IsMobile();
	}
	public function IsMobile(){
		$useragent = $this->request->getUserAgent();
		print_r($useragent);
		echo '<br/>';
		$info = preg_match('|\(.*?\)|',$useragent,$matches)>0?$matches[0]:'';
		print_r($info);
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
