<?php
use Phalcon\Mvc\Controller;
class ErrorsController extends Controller{
	public function show404Action(){
		$this->view->setTemplateAfter(APP_THEMES.'/error');
	}
	public function show500Action(){
		$this->view->setTemplateAfter(APP_THEMES.'/error');
	}
}