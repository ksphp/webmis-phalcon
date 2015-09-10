<?php
class HelpController extends ControllerBase{
	// Index
	public function indexAction(){
		$this->forward('HelpSystem');
	}
}
