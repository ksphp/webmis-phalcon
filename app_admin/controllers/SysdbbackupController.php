<?php
class SysDBBackupController extends ControllerBase{
	// Index
	public function indexAction(){
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
		// Menus
		$this->view->setVar('Menus',$this->inc->getMenus());
		$this->tag->prependTitle($this->inc->Ctitle);
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
		$this->view->pick("system/db/backup/del");
	}
	/* Data */
	public function DataAction($type=''){
		if($this->request->isPost()){
			$Tables = json_decode($this->request->getPost('table'));
			// Export
			if($type=='export'){
				$path = $_SERVER['DOCUMENT_ROOT'].APP_BACKUP;
				if(!is_dir($path)){return $this->Result('err');}
				// Data
				$data = '';
				foreach ($Tables as $table){
					$data .=  "\n";
					$data .=  "#\n";
					$data .=  "# TABLE STRUCTURE FOR: ".$table."\n";
					$data .=  "#\n\n";
					$data .=  "DROP TABLE IF EXISTS `".$table."`;\n";
					$data .=  "\n";
					// DDL
					$data .=  $this->query("SHOW CREATE TABLE `".$table."`")[0][1].';';
					$data .=  "\n\n";
					// Field
					$Fields = $this->field($table);
					$field = '';
					foreach ($Fields as $val){
						$field .= "`".$val."`, ";
					}
					$field = substr($field,0,-2);
					// Data
					$Datas = $this->query("SELECT * FROM `".$table."`");
					$query='';
					foreach ($Datas as $val){
						$sql='';
						foreach ($val as $d){
							$sql .= "'".$d."', ";
						}
						$sql = substr($sql,0,-2);
						$query .= "INSERT INTO `".$table."` (".$field.") VALUES (".$sql.");\n";
					}
					$data .=  $query;
					
				}
				$File = new File();
				$File->file_root = $path;
				$file = $this->request->getPost('name').'.'.$this->request->getPost('format');
				return $File->addFile($file, $data)?$this->Result('suc'):$this->Result('err');
			}elseif($type=='delete'){
				foreach ($Tables as $val){
					if($this->db->dropTable($val)==FALSE){$this->Result('err');}
				}
				return $this->Result('suc');
			}
		}
	}
	private function Result($type=''){
		$lang = $this->inc->getLang('msg');
		if($type=='suc'){
			return $this->response->setJsonContent(array("status"=>"y"));
		}elseif($type=='err'){
			return $this->response->setJsonContent(array("status"=>"n","title"=>$lang->_("msg_title"),"msg"=>$lang->_("msg_err"),"text"=>$lang->_('msg_auto_close')));
		}
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