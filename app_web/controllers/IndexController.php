<?php
class IndexController extends ControllerBase{
	public function indexAction() {
		if(!$this->inc->IsMobile()){
			$this->tag->prependTitle('电脑版');
			$this->view->setVar('LoadCSS',array('index.css'));
			$this->view->setVar('LoadJS',array('index.js'));
			$this->view->setTemplateAfter(APP_THEMES.'/main');
		}else{
			header('location: m/');
		}
	}
}
