<?php

use Phalcon\Mvc\User\Component;
use Phalcon\Translate\Adapter\NativeArray;

class Inc extends Component{
	// Forward
	public function Forward($url){
		$urlParts = explode('/', $url);
		return $this->dispatcher->forward(array('controller' => $urlParts[0],'action' => @$urlParts[1]));
	}
	
	// AppURL
	public function BaseUrl($url=''){
		$base_url = $_SERVER['SERVER_PORT']=='443'?'https://':'http://';
		$base_url .= $_SERVER['HTTP_HOST'].APP_NAME.$url;
		echo $base_url;
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
}