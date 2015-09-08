<?php
use Phalcon\Mvc\Model;
class Admins extends Model{
	public $id;
	public $uname;
	public $name;
	public $department;
	public $position;
	public $email;
	public $perm;
	public $state;
	public function getSource(){
		return "wmis_sys_admin";
	}
}
