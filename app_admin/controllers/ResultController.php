<?php
use Phalcon\Mvc\Controller;
class ResultController extends Controller{
	/* Success */
	public function sucAction($url=''){
		$lang = $this->inc->getLang('msg');
		return $this->response->setJsonContent(array("status"=>"y","url"=>$url,"title"=>$lang->_("msg_title"),"msg"=>$lang->_("msg_suc"),"text"=>$lang->_('msg_auto_close')));
	}
	/* Error */
	public function errAction($url=''){
		$lang = $this->inc->getLang('msg');
		return $this->response->setJsonContent(array("status"=>"n","url"=>$url,"title"=>$lang->_("msg_title"),"msg"=>$lang->_("msg_err"),"text"=>$lang->_('msg_auto_close')));
	}
	/* Get Lang */
	public function getLangAction($type=''){
		$lang = $this->inc->getLang($type);
		$name = $this->request->getQuery();
		foreach ($name as $key=>$val){
			$data[$key] = $lang->_($key);
		}
		return $this->response->setJsonContent($data);
	}
}