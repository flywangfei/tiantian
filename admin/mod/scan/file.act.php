<?php
/**
 * ============================================================================
 * 版权所有 2008-2012 多多科技，并保留所有权利。
 * 网站地址: http://soft.duoduo123.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/

if(!defined('ADMIN')){
	exit('Access Denied');
}

$ignore_dir='/data|/upload';
$suffix='php|inc';
function scan($dir, & $record_arr,$i=0) {
	global $ignore_dir,$suffix,$duoduo;
	if (is_dir($dir)) {
		if (1) {
			$dh = opendir($dir);
			while ($file = readdir($dh)) {
				if ($file != "." && $file != "..") {
					$fullpath = $dir . "/" . $file;
					if (!is_dir($fullpath)) {
						if (preg_match('/(.' . $suffix . ')$/', $fullpath)) {
							$a['size']=filesize($fullpath);
							$a['time']=filemtime($fullpath);
							$a['md5']=md5_file($fullpath);
							$a['path']=str_replace(DDROOT,'',$fullpath);

							$file_info=$duoduo->select('file','*','path="'.$a['path'].'"');
							
							if($_GET['update']==1){
								if($file_info['id']>0){
									$duoduo->update('file',$a,'id='.$file_info['id']);
								}
								else{
									$duoduo->insert('file',$a);
								}
							}
							else{
								$a['msg']='';
								if(!$file_info['id'] || $a['size']!=$file_info['size'] || $a['time']!=$file_info['time'] || $a['md5']!=$file_info['md5']){
									if(!$file_info['id']){
										$a['msg'].='多余文件。';
									}
									else{
										if($a['time']!=$file_info['time']){$a['msg'].='文件修改时间有变化。';}
										if($a['md5']!=$file_info['md5']){$a['msg'].='文件内容有变化。';}
									}	
									$record_arr[]=$a;
								}
							}
						}
					} 
					else {
						scan($fullpath, $record_arr,$i);
					}
				}
			}
			closedir($dh);
		}
	} 
	else {
		$a['size']=filesize($dir);
		$a['time']=filemtime($dir);
		$a['md5']=md5_file($dir);
		$a['path']=str_replace(DDROOT,'',$dir);
		
		$file_info=$duoduo->select('file','*','path="'.$a['path'].'"');
		
		if($_GET['update']==1){
			if($file_info['id']>0){
				$duoduo->update('file',$a,'id='.$file_info['id']);
			}
			else{
				$duoduo->insert('file',$a);
			}
		}
		else{
			$a['msg']='';
			if(!$file_info['id'] || $a['size']!=$file_info['size'] || $a['time']!=$file_info['time'] || $a['md5']!=$file_info['md5']){
				if(!$file_info['id']){
					$a['msg'].='多余文件。';
				}
				else{
					if($a['time']!=$file_info['time']){$a['msg'].='文件修改时间有变化。';}
					if($a['md5']!=$file_info['md5']){$a['msg'].='文件内容有变化。';}
				}	
				$record_arr[]=$a;
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
	if($_GET['update']==1){
		jump(-1,'更新完成');
	}
} 
else { //列出根目录文件
	$filelists = Array ();
	$dh = dir(DDROOT);
	while (($filename = $dh->read()) !== false) {
		$root_filename = DDROOT . '/' . $filename;
		if(!preg_match('#^'.DDROOT.'/data#',$root_filename) && !preg_match('#^'.DDROOT.'/upload#',$root_filename) && !preg_match('#^'.DDROOT.'/install#',$root_filename)){
		if ($filename != '.' && $filename != '..' && $filename != './..') {
			if (is_dir($root_filename)) {
				$filelists1[] = iconv('gbk','utf-8',$filename);
			} else {
				$filelists2[] = iconv('gbk','utf-8',$filename);
			}
		}
		}
	}
	$dh->close();
}
?>