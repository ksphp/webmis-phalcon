<?php
class ErrorsController extends ControllerBase{
	public function show404Action(){
		// View
		$this->tag->prependTitle('错误信息');
		$this->view->setTemplateAfter(APP_THEMES.'/main');
	}
	public function show500Action(){
		// View
		$this->tag->prependTitle('错误信息');
		$this->view->setTemplateAfter(APP_THEMES.'/main');
	}
}