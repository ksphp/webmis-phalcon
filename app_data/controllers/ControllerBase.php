<?php
use Phalcon\Mvc\Controller;
class ControllerBase extends Controller{
	protected function initialize(){
		// URL
		$this->url->setStaticBaseUri($this->inc->BaseUrl());
		$this->url->setBaseUri($this->inc->BaseUrl(APP_NAME));
	}
}