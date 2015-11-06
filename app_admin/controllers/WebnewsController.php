<?php
class WebNewsController extends ControllerBase{
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
			$data = WebNews::find(array($where,'order'=>'id desc'));
			$getUrl = $like['getUrl'];
		}else{
			$getUrl = '';
			$data = WebNews::find(array('order'=>'id desc'));
		}
		$page = $this->inc->getPage(array('data'=>$data,'getUrl'=>$getUrl));
		$this->view->setVar('Page', $page);
		// Class
		$Cdata = ClassWeb::find();
		$Class = '';
		foreach ($Cdata as $val){
			$Class[$val->id] = $val->title;
		}
		$this->view->setVar('Class',$Class);
		// Data
		$this->view->setVar('Lang',$this->inc->getLang('web/web_news'));
		$this->view->setVar('LoadJS', array('web/web_news.js'));
		// Menus
		$this->view->setVar('Menus',$this->inc->getMenus());
		$this->tag->prependTitle($this->inc->Ctitle);
		// View
		$this->view->setTemplateAfter(APP_THEMES.'/main');
		$this->view->pick("web/news/index");
	}
	/* Search */
	public function seaAction(){
		$this->view->setVar('Lang',$this->inc->getLang('web/web_news'));
		$this->view->pick("web/news/sea");
	}
	/* ADD */
	public function addAction(){
		$this->view->setVar('Lang',$this->inc->getLang('web/web_news'));
		$this->view->pick("web/news/add");
	}
	/* Edit */
	public function editAction(){
		$id = $this->request->getPost('id');
		$this->view->setVar('Edit', WebNews::findFirst(array('id='.$id)));
		$this->view->setVar('Lang',$this->inc->getLang('web/web_news'));
		$this->view->pick("web/news/edit");
	}
	/* Del */
	public function delAction(){
		$this->view->pick("web/news/del");
	}
	/* Audit */
	public function auditAction(){
		$this->view->setVar('Lang',$this->inc->getLang('web/web_news'));
		$this->view->pick("web/news/audit");
	}
	/* Chart */
	public function chartAction(){
		$i = 0;
		$color = array('#6FB737','#3A90BA','#3D3D3D');
		$Class = ClassWeb::find('fid=0');
		foreach ($Class as $val){
			//echo $val->id;
			$num = count(WebNews::find('class=":'.$val->id.':"'));
			$num = $num?$num:'1';
			$data[] = array('value'=>$num, 'color'=>$color[$i], 'label'=>$val->title);
			$i++;
		}
		return $this->response->setJsonContent($data);
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
	/* View */
	public function showAction(){
		$this->view->setVar('Lang',$this->inc->getLang('web/web_news'));
		$id = $this->request->getPost('id');
		$this->view->setVar('show', WebNews::findFirst(array('id='.$id)));
		$this->view->pick("web/news/show");
	}
	/* Data */
	public function DataAction($type=''){
		if($this->request->isPost()){
			// Add and Edit
			if($type=='save'){
				$post = $this->request->getPost();
				$post['uname'] = @$_SESSION['Admin']['uname'];
				$data = new WebNews();
				return $data->save($post)?$this->Result('suc'):$this->Result('err');
			// Delete
			}elseif($type=='delete'){
				$id = $this->request->getPost('id');
				$arr = json_decode($id);
				foreach ($arr as $val){
					$data = WebNews::findFirst('id='.$val);
					if($data->delete()==FALSE){return $this->Result('err');}
				}
				return $this->Result('suc');
			// Audit
			}elseif($type=='audit'){
				$id = $this->request->getPost('id');
				$state = $this->request->getPost('state');
				$arr = json_decode($id);
				foreach ($arr as $val){
					$data = WebNews::findFirst('id='.$val);
					if($data->save(array('state'=>$state))==FALSE){return $this->Result('err');}
				}
				return $this->Result('suc');
			}
		}else{return FALSE;}
	}
	private function Result($type=''){
		$lang = $this->inc->getLang('msg');
		if($type=='suc'){
			return $this->response->setJsonContent(array("status"=>"y","url"=>"WebNews"));
		}elseif($type=='err'){
			return $this->response->setJsonContent(array("status"=>"n","title"=>$lang->_("msg_title"),"msg"=>$lang->_("msg_err"),"text"=>$lang->_('msg_auto_close')));
		}
	}
}