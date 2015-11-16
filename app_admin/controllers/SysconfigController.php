<?php
use Phalcon\Config\Adapter\Ini as ConfigIni;
class SysConfigController extends ControllerBase{
	// Index
	public function indexAction(){
		$File = new File();
		$Root = $_SERVER['DOCUMENT_ROOT'];
		$File->file_root = $Root.'/themes/admin/';
		$this->view->setVar('Themes',$File->lists());
		$File->file_root = $Root.'/webmis/themes/';
		$this->view->setVar('Webmis',$File->lists());
		$File->file_root = $Root.'/webmis/plugin/jquery/';
		$this->view->setVar('Jquery',$File->lists());

		$config = new ConfigIni(APP_PATH . 'config/config.ini');
		$this->view->setVar('Config',$config);
		$this->view->setVar('Lang',$this->inc->getLang('system/sys_config'));
		$this->view->setVar('LoadJS', array('system/sys_config.js'));
		// Menus
		$this->view->setVar('Menus',$this->inc->getMenus());
		$this->tag->prependTitle($this->inc->Ctitle);
		// View
		if($this->session->get('IsMobile')){
			$this->view->setTemplateAfter(APP_THEMES.'/main_m');
			$this->view->pick("system/config/index_m");
		}else{
			$this->view->setTemplateAfter(APP_THEMES.'/main');
			$this->view->pick("system/config/index");
		}
	}
	public function DataAction($type=''){
		if($this->request->isPost()){
			$data = array(
				'appTitle'=>$this->request->getPost('title'),
				'appCopy'=>$this->request->getPost('copy'),
				'backupDir'=>$this->request->getPost('backup'),
				'defaultThemes'=>$this->request->getPost('themes'),
				'webmisThemes'=>$this->request->getPost('wthemes'),
				'jqueryName'=>$this->request->getPost('jquery'),
				
				'adapter'=>$this->request->getPost('adapter'),
				'host'=>$this->request->getPost('host'),
				'username'=>$this->request->getPost('username'),
				'password'=>$this->request->getPost('password'),
				'name'=>$this->request->getPost('name'),
				
				'controllersDir'=>$this->request->getPost('cDir'),
				'modelsDir'=>$this->request->getPost('mDir'),
				'viewsDir'=>$this->request->getPost('vDir'),
				'formsDir'=>$this->request->getPost('fDir'),
				'libraryDir'=>$this->request->getPost('lDir'),
				'baseUri'=>$this->request->getPost('bDir'),
			);
			if($this->_Cinfig($data)){
				$this->response->redirect('Result/suc/SysConfig');
			}else{
				$this->response->redirect('Result/err');
			}
		}
	}
	private function _Cinfig($data=''){
		$file = __DIR__.'/../config/config.ini';
		$ct = @file_get_contents($file);
		if($ct){
			foreach ($data as $key=>$val){
				$pat = "/ ".$key." = (.*)/";
				$rep = " ".$key." = '".$val."'";
				$ct = preg_replace($pat,$rep,$ct);
			}
			/* Write */
			return file_put_contents($file,$ct)==TRUE?TRUE:FALSE;
		}else{return FALSE;}
	}
}