<?php

use Phalcon\Mvc\User\Component;
use Phalcon\Translate\Adapter\NativeArray;

class Inc extends Component{
	/* Forward */
	public function Forward($url){
		$urlParts = explode('/', $url);
		$C = $urlParts[0];
		$A = @$urlParts[1];
		unset($urlParts[0]);
		unset($urlParts[1]);
		return $this->dispatcher->forward(array('controller' =>$C,'action' =>$A,'params' => $urlParts));
	}
	
	/* AppURL */
	public function BaseUrl($url=''){
		$base_url = $_SERVER['SERVER_PORT']=='443'?'https://':'http://';
		$base_url .= $_SERVER['HTTP_HOST'].$url;
		return $base_url;
	}

	/* IsMobile */
	public function IsMobile(){
		$useragent = $this->request->getUserAgent();
		$useragent = preg_match('|\(.*?\)|',$useragent,$matches)>0?$matches[0]:'';
		$agent = new Phalcon\Config\Adapter\Php(APP_PATH . 'config/user_agents.php');
		foreach ($agent->mobiles as $key=>$val){
			if(strpos($useragent, $key)){return TRUE;}
		}
		return FALSE;
	}
	
	/* Get Lang */
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
	
	/* Key Highlight */
	public function keyHH($str='', $phrase, $tag_open = '<span style="color:#FF6600">', $tag_close = '</span>'){
		if ($str == ''){return FALSE;}
		if ($phrase != ''){return preg_replace('/('.preg_quote($phrase, '/').')/i', $tag_open."\\1".$tag_close, $str);}
		return $str;
	}
}