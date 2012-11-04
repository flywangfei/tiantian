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

$cid=(int)$_GET['cid'];
$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=12;
$frmnum=($page-1)*$pagesize;

if($cid>0){
    $where=' and cid="'.$cid.'"';
}
else{
    $where='';
}

//类型
$type_all=dd_get_cache('type');
$huan_type=$type_all['huan_goods'];

$total=$duoduo->count('huan_goods',"hide='0' and num>0 and (edate=0 or edate>'".TIME."')".$where);
$huan=$duoduo->select_all('huan_goods', 'id,img,jifen,money,title,num,sdate,edate', "hide='0' and num>0 and (edate=0 or edate>'".TIME."') ".$where." order by sort desc,id desc limit $frmnum,$pagesize");
$page_url=u(MOD,ACT,array('cid'=>$cid));
?>
