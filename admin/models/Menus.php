<?php
use Phalcon\Mvc\Model;
class Menus extends Model{
	public $id;
	public $fid;
	public $url;
	function getSource(){
		return "wmis_sys_menus";
	}
}
