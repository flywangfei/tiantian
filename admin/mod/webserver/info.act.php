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

include (DDROOT . '/comm/Taoapi.php');
include (DDROOT . '/comm/ddTaoapi.class.php');
$beijing_time=beijing_time();
if($beijing_time==0) $beijing_time=time();

if($_POST['sub']!=''){
    $a=$beijing_time-time();
	$data=array('val'=>$a);
	$duoduo->update('webset',$data,'var="corrent_time"');
	$duoduo->webset(1);
	jump(-1,'设置完毕');
}
?>