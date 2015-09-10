<?php
class LogController extends ControllerBase{
	// Index
	public function indexAction(){
		$this->forward('LogAdminLogin');
	}
}
