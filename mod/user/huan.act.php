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

$huan_status=include(DDROOT.'/data/huan.php');
$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=5;
$frmnum=($page-1)*$pagesize;
	
$total=$duoduo->count('duihuan',"uid='".$dduser['id']."'");
$huan=$duoduo->select_all('duihuan as a,huan_goods as b', 'a.*,b.title,b.img,b.money,b.jifen', "uid='".$dduser['id']."' and a.huan_goods_id=b.id order by a.id desc limit $frmnum,$pagesize");
?>