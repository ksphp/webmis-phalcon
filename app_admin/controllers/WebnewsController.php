<?php
class WebNewsController extends ControllerBase{
	public function initialize(){
		parent::initialize();
		$this->root = $_SERVER['DOCUMENT_ROOT'];
		$this->path = '/upload/web/news/';
	}
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
		$this->view->setVar('Lang',$this->inc->getLang('web/web_news'));
		$id = $this->request->getPost('id');
		$Edit = WebNews::findFirst(array('id='.$id));
		$this->view->setVar('Edit',$Edit);
		// Upload
		$upload = '';
		if(!empty($Edit->upload)){
			$File = new File();
			$arr = array_filter(explode(',', $Edit->upload));
			foreach ($arr as $val){
				$upload[] = array('path'=>$this->path,'name'=>$val,'size'=>$File->formatBytes($File->size($this->root.$this->path.$val)));
			}
		}
		$this->view->setVar('Upload',$upload);
		
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
			// Add
			if($type=='add'){
				$post = $this->request->getPost();
				$post['uname'] = @$_SESSION['Admin']['uname'];
				$data = new WebNews();
				if($data->save($post)){
					header("Location: ".$this->url->get('index/Result/suc/WebNews'));
				}else{
					header("Location: ".$this->url->get('index/Result/err'));
				}
			// Edit
			}if($type=='edit'){
				$id = $this->request->getPost('id');
				$data = WebNews::findFirst('id='.$id);
				$data->class = $this->request->getPost('class');
				$data->title = $this->request->getPost('title');
				$data->sources = $this->request->getPost('sources');
				$data->author = $this->request->getPost('author');
				$data->ctime = $this->request->getPost('ctime');
				$data->key = $this->request->getPost('key');
				$data->summary = $this->request->getPost('summary');
				$data->img = $this->request->getPost('img');
				$data->content = $this->request->getPost('content');
				if($data->save()){
					header("Location: ".$this->url->get('index/Result/suc/WebNews'));
				}else{
					header("Location: ".$this->url->get('index/Result/err'));
				}
			// Delete
			}elseif($type=='delete'){
				$id = $this->request->getPost('id');
				$arr = json_decode($id);
				foreach ($arr as $val){
					$data = WebNews::findFirst('id='.$val);
					if($data->delete()==FALSE){header("Location: ".$this->url->get('index/Result/err'));}
					// Remove Upload
					$arr = array_filter(explode(',', $data->upload));
					foreach ($arr as $val){@unlink($this->root.$this->path.$val);}
				}
				header("Location: ".$this->url->get('index/Result/suc/WebNews'));
			// Audit
			}elseif($type=='audit'){
				$id = $this->request->getPost('id');
				$state = $this->request->getPost('state');
				$arr = json_decode($id);
				foreach ($arr as $val){
					$data = WebNews::findFirst('id='.$val);
					if($data->save(array('state'=>$state))==FALSE){header("Location: ".$this->url->get('index/Result/err'));}
				}
				header("Location: ".$this->url->get('index/Result/suc/WebNews'));
			}
		}else{return FALSE;}
	}
	/* UpLoad */
	public function uploadAction(){
		$this->path = '/upload/web/news/';
		$upName = 'webmis';
		// Files
		if (!empty($_FILES)){
			$tempFile = $_FILES[$upName]['tmp_name'];
			$name = date('YmdHis').rand(10, 99).'.'.substr(strrchr($_FILES[$upName]['name'], '.'), 1);
			$targetFile = $this->root.$this->path.$name;
			// News
			$id = $this->request->getPost('id');
			$data = WebNews::findFirst('id='.$id);
			$data->upload = $data->upload.$name.',';
			
			if(move_uploaded_file($tempFile,$targetFile) && $data->save()){
				$data = array('status'=>'ok','path'=>$this->path,'name'=>$name);
			}else{
				$data = array('status'=>'ok','name'=>$name);
			}
			return $this->response->setJsonContent($data);
		}
	}
	public function RemoveIMGAction(){
		$this->path = '/upload/web/news/';
		$id = $this->request->getPost('id');
		$name = $this->request->getPost('name');
		$data = WebNews::findFirst('id='.$id);
		$data->upload = str_replace($name.',','',$data->upload);
		if($data->save() && unlink($this->root.$this->path.$name)==TRUE){
			return $this->response->setJsonContent(array('status'=>'ok'));
		}else{
			return $this->response->setJsonContent(array('status'=>'no'));
		}
	}
}