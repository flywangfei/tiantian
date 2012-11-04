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

$id=$_GET['id']?intval($_GET['id']):0;
$zong_fen=0;
$pjf='0.0';
$x=0;

$fanli_type=array(1=>'金额',2=>'积分');

$huodong=$duoduo->select('huodong','*','id="'.$id.'"');
$mall=$duoduo->select('mall','id,title,url,img,cid,fan,des,renzheng,type,fuwu','id="'.$huodong['mall_id'].'"');
if($huodong['relate_id']>0){
    $jump=u('huan','view',array('hid'=>$huodong['relate_id']));
}
else{
    $jump=u('jump','huodong',array('hid'=>$id));
}

$mall_comment_total=$duoduo->count('mall_comment',"`mall_id` = '".$huodong['mall_id']."'");

if($mall_comment_total>0){
    $zong_fen=$duoduo->sum('mall_comment','fen',"mall_id='".$huodong['mall_id']."'");
    $pjf=number_format($zong_fen/$mall_comment_total,1);
    $fen=round($zong_fen/$mall_comment_total,2);
}

?>