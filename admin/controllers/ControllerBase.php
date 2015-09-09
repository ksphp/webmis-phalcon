<?php
use Phalcon\Mvc\Controller;
use Phalcon\Translate\Adapter\NativeArray;
class ControllerBase extends Controller{
	public function initialize(){
		$this->tag->appendTitle(' | '.APP_TITLE);
		// Admin Info
		$admin = $this->session->get('Admin');
		$this->view->setVar('UserInfo', array(
			'uname'=>$admin['uname'],'name'=>$admin['name'],'department'=>$admin['department'],'position'=>$admin['position']
		));
		// Perm
		$this->_UserPerm($admin);
	}
	
	/* Language */
	protected function lang($name=''){
		$lang = $this->request->getBestLanguage();
		$file = __DIR__."/../language/".$lang."/".$name.".php";
		if(file_exists($file)){
			require $file;
		}else{
			require __DIR__."/../language/en-US/".$name.".php";
		}
		return new NativeArray(array('content'=>$lang));
	}
	
	/* Forward */
	protected function forward($url){
		$urlParts = explode('/', $url);
		return $this->dispatcher->forward(array('controller' => $urlParts[0],'action' => $urlParts[1]));
	}
	
	// Get Menus
	protected function getMenus(){
		$Lang = $this->lang('menus');
		$permArr = $this->session->get('Admin');
		$Cname = $this->dispatcher->getControllerName();
		$FID = $this->getFID($Cname);
		$M1 = 0; $M2 = 0;
		$One = Menus::find(array("fid = :fid:",'bind' => array('fid' =>'0'),'order'=>'sort'));
		foreach ($One as $val1) {
			if(isset($permArr['perm_s'][$val1->url])){
				$data[$M1] = array('id'=>$val1->id,'title'=>$Lang->_($val1->title),'url'=>$val1->url,'ico'=>$val1->ico);
				$Two = Menus::find(array("fid = :fid:",'bind' => array('fid' =>$val1->id),'order'=>'sort'));
				foreach ($Two as $val2){
					if(isset($permArr['perm_s'][$val2->url])){
						if($val1->id==$FID['FID1']){
							$data[$M1]['menus'][$M2] = array('id'=>$val2->id,'title'=>$Lang->_($val2->title),'url'=>$val2->url,'ico'=>$val2->ico);
							$three = Menus::find(array("fid = :fid:",'bind' => array('fid' =>$val2->id),'order'=>'sort'));
							foreach ($three as $val3){
								if(isset($permArr['perm_s'][$val3->url])){
									$data[$M1]['menus'][$M2]['menus'][] = array('id'=>$val3->id,'title'=>$Lang->_($val3->title),'url'=>$val3->url,'ico'=>$val3->ico);
								}
							}
						}else{$data[$M1]['menus'] = FALSE;}
						$M2++;
					}
				}
				$M1++;
			}
		}
		// return array('Date'=>$data,'FID'=>$FID,'Ctitle'=>$title,'userHtml'=>$userHtml,'actionHtml'=>$actionHtml);
		$title = $Lang->_($FID['Ctitle']);
		return array('Date'=>$data,'FID'=>$FID,'Ctitle'=>$title);
	}
	private function getFID($Cname){
		$FID1=''; $FID2=''; $FID3='';
		$G1 = Menus::findFirst(array("url = :url:",'bind' => array('url' => $Cname)));
		$Title = $G1->title;
		if($G1->fid==0){
			$FID1 = $G1->id;
		}else{
			$G2 = $APP->sys_menus_m->getMenu();Menus::findFirst(array("fid = :fid:",'bind' => array('fid' => $G1->fid)));
			if($G2->fid==0){
				$FID1 = $G1->fid;
				$FID2 = $G1->id;
			}else{
				$FID1 = $G2->fid;
				$FID2 = $G1->fid;
				$FID3 = $G1->id;
			}
		}
		return array('Ctitle'=>$Title,'FID1'=>$FID1,'FID2'=>$FID2,'FID3'=>$FID3);
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
			return $this->forward('errors/show404');
		}else{
			$_SESSION['Admin']['ltime'] = time()+1800;
		}
	}
}

