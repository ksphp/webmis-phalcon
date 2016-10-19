<?php
// Lang
if(isset($_GET['lang'])){$_SESSION['Lang'] = $_GET['lang'];}else{$_SESSION['Lang'] = 'en-us';}
$lang = array(
	'en-us'=>array(
		'admin'=>'System Administrator',
		'uname'=>'UserName',
		'passwd'=>'PassWord',
		'db_config'=>'Database Config',
		'db_type'=>'DB Type',
		'db_host'=>'HostName',
		'db_name'=>'Database',
		'install'=>'Install',
		'msg_suc'=>'Success',
		'msg_err'=>'Failure',
		'msg_not_write'=>'File not to write!',
		'msg_file_read'=>'Read File',
		'msg_file_write'=>'Write File',
		'msg_chr'=>'Bit character!',
		'msg_db_conn'=>'Connection database',
		'msg_db_import'=>'Import data',
		'msg_finish'=>'Finish',
		'link_home'=>'Back Home',
		'link_admin'=>'Administrator Login',
	),
	'zh-cn'=>array(
		'admin'=>'系统管理员',
		'uname'=>'用户名',
		'passwd'=>'密码',
		'db_config'=>'数据库配置',
		'db_type'=>'DB 类型',
		'db_host'=>'主机名/IP',
		'db_name'=>'数据库名',
		'install'=>'安装',
		'msg_suc'=>'成功',
		'msg_err'=>'失败',
		'msg_not_write'=>'文件不可写！',
		'msg_file_read'=>'读取文件',
		'msg_file_write'=>'写入文件',
		'msg_chr'=>'位字符！',
		'msg_db_conn'=>'连接数据库',
		'msg_db_import'=>'导入数据',
		'msg_finish'=>'完成',
		'link_home'=>'返回首页',
		'link_admin'=>'管理员登陆',
	)
);
$Lang = $lang[$_SESSION['Lang']];

// 修改配置文件
function cofingFile($file,$ct,$data){
	foreach ($data as $key=>$val){
		$pat = "/\t\t'".$key."'=>(.*)/";
		$rep = "\t\t'".$key."'=>'".$val."',";
		$ct = preg_replace($pat,$rep,$ct);
	}
	/* Write */
	return file_put_contents($file,$ct)==TRUE?TRUE:FALSE;
}

$isWrite='';$msg='';$suc='';

// Is Write
if(!is_writable('webmis.sql')){
	$isWrite .= '<p class="err">install/webmis.sql '.$Lang['msg_not_write'].'</p>';
}
if(!is_writable('../../app_admin/config/config.php')){
	$isWrite .= '<p class="err">app_admin/config/config.php '.$Lang['msg_not_write'].'</p>';
}
if(!is_writable('../../app_web/config/config.php')){
	$isWrite .= '<p class="err">app_web/config/config.php '.$Lang['msg_not_write'].'</p>';
}
if(!is_writable('../../app_m/config/config.php')){
	$isWrite .= '<p class="err">app_m/config/config.php '.$Lang['msg_not_write'].'</p>';
}
if(!is_writable('../../app_data/config/config.php')){
	$isWrite .= '<p class="err">app_data/config/config.php '.$Lang['msg_not_write'].'</p>';
}

// Install
if (isset($_POST['install'])){
	$uname = trim($_POST['uname']);
	if(strlen($uname)<3 || strlen($uname)>16){
		$msg = $Lang['uname'].' 3~16 '.$Lang['msg_chr'];
	}
	$passwd = $_POST['passwd'];
	if(strlen($passwd)<6 || strlen($passwd)>32){
		$msg = strlen($passwd).$Lang['passwd'].' 6~32 '.$Lang['msg_chr'];
	}
	$type = $_POST['type'];
	$hostname = trim($_POST['hostname']);
	$username = trim($_POST['username']);
	$password = $_POST['password'];
	$database = trim($_POST['database']);
	if(!$msg){
		try {
			$db = new PDO(strtolower($type).':dbname='.$database.';host='.$hostname,$username,$password);
			$db->query('set names utf8;');
			$suc = '<p class="suc">'.$Lang['msg_db_conn'].' [ '.$Lang[ 'msg_suc'].' ]</p>';
			// Database
			$content = file_get_contents('webmis.sql');
			if(!$content) {
				$suc .= '<p class="err">'.$Lang['msg_file_read' ].'：'.'webmis.sql [ '.$Lang['msg_err' ].' ]</p>';
			}else{
				$suc .= '<p class="suc">'.$Lang['msg_file_read' ].'：'.'webmis.sql [ '.$Lang['msg_suc' ].' ]</p>';
				$content = preg_replace("/\n#\n# TABLE(.*)\s#\n\n/i","",$content);
				$content = preg_replace("/'admin'/","'".$uname."'",$content);
				$content = preg_replace("/'21232f297a57a5a743894a0e4a801fc3'/","'".md5($passwd)."'",$content);
				$sqls = array_filter(explode(";\n",$content));
				$data = '<p class="suc">'.$Lang['msg_db_import' ].' [ '.$Lang['msg_suc' ].' ]</p>';
				foreach($sqls as $sql){
					$sql = trim($sql);
					if($sql) {
						if(!$db->query($sql)) {
							$err = $db->errorInfo();
							$data = '<p class="err">'.$Lang['msg_db_import' ].' [ '.$Lang['msg_err' ].' ]</p>';
							$data .= '<p class="err">'.$err[2].'</p>';
							return FALSE;
						}
					}
				}
				$suc .= $data;
				// Database Config
				$file1 = '../../app_admin/config/config.php';
				$file2 = '../../app_web/config/config.php';
				$file3 = '../../app_m/config/config.php';
				$file4 = '../../app_data/config/config.php';
				$ct1 = file_get_contents($file1);
				$ct2 = file_get_contents($file2);
				$ct3 = file_get_contents($file3);
				$ct4 = file_get_contents($file4);
				if(!$ct1){
					$suc .= '<p class="err">'.$Lang['msg_file_read' ].'：'.$file1.' [ '.$Lang['msg_err' ].' ]</p>';
				}elseif(!$ct2){
					$suc .= '<p class="err">'.$Lang['msg_file_read' ].'：'.$file2.' [ '.$Lang['msg_err' ].' ]</p>';
				}elseif(!$ct3){
					$suc .= '<p class="err">'.$Lang['msg_file_read' ].'：'.$file3.' [ '.$Lang['msg_err' ].' ]</p>';
				}elseif(!$ct4){
					$suc .= '<p class="err">'.$Lang['msg_file_read' ].'：'.$file4.' [ '.$Lang['msg_err' ].' ]</p>';
				}else{
					$data = array('adapter'=>$type,'host'=>$hostname,'username'=>$username,'password'=>$password,'name'=>$database);
					if(cofingFile($file1,$ct1,$data)){
						$suc .= '<p class="suc">'.$Lang['msg_file_write' ].'：'.$file1.' [ '.$Lang['msg_suc' ].' ]</p>';
					}else {
						$suc .= '<p class="err">'.$Lang['msg_file_write' ].'：'.$file1.' [ '.$Lang['msg_err' ].' ]</p>';
					};
					if(cofingFile($file2,$ct2,$data)){
						$suc .= '<p class="suc">'.$Lang['msg_file_write' ].'：'.$file2.' [ '.$Lang['msg_suc' ].' ]</p>';
					}else {
						$suc .= '<p class="err">'.$Lang['msg_file_write' ].'：'.$file2.' [ '.$Lang['msg_err' ].' ]</p>';
					};
					if(cofingFile($file3,$ct3,$data)){
						$suc .= '<p class="suc">'.$Lang['msg_file_write' ].'：'.$file3.' [ '.$Lang['msg_suc' ].' ]</p>';
					}else {
						$suc .= '<p class="err">'.$Lang['msg_file_write' ].'：'.$file3.' [ '.$Lang['msg_err' ].' ]</p>';
					};
					if(cofingFile($file4,$ct4,$data)){
						$suc .= '<p class="suc">'.$Lang['msg_file_write' ].'：'.$file4.' [ '.$Lang['msg_suc' ].' ]</p>';
					}else {
						$suc .= '<p class="err">'.$Lang['msg_file_write' ].'：'.$file4.' [ '.$Lang['msg_err' ].' ]</p>';
					};
					$suc .= '<p>'.$Lang['msg_finish'].'</p>';
					$suc .= '<div class="finish"><a href="../">'.$Lang['link_home' ].'</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="../admin/">'.$Lang['link_admin' ].'</a></div>';
				}
			}
		}catch (PDOException $e) {
			$msg = $e->getMessage();
		}
	}
}else{
	$uname='webmis';$type='';$hostname='localhost';$username='root';$database='webmis';
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="author" content="KSPHP" />
	<title>WebMIS Install</title>
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
<style type="text/css">
body,div,span,ul,li,table,tr,td,input,a,h1,h2,h3,h4{margin: 0; padding: 0;}
body{font-size: 12px; background: url("bg.png")  #2D2D2D center center; background-size: 0.8%; color: #DFE1E8;}
a{color: #007568; text-decoration: none;}
a:hover{color: #FF6600;}
input{box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;}
input:focus{box-shadow: 0 0 6px rgba(153, 153, 153, 0.7);}
.input{height: 30px; line-height: 30px; border: #999 1px solid; background: #FFF; display: inline-block; padding: 0 5px;}
.copy{padding: 10px 0; text-align: center;}
.lang{position: absolute; top: 15px; right: 15px; padding: 8px 20px; background-color: #333; color: #DFE1E8; border-radius: 5px;}
.lang a{color: #DFE1E8;}
.lang a:hover{color: #FF6600;}
h1{position: absolute; width: 420px; font-size: 62px; color: #FFF; text-align: center; margin-top: -100px;}
h2{font-size: 14px; border-bottom: #DADCDF 1px solid; color: #999;}
.body{position: absolute; width: 420px; left: 0; right: 0; top: 20%; margin: 0 auto; background-color: #F5F5F5; color: #666; border-radius: 5px; padding: 10px 20px;}
.list{padding: 10px 0px; margin: 0;}
.list dt{float: left; width: 80px; line-height: 32px; text-align: right; padding: 5px;}
.list dd{line-height: 32px; padding: 5px 0;}
.sub{text-align: center; padding: 5px 0 10px;}
.sub input{cursor: pointer; border: none; padding: 10px 50px; background-color: #3A90BA; font-size: 14px; color: #DFE1E8; border-radius: 5px; box-shadow: 1px 1px 2px #999;}
.sub input:hover{background-color: #BF3E11;}
.err{color: red;}
.suc{color: green;}
.finish{padding: 10px 0; text-align: center; font-size: 14px;}
</style>
</head>

<body>
	<span class="lang"><a href="?lang=en-us">English</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="?lang=zh-cn">简体中文</a></span>
	<div class="body">
		<h1>WebMIS</h1>
<?php if($isWrite){?>
		<div class="ct"><?php echo $isWrite;?></div>
<?php }elseif(!$suc){?>
		<form method="post" action="" >
		<h2><?php echo $Lang['admin'];?></h2>
		<dl class="list">
			<dt><?php echo $Lang['uname'];?>：</dt>
			<dd><input type="text" name="uname" value="<?php echo $uname;?>" maxlength="16" class="input" style="width: 210px;"></dd>
			<dt><?php echo $Lang['passwd'];?>：</dt>
			<dd><input type="password" name="passwd" maxlength="32" class="input" style="width: 210px;"></dd>
		</dl>
		<h2><?php echo $Lang['db_config'];?></h2>
		<dl class="list">
			<dt><?php echo $Lang['db_type'];?>：</dt>
			<dd>
				<select name="type" style="width: 222px;">
					<option value="Mysql" <?php echo $type=='Mysql'?'selected':'';?>>MySQL</option>
					<option value="Postgresql" <?php echo $type=='Postgresql'?'selected':'';?>>PostgreSQL</option>
					<option value="Sqlite" <?php echo $type=='Sqlite'?'selected':'';?>>SQLite</option>
					<option value="Oracle" <?php echo $type=='Oracle'?'selected':'';?>>Oracle</option>
				</select>
			</dd>
			<dt><?php echo $Lang['db_host'];?>：</dt>
			<dd><input type="text" name="hostname" value="<?php echo $hostname;?>" class="input" style="width: 210px;"></dd>
			<dt><?php echo $Lang['uname'];?>：</dt>
			<dd><input type="text" name="username" value="<?php echo $username;?>" class="input" style="width: 210px;"></dd>
			<dt><?php echo $Lang['passwd'];?>：</dt>
			<dd><input type="password" name="password" class="input" style="width: 210px;"></dd>
			<dt><?php echo $Lang['db_name'];?>：</dt>
			<dd><input type="text" name="database" value="<?php echo $database;?>" class="input" style="width: 210px;"></dd>
		</dl>
		<div class="sub">
			<input type="submit" name="install" value="<?php echo $Lang['install'];?>">
		</div>
		<div class="err" style="text-align: center;"><?php echo $msg;?></div>
		</form>
<?php }else{echo $suc;}?>
		<div class="copy">
			Copyright © <a href="http://www.ksphp.com/">WebMIS</a> All Rights Reserved
		</div>
	</div>
</body>
</html>