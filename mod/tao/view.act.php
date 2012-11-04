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

$tao_id_arr = include (DDROOT.'/data/tao_ids.php');
$shield_cid = include (DDROOT.'/data/shield_cid.php');
$virtual_cid=include (DDROOT.'/data/virtual_cid.php');
$iid=(float)$_GET['iid'];
$q=$_GET['q'];
if(isset($_GET['promotion_endtime']) && $_GET['promotion_endtime']>0){
	$promotion_endtime=$_GET['promotion_endtime'];
	if($promotion_endtime>TIME){
		$promotion_price=$_GET['promotion_price'];
		$promotion_name=$_GET['promotion_name']?$_GET['promotion_name']:'促销打折';
	}
	else{
	    $promotion_price=0;
	}
}

$price_name='一&nbsp;口&nbsp;价';

if(reg_taobao_url($q)==1){
	$is_url=1;
	$url=$q;
	$iid=(float)get_tao_id($q,$tao_id_arr);
	if($iid==0){
		error_html('请使用标准淘宝商品网址搜索！');
	}
	if(strpos($q,'tmall.com')!==false){
		$is_mall=1;
		$price_name='<b style="color:#a91029">天猫正品</b>';
	}
	if(strpos($q,'ju.taobao.com')!==false){
		$is_ju=1;
		$price_name='<img src="images/ju-icon.png" alt="聚划算" />';
	}
}
elseif($iid==0){
	if($webset['taoapi']['s8']==1){
		$url=$ddTaoapi->taobao_taobaoke_listurl_get($q,$dduser['id']);
		$url=$goods['jump']="index.php?mod=jump&act=s8&url=".urlencode(base64_encode($url)).'&name='.urlencode($q);
	    jump($url);
	}
	else{
		error_html('直接搜索淘宝商品网址即可查询返利',5);
	}
}
$data['iid']=$iid;
$data['outer_code']=$dduser['id'];
if(WEBTYPE=='0'){ //简易模式
    $data['fields']='iid,detail_url,num_iid,title,nick,type,cid,pic_url,num,list_time,delist_time,stuff_status,location,price,post_fee,express_fee,ems_fee,has_discount,freight_payer,seller_credit_score,shop_click_url,click_url,volume,stuff_status,has_invoice,cid,auction_point';
}

$data['promotion_price']=0;

if($promotion_price>0){
	$data['promotion_price']=$promotion_price;
	$data['promotion_endtime']=$promotion_endtime;
	$data['promotion_name']=$promotion_name;
}

if($is_url==1){
	$data['all_get']=1; //商品没有返利也获取商品内容
}

$goods=$ddTaoapi->items_detail_get($data,$url);

if($goods['title']=='' || ($webset['taoapi']['shield']==1 && in_array($goods['cid'],$shield_cid))){
	error_html('商品不存在或已下架或者是违禁商品。<a target="_blank" href="http://item.taobao.com/item.htm?id='.$iid.'">去淘宝确认</a>',-1,1);
}

$jssdk_items_convert['method']='taobao.taobaoke.widget.items.convert';
$jssdk_items_convert['outer_code']=(int)$dduser['id'];
$jssdk_items_convert['user_level']=(int)$dduser['level'];
$jssdk_items_convert['num_iids']=$iid;
$jssdk_items_convert['cid']=$goods['cid'];
$jssdk_items_convert['promotion_bl']=$goods['promotion_price']==0?1:$goods['promotion_price']/$goods['price'];
$jssdk_items_convert['tmall_fxje']=(float)$goods['tmall_fxje'];
$jssdk_items_convert['ju_fxje']=(float)$goods['ju_fxje'];

$nick=$goods['nick'];

include(DDROOT.'/mod/tao/shopinfo.act.php'); //店铺信息

if(WEBTYPE==1){
    $Tapparams['cid']=$goods['cid']; //当前cid热卖商品
    $Tapparams['page_size']=6;
    $Tapparams['start_credit']='1crown';
    $Tapparams['end_credit']='5goldencrown';
    $Tapparams['start_price']='20';
    $Tapparams['end_price']='5000';
    $Tapparams['sort']='commissionNum_desc';
    $Tapparams['outer_code'] = $dduser['id'];
    $goods2=$ddTaoapi->taobao_taobaoke_items_get($Tapparams);
}

$comment_url="http://rate.taobao.com/detail_rate.htm?&auctionNumId=".$iid."&showContent=2&currentPage=1&ismore=1&siteID=7&userNumId=";
?>