<?php
use Phalcon\Mvc\Model;
class ClassWeb extends Model{
	public $id;
	function getSource(){
		return "wmis_class_web";
	}
}