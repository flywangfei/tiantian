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
if($id==0){
    jump(u('baobei','list'));
}
$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=500;
$frmnum=($page-1)*$pagesize;

$cat_arr=$webset['baobei']['cat'];
$face_img=include(DDROOT.'/data/face_img.php');
$face=include(DDROOT.'/data/face.php');
$face=include('data/face.php');

$duoduo->update('baobei',array('f'=>'hits','e'=>'+','v'=>1),'id="'.$id.'"'); //点击

$baobei=$duoduo->select('baobei as a,user as b','a.`img`,a.id,a.`hart`,a.`content`,a.`cid`,a.`uid`,a.keywords,a.addtime,a.price,a.title,a.commission,a.tao_id,a.click_url,a.hart,b.id as uid,b.ddusername,b.hart as user_hart','a.uid=b.id and a.id="'.$id.'"');
$baobei['content']=str_replace($face,$face_img,$baobei['content']);

$user['id']=$baobei['uid'];
$user['ddusername']=$baobei['ddusername'];
$user['hart']=$baobei['user_hart'];

$total=$duoduo->count('baobei',"uid='".$baobei['uid']."'");

$baobei['jump']=u('tao','view',array('iid'=>$baobei['tao_id']));
$baobei['fxje']=fenduan($baobei['commission'],$webset['fxbl'],$dduser['level']);

$comment_total=$duoduo->count('baobei_comment','baobei_id="'.$baobei['id'].'"');
$comment_arr=$duoduo->select_all('baobei_comment as a,user as b','a.*,b.ddusername','a.baobei_id="'.$baobei['id'].'" and a.uid=b.id order by id desc limit '.$frmnum.','.$pagesize);

$orther_baobei=$duoduo->select_all('baobei','id,title,img','id<>"'.$id.'" order by id desc limit 4');

if($dduser['id']<=0){
    $comment_id='noComment';
}
elseif($dduser['level']<$webset['baobei']['limit_level']){
    $comment_id='noLevelComment';
}
else{
    $comment_id='StartComment';
}

$page_url=u(MOD,ACT,array('id'=>$id));
?>