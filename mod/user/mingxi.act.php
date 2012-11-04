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

$mingxi_tpl=include(DDROOT.'/data/mingxi.php'); //明细结构数据
$keyword=$_GET["keyword"]; 
$do=empty($_GET['do'])?'in':$_GET['do'];
$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=10;
$page2=($page-1)*$pagesize;

if($do=='in'){
	$total = $duoduo->count('mingxi',"uid='".$dduser['id']."'");	
	$mingxi=$duoduo->select_all('mingxi','shijian,money,jifen,source,addtime',"uid='".$dduser['id']."' and (jifen>0 or money>0) order by addtime desc limit $page2,$pagesize");
}
elseif($do=='out'){
	$total = $duoduo->count('tixian',"uid='".$dduser['id']."'");	
	$mingxi=$duoduo->select_all('tixian','*',"uid='".$dduser['id']."' order by id desc limit $page2,$pagesize");
	$tixian_arr=array(0=>'<span style="color:#ff3300">提现待审核</span>',1=>'<span style="color:#009900">提现成功</span>',2=>'<span style="color:#333333">提现失败</span>');
}
elseif($do=='tui'){
	$total = $duoduo->count('mingxi',"uid='".$dduser['id']."' and shijian=13");	
	$mingxi=$duoduo->select_all('mingxi','*',"uid='".$dduser['id']."' and shijian=13 order by id desc limit $page2,$pagesize");
}
?>