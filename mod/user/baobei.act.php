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

$cat_arr=$webset['baobei']['cat'];
$do=$_GET['do']?$_GET['do']:'share';
$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=5;
$frmnum=($page-1)*$pagesize;
	
if($do=='shai'){ //晒单
	$total=$duoduo->count('baobei',"uid='".$dduser['id']."' and trade_id>0");
    $baobei=$duoduo->select_all('baobei', 'id,title,img,price,commission,cid,hits,hart,click_url,tao_id', "uid='".$dduser['id']."' and trade_id>0 order by id desc limit $frmnum,$pagesize");
}
elseif($do=='share'){  //分享
	$total=$duoduo->count('baobei',"uid='".$dduser['id']."' and trade_id=0");
    $baobei=$duoduo->select_all('baobei', 'id,title,img,price,commission,cid,hits,hart,click_url,tao_id', "uid='".$dduser['id']."' and trade_id=0 order by id desc limit $frmnum,$pagesize");
}

if($dduser['level']<$webset['share']['limit_level']){
    $share_button_id='noLevel';
}
else{
    $share_button_id='startShare';
}
?>