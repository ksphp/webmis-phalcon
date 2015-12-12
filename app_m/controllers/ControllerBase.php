<?php
use Phalcon\Mvc\Controller;
class ControllerBase extends Controller{
	protected function initialize(){
		// ISmobile
		$mode = $this->request->getQuery('mode');
		if($mode=='pc'){
			$this->session->set('IsMobile', FALSE);
		}elseif($mode=='mobile'){
			$this->session->set('IsMobile', TRUE);
		}else{
			$this->session->set('IsMobile', $this->inc->IsMobile());
		}
		if(!$this->session->get('IsMobile')){$this->response->redirect('../');}
		// Title
		$this->tag->setTitle(' | '.APP_TITLE);
		// URL
		$this->url->setStaticBaseUri($this->inc->BaseUrl());
		$this->url->setBaseUri($this->inc->BaseUrl(APP_NAME));
	}
}

