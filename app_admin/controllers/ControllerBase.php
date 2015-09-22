<?php
use Phalcon\Mvc\Controller;
class ControllerBase extends Controller{
	public function initialize(){
		$this->tag->setTitle(' | '.APP_TITLE);
		$this->view->setVar('incLang',$this->inc->getLang('inc'));
		// Perm
		$this->inc->userPerm();
		// URL
		$this->url->setStaticBaseUri($this->inc->BaseUrl());
		$this->url->setBaseUri($this->inc->BaseUrl(APP_NAME));
		
	}
}

