<?php
use Phalcon\Mvc\Model;
class WebNews extends Model{
	public $id;
	function getSource(){
		return "wmis_web_news";
	}
}