<?php
class DesktopController extends ControllerBase{
	// Index
	public function indexAction(){
		// Data
		//$this->view->setVar('Lang',$this->inc->getLang('welcome/desktop'));
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
		$data = array(
			'labels'=>array('January','February','March','April','May','June','July','August','September','October','November','December'),
			'datasets'=>array(
				array(
					'label'=>'My First dataset',
					'fillColor'=>'rgba(220,220,220,0.2)',
					'strokeColor'=>'rgba(220,220,220,1)',
					'pointColor'=>'rgba(220,220,220,1)',
					'pointStrokeColor'=>'#fff',
					'pointHighlightFill'=>'#fff',
					'pointHighlightStroke'=>'rgba(220,220,220,1)',
					'data'=>array(0, 0, 0, 0, 0, 65, 59, 80, 81, 56, 55, 40)
				),
				array(
					'label'=>'My Second dataset',
					'fillColor'=>'rgba(151,187,205,0.2)',
					'strokeColor'=>'rgba(151,187,205,1)',
					'pointColor'=>'rgba(151,187,205,1)',
					'pointStrokeColor'=>'#fff',
					'pointHighlightFill'=>'#fff',
					'pointHighlightStroke'=>'rgba(151,187,205,1)',
					'data'=>array(28, 48, 0, 19, 86, 27, 90, 0, 0, 0, 0, 0)
				)
			)
		);
		return $this->response->setJsonContent($data);
	}
}