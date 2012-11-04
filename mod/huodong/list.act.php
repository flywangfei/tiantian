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

$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=10;
$frmnum=($page-1)*$pagesize;

$q=$_GET['title'];

$total=$duoduo->count('huodong as a,mall as b','a.title like "%'.$q.'%" and a.mall_id=b.id');
$huodong=$duoduo->select_all('huodong as a,mall as b','a.id,a.sdate,a.edate,a.title,a.img,a.desc,a.mall_id,a.relate_id,b.title as mallname,b.fan,b.img as logo', "a.title like '%".$q."%' and a.mall_id=b.id order by a.sort desc,a.id desc limit $frmnum,$pagesize");

foreach($huodong as $k=>$row){
	if($row['relate_id']>0){
		$huodong[$k]['goto']=u('huan','view',array('id'=>$row['relate_id']));
	}
	else{
		$huodong[$k]['goto']=u('huodong','view',array('id'=>$row['id']));
	}
}

$page_url=u(MOD,ACT);