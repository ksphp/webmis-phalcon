<?php
class ClasswebController extends ControllerBase{
	// Index
	public function indexAction(){
		// Page
		if(isset($_GET['search'])){
			$like = $this->inc->pageWhere();
			$where = '';
			foreach ($like['data'] as $key => $val){
				$where .= $key." LIKE '%".$val."%' AND ";
			}
			$where = rtrim($where,'AND ');
			$data = ClassWeb::find(array($where,'order'=>'fid desc,sort desc,id desc'));
			$getUrl = $like['getUrl'];
		}else{
			$getUrl = '';
			$data = ClassWeb::find(array('order'=>'fid desc,sort desc,id desc'));
		}
		$page = $this->inc->getPage(array('data'=>$data,'getUrl'=>$getUrl));
		$this->view->setVar('Page', $page);
		// Data
		$this->view->setVar('Lang',$this->inc->getLang('class/class_web'));
		$this->view->setVar('LoadJS', array('class/class_web.js'));
		// Menus
		$this->view->setVar('Menus',$this->inc->getMenus());
		$this->tag->prependTitle($this->inc->Ctitle);
		// View
		$this->view->setTemplateAfter(APP_THEMES.'/main');
		$this->view->pick("class/web/index");
	}
	/* Search */
	public function seaAction(){
		$this->view->setVar('Lang',$this->inc->getLang('class/class_web'));
		$this->view->pick("class/web/sea");
	}
	/* ADD */
	public function addAction(){
		$this->view->setVar('Lang',$this->inc->getLang('class/class_web'));
		$this->view->pick("class/web/add");
	}
	/* GetMenu */
	public function getMenuAction(){
		$fid = $this->request->getPost('fid');
		$data = '';
		$Menus = ClassWeb::find(array("fid='".$fid."'"));
		$MLang = $this->inc->getLang('menus');
		foreach ($Menus as $val){
			$data[] = array('id'=>$val->id,'title'=>$MLang->_($val->title));
		}
		return $this->response->setJsonContent($data);
	}
	/* Data */
	public function DataAction($type='save'){
		if($this->request->isPost()){
			// Add and Edit
			if($type=='save'){
				$post = $this->request->getPost();
				$post['ctime'] = date('Y-m-d H:i:s');
				$data = new Menus();
				return $data->save($post)?$this->Result('suc'):$this->Result('err');
			// Delete
			}elseif($type=='delete'){
				$id = $this->request->getPost('id');
				$arr = json_decode($id);
				foreach ($arr as $val){
					$data = Menus::findFirst('id='.$val);
					if($data->delete()==FALSE){$this->Result('err');}
				}
				return $this->Result('suc');
			}
		}else{return FALSE;}
	}
	private function Result($type=''){
		$lang = $this->inc->getLang('msg');
		if($type=='suc'){
			return $this->response->setJsonContent(array("status"=>"y"));
		}elseif($type=='err'){
			return $this->response->setJsonContent(array("status"=>"n","title"=>$lang->_("msg_title"),"msg"=>$lang->_("msg_err"),"text"=>$lang->_('msg_auto_close')));
		}
	}
}