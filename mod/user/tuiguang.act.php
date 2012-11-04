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

$do=$_GET['do']?$_GET['do']:'url';
$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=10;
$page2=($page-1)*$pagesize;

if($do=='list'){
    $total=$duoduo->count('user'," tjr='".$dduser["id"]."'");
	$tuiguang=$duoduo->select_all('user','id,ddusername,level,loginnum,regtime,money,yitixian'," tjr='".$dduser["id"]."' order by id desc limit $page2,$pagesize");
	
	foreach($tuiguang as $k=>$row){
		$tuiguang[$k]['yj']=round($duoduo->user_money_from_buy($row['id'])*$webset['tgbl'],2);
	}
}