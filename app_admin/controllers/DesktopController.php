<?php
class DesktopController extends ControllerBase{
	// Index
	public function indexAction(){
		// Data
		$this->view->setVar('Lang',$this->inc->getLang('welcome/desktop'));
		$this->view->setVar('LoadJS', array('welcome/desktop.js'));
		// Menus
		$this->view->setVar('Menus',$this->inc->getMenus());
		$this->tag->prependTitle($this->inc->Ctitle);
		// View
		if($this->session->get('IsMobile')){
			$this->view->setTemplateAfter(APP_THEMES.'/main_m');
			$this->view->pick("welcome/desktop_m");
		}else{
			$this->view->setTemplateAfter(APP_THEMES.'/main');
			$this->view->pick("welcome/desktop");
		}
	}
	/* Chart */
	public function chartAction(){
		$lang = $this->inc->getLang('welcome/desktop');
		$year = date("Y");
		$last = $year-1;
		for($i=1;$i<13;$i++){
			$m = str_pad($i,2,'0',STR_PAD_LEFT);
			$data1[] = count(LogAdminLogin::find("uname='".$_SESSION['Admin']['uname']."' AND time LIKE '".$year."-".$m."%'"));
			$data2[] = count(LogAdminLogin::find("uname='".$_SESSION['Admin']['uname']."' AND time LIKE '".$last."-".$m."%'"));
			$name[] = $lang->_('wel_desktop_m'.$m);
		}
		$data = array(
			'labels'=>$name,
			'datasets'=>array(
				array(
					'label'=>'Now year log',
					'backgroundColor'=>'rgba(151,187,205,0.2)',
					'borderColor'=>'rgba(151,187,205,1)',
					'borderWidth'=>2,
					'data'=>$data1
				),
				array(
					'label'=>'Last year log',
					'backgroundColor'=>'rgba(220,220,220,0.2)',
					'borderColor'=>'rgba(220,220,220,1)',
					'borderWidth'=>2,
					'data'=>$data2
				)
			)
		);
		return $this->response->setJsonContent($data);
	}
}