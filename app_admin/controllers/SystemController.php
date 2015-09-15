<?php
class SystemController extends ControllerBase{
	// Index
	public function indexAction(){
		$this->inc->Forward('SysMenus');
	}
}
