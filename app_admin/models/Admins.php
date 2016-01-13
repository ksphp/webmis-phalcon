<?php
use Phalcon\Mvc\Model;
class Admins extends Model{
	public $id;
	public function getSource(){
		return "wmis_sys_admin";
	}
}
