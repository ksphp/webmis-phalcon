<?php
use Phalcon\Mvc\Controller;
class ControllerBase extends Controller{
	protected function initialize(){
		$this->tag->setTitle(' | '.APP_TITLE);
		// URL
		$this->url->setStaticBaseUri($this->inc->BaseUrl());
		$this->url->setBaseUri($this->inc->BaseUrl(APP_NAME));
	}
}

