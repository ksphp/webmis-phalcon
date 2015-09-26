<?php

use Phalcon\Mvc\User\Component;

class Names extends Component{
	public function getName($name='',$val=''){
		$data['lang'] = array('en-US'=>'English','zh-CN'=>'简体中文');
		// Return Data
		if($name && $val){
			return $data[$name][$val];
		}elseif($name){
			return $data[$name];
		}else{
			return FALSE;
		}
		
	}
}