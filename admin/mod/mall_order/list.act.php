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

if(!defined('ADMIN')){
	exit('Access Denied');
}

$select_arr=array('order_code'=>'订单号','uname'=>'会员名',);
$status_arr1['']='全部';
$status_arr=$status_arr1+$status_arr2;

$malls1[0]='全部';
$sql="select id,title,pinyin from ".BIAOTOU."mall order by pinyin asc";
$query=$duoduo->query($sql);
while($arr=$duoduo->fetch_array($query)){
	$malls2[$arr['id']]='('.substr($arr['pinyin'],0,1).')'.$arr['title'];
}
$malls=$malls1+$malls2;

$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=20;
$frmnum=($page-1)*$pagesize;
$q=$_GET['q'];
$mall_id=$_GET['mall_id'];
$se=$_GET['se'];
$status=$_GET['status'];

if($status==='' || !isset($_GET['status'])){
    $where=' ';
}
else{
    $where=' a.status="'.$status.'" and ';
}

if($mall_id>0){
	$where.='mall_id="'.$mall_id.'" and ';
}

if(!array_key_exists($se,$select_arr)){
    $se='order_code';
}

if($se=='uname'){
    $uid=$duoduo->select('user','id','ddusername="'.$q.'"');
	$where.='a.uid="'.$uid.'"';
}
else{
    $where.='a.`'.$se.'` like "%'.$q.'%"';
}

$total=$duoduo->count(MOD.' as a',$where);
$row=$duoduo->left_join(MOD.' as a','user AS b ON a.uid = b.id','a.*,b.ddusername as uname',$where.' order by a.id desc limit '.$frmnum.','.$pagesize);
?>