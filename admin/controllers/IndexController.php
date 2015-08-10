<?php
use Phalcon\Mvc\Controller;
class IndexController extends Controller{
	public function indexAction(){
		// Login Template
		$this->view->setTemplateAfter(APP_THEMES.'/login');
	}
	//用户登陆
	public function loginAction(){
		if ($this->request->isPost()) {
			$uname = $this->request->getPost('uname');
			$password = $this->request->getPost('passwd');
			//查询数据
			$admin = Admins::findFirst(array(
				"(uname = :uname: OR email = :uname:) AND password = :password:",
				'bind' => array('uname' => $uname, 'password' => md5($password))
			));
			//用户状态
			if($admin){
				if($admin->state=='1'){
					$this->_registerSession($admin);
					echo '{"status":"y"}';
				}else{echo '{"status":"n","msg":"该用户已被禁用！"}';}
			}else{echo '{"status":"n","msg":"帐号或密码有误！"}';}
		}
	}
	//注册Session
	private function _registerSession(Admins $admin){
		//用户权限菜单
		$arr = explode(' ', $admin->perm);
		foreach($arr as $val) {
			$num = explode(':', $val);
			$menu = Menus::findFirst(array("id = :id:",'bind' => array('id' => $num[0])));
			$data[$menu->url] = $num[1];
		}
		//保存
		$this->session->set('Admin', array(
		'id' => $admin->id,
		'uname' => $admin->uname,
		'name' => $admin->name,
		'perm' => $admin->perm,
		'ltime' => time()+1800,
		'logged_in' => TRUE,
		'perm_s' => $data
        ));
    }
	//退出登陆
	public function loginOutAction(){
		$this->session->remove('Admin');
		$this->session->destroy();
		return $this->dispatcher->forward(array('controller' =>'index','action' =>'index'));
	}
}
