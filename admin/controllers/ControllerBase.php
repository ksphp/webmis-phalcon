<?php
use Phalcon\Mvc\Controller;
class ControllerBase extends Controller{
	public $FID1;
	public function initialize(){
		$this->tag->appendTitle(' | '.APP_TITLE);
		// Admin Info
		$admin = $this->session->get('Admin');
		$this->view->setVar('UserInfo', array(
			'uname'=>$admin['uname'],'name'=>$admin['name'],'department'=>$admin['department'],'position'=>$admin['position']
		));
		// Perm
		$this->_UserPerm($admin);
//		//获取菜单
//		$C = $this->dispatcher->getControllerName();
//		$FID = Menus::findFirst(array("url = :url:",'bind' => array('url' => $C)));
//		$menus = $FID->fid?$this->_getMenuNegative($FID->id):$this->_getMenuPositive($FID->id);
//		$this->view->setVar('Menus',$menus);
//		$this->view->setVar('FID',array($this->FID1));
	}
	
	// Forward
	protected function forward($url){
		$urlParts = explode('/', $url);
		return $this->dispatcher->forward(array('controller' => $urlParts[0],'action' => $urlParts[1]));
	}
	
	// User Perm
	private function _UserPerm($admin){
		// Cname
		$c = $this->dispatcher->getControllerName();
		// Is Timeout
		$ltime = $admin['ltime'];
		$ntime = time();
		if(!$admin['logged_in'] || $ltime<$ntime){
			return $this->forward('index/loginOut');
		}elseif(!isset($admin['perm_s'][$c])){
			echo 1;
			return $this->forward('errors/show404');
		}else{
			$_SESSION['Admin']['ltime'] = time()+1800;
		}
	}
	
	//获取菜单-正面
	protected function _getMenuPositive($id=''){
		$One = Menus::find(array("fid = :fid:",'bind' => array('fid' =>'0'),'order'=>'sort'));
		$this->FID1 = $id;
		$M1 = 0;
		$M2 = 0;
		foreach ($One as $val1) {
			$data[$M1] = array('id'=>$val1->id,'title'=>$val1->title,'url'=>$val1->url,'ico'=>$val1->ico);
			$Two = Menus::find(array("fid = :fid:",'bind' => array('fid' =>$val1->id),'order'=>'sort'));
			foreach ($Two as $val2){
				if($val1->id==$id){
					$data[$M1]['menus'][$M2] = array('id'=>$val2->id,'title'=>$val2->title,'url'=>$val2->url,'ico'=>$val2->ico);
					$Three = Menus::find(array("fid = :fid:",'bind' => array('fid' =>$val2->id),'order'=>'sort'));
					foreach ($Three as $val3){
						$data[$M1]['menus'][$M2]['menus'][] = array('id'=>$val3->id,'title'=>$val3->title,'url'=>$val3->url,'ico'=>$val3->ico);
						//echo $val3->title;
					}
				}else{$data[$M1]['menus'] = FALSE;}
				$M2++;
			}
			$M1++;
		}
		print_r($data);
		return $data;
	}
}

