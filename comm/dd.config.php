<?php
header("Content-type: text/html; charset=utf-8");
error_reporting(0);
date_default_timezone_set('PRC');
define('DDROOT', str_replace(DIRECTORY_SEPARATOR,'/',dirname(dirname(__FILE__))));

if(!is_file(DDROOT.'/data/conn.php')){
    header('Location:install/index.php');
}

$mod=isset($_GET['mod'])?$_GET['mod']:'index'; //当前模块
$act=isset($_GET['act'])?$_GET['act']:'index'; //当前行为
define('MOD',$mod);
define('ACT',$act);

include (DDROOT . '/data/conn.php');
include (DDROOT . '/comm/lib.php');

$duoduo = new duoduo();
$duoduo->dbserver=$dbserver;
$duoduo->dbuser=$dbuser;
$duoduo->dbpass=$dbpass;
$duoduo->dbname=$dbname;
$duoduo->BIAOTOU=BIAOTOU;
$duoduo_link=$duoduo->connect();

if(!defined('ADMIN')){
	$webset=dd_get_cache('webset');
	$duoduo->webset=$webset;
	$constant=dd_get_cache('constant');
	foreach($constant as $k=>$v){
    	define($k,$v);
	}
	
}
else{
	$webset=$duoduo->webset(101);
	$duoduo->webset=$webset;
}
define('SITEURL', 'http://'.URL);
define('TIME',$_SERVER['REQUEST_TIME']+$webset['corrent_time']);

$sj=date('Y-m-d H:i:s');
?>