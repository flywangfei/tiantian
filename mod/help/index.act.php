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

$help_type=$duoduo->select_2_field('type','id,title','pid=1');
foreach($help_type as $k=>$v){
    $cid=$k;
	break;
}
if((int)$_GET['cid']>0){
    $cid=(int)$_GET['cid'];
}
$article=$duoduo->select_all('article','title,content,cid,id','cid="'.$cid.'" order by id asc');
foreach($article as $k=>$row){
	$article[$k]['content']=dd_tag_replace($article[$k]['content']);
}
?>