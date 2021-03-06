<?php
/**
 * ============================================================================
 * 版权所有 2008-2012 多多网络，并保留所有权利。
 * 网站地址: http://soft.duoduo123.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/

if(!defined('ADMIN')){
	exit('Access Denied');
}

$danger='phpinfo|dl|exec|popen|pclose|proc_nice|proc_terminate|proc_get_status|proc_close|leak|apache_child_terminate|escapeshellcmd|system|exec|passthru|proc_open|shell-exec|posix_getpwuid|symlink|cmd|CreateObject';
$suffix='php|inc|asp';
$ignore_filename='/admin/mod/scan/check.mod.php|/comm/ddUpgrade.class.php|/comm/class.phpmailer.php|/comm/dd.func.php|/comm/Taoapi_Util.php|/comm/upload.class.php|/kindeditor/php/JSON.php|/uc_client/client.php|/uc_client/model/base.php|/comm/collect.class.php|/api/kaixin/kxHttpClient.php|/api/qq/comm/utils.php|/api/sina/saetv2.ex.class.php|/api/sina/weibooauth.php|/admin/mod/webserver/set.act.php'; 
$ignore_dir='/data/bdata|/data/temp';
function scan($dir, & $record_arr,$i=0) {
	global $suffix, $danger, $ignore_filename, $ignore_dir;
	if (is_dir($dir)) {
		if (!preg_match('#(.' . $ignore_dir . ')$#', $dir)) {
			$dh = opendir($dir);
			while ($file = readdir($dh)) {
				if ($file != "." && $file != "..") {
					$fullpath = $dir . "/" . $file;
					if (!is_dir($fullpath)) {
						if (preg_match('/(.' . $suffix . ')$/', $fullpath) && !preg_match('#(.' . $ignore_filename . ')$#', $fullpath)) {
							$php = file_get_contents($fullpath);
							if (preg_match('/(' . $danger . ')[ \r\n\t]{0,}([\[\(])/', $php,$a)) {
								$b=array('filename'=>iconv('gbk', 'utf-8', $fullpath),'danger'=>$a[1]);
								$record_arr[]=$b;
							}
						}
					} else {
						scan($fullpath, $record_arr,$i);
					}
				}
			}
			closedir($dh);
		}
	} 
	else {
		if (preg_match('/(.' . $suffix . ')$/', $dir)) {
			$php = file_get_contents($dir);
			if (preg_match('/(' . $danger . ')[ \r\n\t]{0,}([\[\(])/', $php,$a)) {
				$b=array('filename'=>iconv('gbk', 'utf-8', $fullpath),'danger'=>$a[1]);
				$record_arr[]=$b;
			}
		}
	}
}

if ($_GET['sub'] != '') {
    //print_r($_POST['dir']);
	$record_arr=array();
	if(empty($_GET['dir'])){
	    jump(-1,'所选目录不能为空！');
	}
	foreach($_GET['dir'] as $v){
	    scan($v,$record_arr);
	}
} 
else { //列出根目录文件
	$filelists = Array ();
	$dh = dir(DDROOT);
	while (($filename = $dh->read()) !== false) {
		$root_filename = DDROOT . '/' . $filename;
		if ($filename != '.' && $filename != '..' && $filename != './..') {
			if (is_dir($root_filename)) {
				$filelists1[] = iconv('gbk','utf-8',$filename);
			} else {
				$filelists2[] = iconv('gbk','utf-8',$filename);
			}
		}
	}
	$dh->close();
}
?>