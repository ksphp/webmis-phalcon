<?php
use Phalcon\Mvc\Model;
class MenuAction extends Model{
	public $id;
	function getSource(){
		return "wmis_sys_menus_action";
	}
}