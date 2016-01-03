<?php

use Phalcon\Mvc\User\Component;
use Phalcon\Translate\Adapter\NativeArray;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;

class Inc extends Component{
	public $Ctitle;
	
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
		if(isset($location->city)){
			$Area = DataArea::findFirst("title='".$location->city."'");
			if(@$Area->id){
				$this->session->set('City',array('id'=>$Area->id,'name'=>$Area->title));
			}else{
				$this->session->set('City',array('id'=>'1','name'=>'玉溪'));
			}
		}else{
			$this->session->set('City',array('id'=>'1','name'=>'玉溪'));
		}
	}
	
	/* Key Highlight */
	public function keyHH($str='', $phrase, $tag_open = '<span style="color:#FF6600">', $tag_close = '</span>'){
		if ($str == ''){return FALSE;}
		if ($phrase != ''){return preg_replace('/('.preg_quote($phrase, '/').')/i', $tag_open."\\1".$tag_close, $str);}
		return $str;
	}
	
}

