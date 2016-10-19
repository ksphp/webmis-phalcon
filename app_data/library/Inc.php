<?php

use Phalcon\Mvc\User\Component;
use Phalcon\Translate\Adapter\NativeArray;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;

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
			if(strpos($useragent, $key)){return $val;}
		}
		return FALSE;
	}
	
	/* Get City */
	public function getCity(){
		$IP = $this->request->getClientAddress();
		// 发送请求
		$url = 'http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json&ip='.$IP;
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_ENCODING, 'utf8');
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$location = curl_exec($ch);
		$location = json_decode($location);
		curl_close($ch);
		$city = DataArea::findFirst("title='".@$location->city."'");
		if(!isset($location->city) || !isset($city->id)){
			$city = DataArea::findFirst("id=1");
		}
		$area = json_decode($city->area);
		$this->session->set('City',array('id'=>$city->id,'city'=>$city->title,'areaID'=>$area[0]->id,'areaName'=>$area[0]->name,'area'=>$area));
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
	
	/* Key */
	public function getKey($str){
		return md5($str.'e33e907621123d2bf01b7f580f316ade');
	}
	public function getKeyArr($parameter=''){
		ksort($parameter);
		reset($parameter);
		$parameter['sign'] = 'e33e907621123d2bf01b7f580f316ade';
		return md5(http_build_query($parameter));
	}
	
	/* Key Highlight */
	public function keyHH($str='', $phrase, $tag_open = '<span style="color:#FF6600">', $tag_close = '</span>'){
		if ($str == ''){return FALSE;}
		if ($phrase != ''){return preg_replace('/('.preg_quote($phrase, '/').')/i', $tag_open."\\1".$tag_close, $str);}
		return $str;
	}
	
	/* SubStr */
	public function sysSubStr($String,$Length,$Append = false){
		if(strlen($String) <= $Length ){
			return $String;
		}else{
			$I = 0;
			while ($I < $Length){
				$StringTMP = substr($String,$I,1);
				if( ord($StringTMP) >=224 ){
					$StringTMP = substr($String,$I,3);
					$I = $I + 3;
				}elseif( ord($StringTMP) >=192 ){
					$StringTMP = substr($String,$I,2);
					$I = $I + 2;
				}else{
					$I = $I + 1;
				}
				$StringLast[] = $StringTMP;
			}
			$StringLast = implode("",$StringLast);
			
			if($Append){$StringLast .= "...";}
			
			return $StringLast;
		}
	}

	/* Jsonp */
	public function getJSONP($data){
		$callback = $this->request->get('callback');
		return $callback.'('.json_encode($data).')';
	}
}