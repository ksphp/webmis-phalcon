<?php
class SysAdminController extends ControllerBase{
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
			$data = Admins::find(array($where,'order'=>'id'));
			$getUrl = $like['getUrl'];
		}else{
			$getUrl = '';
			$data = Admins::find(array('order'=>'id'));
		}
		$page = $this->inc->getPage(array('data'=>$data,'getUrl'=>$getUrl));
		$this->view->setVar('Page', $page);
		// Data
		$this->view->setVar('Lang',$this->inc->getLang('system/sys_admin'));
		$this->view->setVar('LoadJS', array('system/sys_admin.js'));
		// Menus
		$this->view->setVar('Menus',$this->inc->getMenus());
		$this->tag->prependTitle($this->inc->Ctitle);
		// View
		if($this->session->get('IsMobile')){
			$this->view->setTemplateAfter(APP_THEMES.'/main_m');
			$this->view->pick("system/admin/index_m");
		}else{
			$this->view->setTemplateAfter(APP_THEMES.'/main');
			$this->view->pick("system/admin/index");
		}
	}
	/* Search */
	public function seaAction(){
		$this->view->setVar('Lang',$this->inc->getLang('system/sys_admin'));
		$this->view->pick("system/admin/sea");
	}
	/* ADD */
	public function addAction(){
		$this->view->setVar('Lang',$this->inc->getLang('system/sys_admin'));
		$this->view->pick("system/admin/add");
	}
	/* Edit */
	public function editAction(){
		$id = $this->request->getPost('id');
		$data = Admins::findFirst(array('id='.$id));
		$this->view->setVar('Edit',$data);
		$this->view->setVar('Lang',$this->inc->getLang('system/sys_admin'));
		$this->view->pick("system/admin/edit");
	}
	/* Del */
	public function delAction(){
		$this->view->pick("system/admin/del");
	}
	/* Data */
	public function DataAction($type=''){
		if($this->request->isPost()){
			if($type=='add'){
				$post = $this->request->getPost();
				if(!empty($post['passwd'])){
					$post['password'] = md5($post['passwd']);
				}
				unset($post['passwd']);
				$post['rtime'] = date('Y-m-d H:i:s');
				$data = new Admins();
				if($data->save($post)){
					$this->response->redirect('Result/suc/SysAdmin');
				}else{
					$this->response->redirect('Result/err');
				}
			// Edit
			}elseif($type=='edit'){
				$id = $this->request->getPost('id');
				$data = Admins::findFirst(array('id=:id:','bind'=>array('id'=>$id)));
				$post = $this->request->getPost();
				$passwd = $this->request->getPost('passwd');
				if(!empty($passwd)){
					$post['password'] = md5($passwd);
				}
				if($data->save($post,array('password','state','email','tel','name','department','position'))){
					$this->response->redirect('Result/suc/SysAdmin');
				}else{
					$this->response->redirect('Result/err');
				}
			// Delete
			}elseif($type=='delete'){
				$id = $this->request->getPost('id');
				$arr = json_decode($id);
				foreach ($arr as $val){
					$data = Admins::findFirst('id='.$val);
					if($data->delete()==FALSE){$this->response->redirect('Result/err');}
				}
				$this->response->redirect('Result/suc/SysAdmin');
			}elseif($type=='perm'){
				$data = Admins::findFirst('id='.$this->request->getPost('id'));
				$data->perm = $this->request->getPost('perm');
				if($data->save()){
					$this->response->redirect('Result/suc/SysAdmin');
				}else{
					$this->response->redirect('Result/err');
				}
			}
		}else{return FALSE;}
	}
	
	/* Perm */
	public function permAction(){
		$Lang = $this->inc->getLang('menus');
		$html = '';
		$permArr = $this->splitPerm($this->request->getPost('perm'));
		$actionM = MenuAction::find();
		
		$menu1 = Menus::find('fid=0');
		foreach($menu1 as $m1){
			$ck = isset($permArr[$m1->id])?'checked':'';
			$title1 = $Lang->_($m1->title);
			$html .= '<div id="oneMenuPerm" class="perm">';
			$html .= '    <span class="text1"><input type="checkbox" value="'.$m1->id.'" '.$ck.' /></span>';
			$html .= '    <span>[<a href="#">-</a>] '.$title1.'</span>';
			$html .= '</div>';
			$menu2 = Menus::find('fid='.$m1->id);
			foreach($menu2 as $m2){
				$ck = isset($permArr[$m2->id])?'checked':'';
				$title2 = $Lang->_($m2->title);
				$html .= '<div id="twoMenuPerm" class="perm">';
				$html .= '    <span class="text2"><input type="checkbox" value="'.$m2->id.'" '.$ck.' /></span>';
				$html .= '    <span>[<a href="#">-</a>] '.$title2.'</span>';
				$html .= '</div>';
				$menu3 = Menus::find('fid='.$m2->id);
				foreach($menu3 as $m3){
					$ck = isset($permArr[$m3->id])?'checked':'';
					$title3 = $Lang->_($m3->title);
					$html .= '<div id="threeMenuPerm" class="perm perm_action">';
					$html .= '      <span class="text3"><input type="checkbox" name="threeMenuPerm" value="'.$m3->id.'" '.$ck.' /></span>';
					$html .= '      <span>[<a href="#">-</a>] '.$title3.'</span>';
					$html .= '  <span id="actionPerm_'.$m3->id.'"> ( ';
					foreach($actionM as $val){
						if(intval($m3->perm) & intval($val->perm)){
							$ck = @$permArr[$m3->id]&intval($val->perm)?'checked':'';
							$name = $Lang->_($val->name);
							$html .= '<span><input type="checkbox" value="'.$val->perm.'" '.$ck.' /></span><span class="text">'.$name.'</span>';
						}
					}
					$html .= ')</span>';
					$html .= '</div>';
				}
			}
		}
		$this->view->setVar('menusHtml',$html);
		$this->view->pick("system/admin/perm");
	}
	/* SplitPerm */
	private function splitPerm($perm){
		if($perm){
			$arr = explode(' ', $perm);
			foreach($arr as $val) {
				$num = explode(':', $val);
				$permArr[$num[0]]= $num[1];
			}
			return $permArr;
		}else{return FALSE;}
	}
}