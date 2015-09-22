<?php
class SysDBBackupController extends ControllerBase{
	// Index
	public function indexAction(){
		// Menus
		$this->view->setVar('Menus',$this->inc->getMenus());
		$this->tag->prependTitle($this->inc->Ctitle);
		// Data
		$all = $this->db->listTables();
		$tables = ''; $i=1;
		foreach ($all as $val){
			$tables[$i]['name'] = $val;
			$fields = $this->field($val);
			$field = '';
			foreach ($fields as $name){
				$field .= $name.', ';
			}
			$field = substr($field,0,-2);
			$tables[$i]['field'] = $field;
			$tables[$i]['num'] = $this->query("SELECT count(*) FROM `".$val."`")[0][0];
			$i++;
		}
		$this->view->setVar('Tables',$tables);
		$this->view->setVar('Lang',$this->inc->getLang('system/sys_db'));
		$this->view->setVar('LoadJS', array('system/sys_db_backup.js'));
		// View
		$this->view->setTemplateAfter(APP_THEMES.'/main');
		$this->view->pick("system/db/backup/index");
	}
	/* Export */
	public function expAction(){
		$this->view->setVar('Table',$this->request->getPost('table'));
		$this->view->setVar('Fname','Data_'.date('Y_m_d_His'));
		$this->view->setVar('Lang',$this->inc->getLang('system/sys_db'));
		$this->view->pick("system/db/backup/exp");
	}
	/* Del */
	public function delAction(){
		$this->view->pick("system/menus/del");
	}

	// Query
	private function query($sql=''){
		$result = $this->db->query($sql);
		$result->setFetchMode(PDO::FETCH_NUM);
		return $result->fetchAll();
	}
	// Field
	private function field($table=''){
		$all = $this->query("SHOW COLUMNS FROM `".$table."`");
		$data = '';
		foreach ($all as $val){
			$data[] = $val[0];
		}
		return $data;
	}
}