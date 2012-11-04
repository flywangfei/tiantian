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

if(WEBTYPE==0){
    jump(SITEURL.'/'.u('shop','list',array('nick'=>$_GET['nick'])));
}

$pagesize=PAGESIZE;

$nick=empty($_GET['nick']) ? 'yipin520' : $_GET['nick'];
$nick=gbk2utf8($nick);
$list=(int)$_GET['list'];  //注意全局变量
$liebiao=(int)get_cookie('liebiao',0);
if($list==0){
	if($liebiao>0){
	    $list=$liebiao;
	}
	else{
	    $list=$webset['liebiao'];
	}
}
set_cookie('liebiao', $list, 12000,0);

include(DDROOT.'/mod/tao/shopinfo.act.php'); //店铺信息

if($shop['nick']==''){
	error_html('掌柜不存在！',-1,1);
}
elseif(in_array($shop['cid'],$virtual_cid)){
	error_html('该店铺无返利！',-1,1);
}

$show_parameter=array('nick'=>$nick,'list'=>$list);
$showpic_list1=u(MOD,ACT,arr_replace($show_parameter,'list',1)); //小图显示
$showpic_list2=u(MOD,ACT,arr_replace($show_parameter,'list',2)); //大图显示
unset($show_parameter['page']);

$show_page_url=u(MOD,ACT,$show_parameter);
?>