<?php
use Phalcon\Mvc\Controller;
class ErrorsController extends Controller{
	public function show404Action(){
		$this->view->setTemplateAfter(APP_THEMES.'/error');
	}
}
//class ErrorsController extends ControllerBase{
//	// Index
//	public function indexAction(){
//		echo 1;
//	}
//}

