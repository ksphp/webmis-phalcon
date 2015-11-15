<?php
class HelpSystemController extends ControllerBase{
	// Index
	public function indexAction(){
		// Menus
		$this->view->setVar('Menus',$this->inc->getMenus());
		$this->tag->prependTitle($this->inc->Ctitle);
		// View
		if($this->session->get('IsMobile')){
			$this->view->setTemplateAfter(APP_THEMES.'/main_m');
			$this->view->pick("help/system/index_m");
		}else{
			$this->view->setTemplateAfter(APP_THEMES.'/main');
			$this->view->pick("help/system/index");
		}
	}
}