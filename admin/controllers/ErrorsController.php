<?php
use Phalcon\Mvc\Controller;
class ErrorsController extends Controller{
	public function show404Action(){
		$this->view->setTemplateAfter(APP_THEMES.'/error');
	}
}

