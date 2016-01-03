<?php
use Phalcon\Mvc\Controller;
class IndexController extends Controller{
	public function index() {
		$class = ClassWeb::find('fid=0');
		foreach ($class as $val){
			$data[] = array('id'=>$val->id,'title'=>$val->title,'ctime'=>$val->ctime);
		}
		return $this->response->setJsonContent($data);
	}
	public function show($slug){
		echo $slug;
	}
}
