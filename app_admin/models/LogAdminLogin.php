<?php
use Phalcon\Mvc\Model;
class LogAdminLogin extends Model{
	public $id;
	function getSource(){
		return "wmis_log_admin_login";
	}
}