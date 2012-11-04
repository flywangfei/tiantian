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

//类型
$type_all=dd_get_cache('type');
$huan_type=$type_all['huan_goods'];
$id =(int)$_GET['id'];
$good=$duoduo->select('huan_goods','id,title,img,money,jifen,num,content,num,sdate,edate','id="'.$id.'"');
$money_dh_status=1;
$jifen_dh_status=1;
$money_dh_msg='余额兑换';
$jifen_dh_msg='积分兑换';

if($good['num']<=0){
    $money_dh_status=0;
    $jifen_dh_status=0;
    $money_dh_msg='暂无库存';
    $jifen_dh_msg='暂无库存';
}

if($dduser['id']>0){
    if($dduser['dhstate']==1){
	    $money_dh_status=0;
		$money_dh_msg='您提交的兑换申请正在处理中';
		$jifen_dh_status=0;
		$jifen_dh_msg='您提交的兑换申请正在处理中';
	}
	else{
	    if($dduser['live_money']<$good['money']){
		    $money_dh_status=0;
		    $money_dh_msg='您的余额不足';
		}
		if($dduser['live_jifen']<$good['jifen']){
		    $jifen_dh_status=0;
		    $jifen_dh_msg='您的积分不足';
		}
	}
}
?>
