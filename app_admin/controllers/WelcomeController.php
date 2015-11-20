<?php
class WelcomeController extends ControllerBase{
	// Index
	public function indexAction(){
		$this->inc->Forward('Desktop');
	}
}
