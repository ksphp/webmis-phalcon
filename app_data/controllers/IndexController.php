<?php
class IndexController extends ControllerBase{
	public function indexAction() {
		$data = array('title'=>'WebMIS','url'=>'https://ksphp.github.io/');
		echo $this->inc->getJSONP($data);
	}
}