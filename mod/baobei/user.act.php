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

$uid=$_GET['uid']?intval($_GET['uid']):0;
$cid=$_GET['cid']?intval($_GET['cid']):0;
$xs=$_GET['xs']?intval($_GET['xs']):1;
if($uid==0){
    jump(u('baobei','list'));
}

$cat_arr=$webset['baobei']['cat'];
$face_img=include(DDROOT.'/data/face_img.php');
$face=include(DDROOT.'/data/face.php');

$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=24;
$frmnum=($page-1)*$pagesize;

if($cid>0){
	$where_cid="and b.cid='".$cid."'";
}
elseif($cid==0){
	$where_cid="";
}

$user=$duoduo->select('user','ddusername,hart,id','id="'.$uid.'"');

if($xs==1){//他的宝贝
    $total=$duoduo->count('baobei',"uid='".$uid."' ".$where_cid);
    $baobei=$duoduo->select_all('baobei as a,user as b', 'a.`id`,a.`title`,a.`img`,a.`price`,a.`commission`,a.`hart`,a.`hits`,a.`content`,a.`uid`,a.addtime,b.ddusername',"a.uid='".$uid."' and a.uid=b.id ".$where_cid." order by a.id desc limit $frmnum,$pagesize");
}
elseif($xs==2){//他喜欢的宝贝
    $total=$duoduo->count('baobei_hart as a,baobei as b','a.uid="'.$uid.'" and a.baobei_id=b.id '.$where_cid);
	$baobei=$duoduo->select_all('baobei_hart as a,baobei as b,user as c','b.id,b.title,b.img,b.hart,b.hits,b.content,b.uid,c.ddusername','a.uid="'.$uid.'" and c.id="'.$uid.'" and a.baobei_id=b.id '.$where_cid.' order by b.id desc limit '.$frmnum.','.$pagesize);
}
$cur_baobei_num=count($baobei);
for($i=0;$i<$cur_baobei_num;$i++){
    $baobei[$i]['content']=str_replace($face,$face_img,$baobei[$i]['content']);
}

$page_url=u(MOD,ACT,array('uid'=>$uid,'xs'=>$xs));
?>