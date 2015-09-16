<?php

use Phalcon\Mvc\User\Component;
use Phalcon\Translate\Adapter\NativeArray;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;

class Inc extends Component{
	public $Ctitle;
	
	// Forward
	public function Forward($url){
		$urlParts = explode('/', $url);
		return $this->dispatcher->forward(array('controller' => $urlParts[0],'action' => @$urlParts[1]));
	}
	
	// AppURL
	public function BaseUrl($url=''){
		$base_url = $_SERVER['SERVER_PORT']=='443'?'https://':'http://';
		$base_url .= $_SERVER['HTTP_HOST'].APP_NAME.$url;
		return $base_url;
	}
	
	// IsMobile
	public function IsMobile(){
		$useragent = $this->request->getUserAgent();
		$user_agent = new Phalcon\Config\Adapter\Php(APP_PATH . 'config/user_agents.php');
		foreach ($user_agent->mobiles as $key=>$val){
			if(strpos($useragent, $key)){return TRUE;}else{return FALSE;}
		}
	}
	
	// GetLang
	public function getLang($name=''){
		if(!$name){return FALSE;}
		$lang = $this->request->get('lang');
		if($lang){
			$this->session->set('Lang', $lang);
		}else{
			$lang = $this->session->get('Lang');
			if(!isset($lang)){
				$lang = $this->request->getBestLanguage();
				$this->session->set('Lang', $lang);
			}
		}
		$file = __DIR__."/../language/".$lang."/".$name.".php";
		if(file_exists($file)){require $file;}else{require __DIR__."/../language/en-US/".$name.".php";}
		return new NativeArray(array('content'=>$lang));
	}
	
	// Page
	public function getPage($config=array()){
		if(isset($config['model'])){
			// Default
			$limit = isset($config['limit'])?$config['limit']:10;
			$where = isset($config['where'])?$config['where']:'';
			// Page
			$page = $this->request->getQuery('page', 'int');
			$data = $config['model']::find($where);
			$paginator   = new PaginatorModel(array('data'=>$data,'limit'=>$limit,'page'=>$page));
			return $paginator->getPaginate();
		}else{return FALSE;}
	}


	// Get Menus
	public function getMenus(){
		$Lang = $this->inc->getLang('menus');
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
		$action = $this->actionMenus($permArr['perm_s'][$Cname],$Cname,$Lang);
		$this->Ctitle = $Lang->_($FID['Ctitle']);
		return array('Date'=>$data,'FID'=>$FID,'Ctitle'=>$this->Ctitle,'action'=>$action);
	}
	private function actionMenus($perm='',$Cname='',$Lang='') {
		$Action = Menuaction::find(array('order'=>'id'));
		$data='';
		foreach ($Action as $val){
			if(intval($perm)&intval($val->perm)){
				$data[] = array('name'=>$Lang->_($val->name),'ico'=>$val->ico);
			}
		}
		return $data;
	}
	private function getFID($Cname){
		$FID1=''; $FID2=''; $FID3='';
		$G1 = Menus::findFirst(array("url = :url:",'bind' => array('url' => $Cname)));
		$Title = $G1->title;
		if($G1->fid==0){
			$FID1 = $G1->id;
		}else{
			$G2 = Menus::findFirst(array("id = :fid:",'bind' => array('fid' => $G1->fid)));
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
	public function userPerm(){
		$admin = $this->session->get('Admin');
		// Cname
		$c = $this->dispatcher->getControllerName();
		// Is Timeout
		$ltime = $admin['ltime'];
		$ntime = time();
		if(!$admin['logged_in'] || $ltime<$ntime){
			return $this->inc->Forward('index/loginOut');
		}elseif(!isset($admin['perm_s'][$c])){
			return $this->inc->Forward('errors/show404');
		}else{
			$_SESSION['Admin']['ltime'] = time()+1800;
		}
	}
}

