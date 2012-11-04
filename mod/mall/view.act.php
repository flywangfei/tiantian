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

$id=intval($_GET['id'])?intval($_GET['id']):0;
$do=$_GET['do']?$_GET['do']:'content';

$fanli_type=array(1=>'金额',2=>'积分');

if($do!='content' && $do!='huodong' && $do!='goods'){
    $do='content';
}
if($id==0){
    error_html('miss id');
}

$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=10;
$frmnum=($page-1)*$pagesize;
$zong_fen=0;
$pjf='0.0';
$x=0;
$fen=0;

//查找店铺数据库
$mall=$duoduo->select('mall','id,title,url,img,cid,fan,content,des,renzheng,merchantId,type,fuwu','id="'.$id.'"');

if($mall['id']==''){error_html('数据不存在！',-1);}

$jump='index.php?mod=jump&act=mall&mid='.$mall['id'];

if($do=='content'){
	$mall_comment=$duoduo->select_all('mall_comment as a,user as b','a.*,b.ddusername',"a.`mall_id` = '$id' and a.uid=b.id order by a.id desc limit $frmnum,$pagesize");
}
elseif($do=='huodong'){
    $total=$duoduo->count('huodong as a,mall as b','a.mall_id=b.id and a.mall_id="'.$id.'"');
    $huodong=$duoduo->select_all('huodong as a,mall as b','a.id,a.sdate,a.edate,a.title,a.img,a.desc,a.mall_id,a.relate_id,b.title as mallname,b.img as logo,b.fan', "a.mall_id=b.id and a.mall_id='".$id."' order by a.sort desc,a.id desc limit $frmnum,$pagesize");
	foreach($huodong as $k=>$row){
	    if($row['relate_id']>0){
		    $huodong[$k]['goto']=u('huan','view',array('id'=>$row['relate_id']));
		}
		else{
		    $huodong[$k]['goto']=u('huodong','view',array('id'=>$row['id']));
		}
	}
}
elseif($do=='goods'){
    $goods=$ddYiqifa->product_search(array('keyword'=>$ddYiqifa->hotword,'rowcount'=>8,'merchantids'=>$mall['merchantId'])); //获取商品
	if($goods['total']>0){
		foreach($goods as $k=>$row){
	    	$goods[$k]['fan']=$mall['fan'];
			$goods[$k]['renzheng']=1;
	    	$goods[$k]['goods_jump']='index.php?mod=jump&act=mall_goods&pic='.urlencode($goods[$k]['base64_pic']).'&name='.$goods[$k]['name_url'].'&url='.urlencode(base64_encode($row['url'])).'&price='.$row['showPrice'].'&fan='.urlencode($goods[$k]['fan']);
        	$goods[$k]['mall_jump']='index.php?mod=jump&act=s8&url='.urlencode(base64_encode($row['url'])).'&name='.urlencode($row['merchantName']).'&fan='.urlencode($goods[$k]['fan']);
   		}
		$total=$k+1;
	}
}

$mall_comment_total=$duoduo->count('mall_comment',"`mall_id` = '".$id."'");
if($mall_comment_total>0){
    $zong_fen=$duoduo->sum('mall_comment','fen',"mall_id='".$id."'");
    $pjf=number_format($zong_fen/$mall_comment_total,1);
    $fen=(float)round($zong_fen/$mall_comment_total,2);
}
$data=array('score'=>$fen,'pjnum'=>$mall_comment_total);
$duoduo->update('mall',$data,'id="'.$id.'"');

if($mall['merchantId']!=''){
    $do_arr=array('content'=>'商家介绍','goods'=>'精品推荐','huodong'=>'促销&amp;优惠');
}
else{
    $do_arr=array('content'=>'商家介绍','huodong'=>'促销&amp;优惠');
}

$page_url=u(MOD,ACT,array('id'=>$id,'do'=>$do));
?>