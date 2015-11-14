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
		$this->view->setTemplateAfter(APP_THEMES.'/main');
		$this->view->pick("welcome/desktop");
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
					'label'=>'My First dataset',
					'fillColor'=>'rgba(220,220,220,0.2)',
					'strokeColor'=>'rgba(220,220,220,1)',
					'pointColor'=>'rgba(220,220,220,1)',
					'pointStrokeColor'=>'#fff',
					'pointHighlightFill'=>'#fff',
					'pointHighlightStroke'=>'rgba(220,220,220,1)',
					'data'=>$data2
				),
				array(
					'label'=>'My Second dataset',
					'fillColor'=>'rgba(151,187,205,0.2)',
					'strokeColor'=>'rgba(151,187,205,1)',
					'pointColor'=>'rgba(151,187,205,1)',
					'pointStrokeColor'=>'#fff',
					'pointHighlightFill'=>'#fff',
					'pointHighlightStroke'=>'rgba(151,187,205,1)',
					'data'=>$data1
				)
			)
		);
		return $this->response->setJsonContent($data);
	}
}