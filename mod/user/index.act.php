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

if(!defined('INDEX')){
	exit('Access Denied');
}

$txstatus=$dduser['txstatus'];
$yitixian=$dduser['yitixian'];

foreach($webset['level'] as $k=>$v){
	$level_arr[]=$k;
}

if($dduser['level']>=$level_arr[3]){
    $dengji_img = "<img src='images/v3.gif' alt='钻石会员' />";
}
elseif($dduser['level']>=$level_arr[2]){
    $dengji_img = "<img src='images/v2.gif' alt='白金会员'  />";
}
elseif($dduser['level']>=$level_arr[1]){
    $dengji_img = "<img src='images/v1.gif'  alt='黄金会员'/>";
}
else{
    $dengji_img = "<img src='images/v0.gif'  alt='普通会员' />";
}

$webid=$duoduo->select('apilogin','webid','uid="'.$dduser['id'].'"');
$key_webid=dd_crc32(DDKEY.$webid);
$key_md5webid=md5($key_webid);
$md5webid=md5($webid);
$md5pwd=$duoduo->select('user','ddpassword','id="'.$dduser['id'].'"');

$default_pwd='';
if($key_md5webid==$md5pwd){
	$default_pwd=$key_webid;
}
if($md5webid==$md5pwd){
	$default_pwd=$webid;
}

$sign=0;
if($webset['sign']['open']==1){
	$todaytime=strtotime(date('Y-m-d 00:00:00'));
	if($dduser['signtime']<$todaytime){
		$sign=1;
	}
	else{
		$sign=0;
	}
}

if($app_show==1){
    $apilogin_id=$duoduo->select('apilogin','id','uid="'.$dduser['id'].'"');
	$apilogin_id=$apilogin_id>0?$apilogin_id:0;
}

?>
