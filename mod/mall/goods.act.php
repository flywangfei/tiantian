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

if($webset['yiqifaapi']['open']==0){
	jump(SITEURL);
}

$shield_merchantId=$webset['yiqifaapi']['shield_merchantId'];
$shield_merchantId=explode(',',$shield_merchantId);

$q=$_GET['q']?$_GET['q']:$ddYiqifa->hotword;
$page=$_GET['page']?(int)$_GET['page']:1;
$pagesize=20;
$order=$_GET['order']?(int)$_GET['order']:1;
$start_price=$_GET['start_price']?(int)$_GET['start_price']:0;
$end_price=$_GET['end_price']?(int)$_GET['end_price']:9999999;
$merchantId=$_GET['merchantId'];

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

$goods=$ddYiqifa->product_search(array('keyword'=>$q,'page'=>$page,'rowcount'=>$pagesize,'category'=>'','merchantids'=>$merchantId,'minprice'=>$start_price,'maxprice'=>$end_price,'ordertype'=>$order),1); //获取商品

if($goods['total']>0){
    $total=$goods['total'];
    unset($goods['total']);

    foreach($goods as $k=>$row){
		if(!in_array($row['merchantId'],$shield_merchantId)){
	        $merchantId_arr[]=$row['merchantId'];
		}
    }

    if(!empty($merchantId_arr)){
		$merchantIds=implode($merchantId_arr,',');
		$merchants=$duoduo->select_2_field('mall','merchantId,fan','merchantId in ('.$merchantIds.')');
	}
    else{
	    $merchants=array();
	}

    foreach($goods as $k=>$row){
	    if(in_array($row['merchantId'],$shield_merchantId)){
		    $goods[$k]['fan']='无返利';
		}
		else{
			$goods[$k]['fan']=$merchants[$row['merchantId']]?$merchants[$row['merchantId']]:'10%';
		}
		$goods[$k]['renzheng']=$merchants[$row['merchantId']]?1:0;
	    $goods[$k]['goods_jump']='index.php?mod=jump&act=mall_goods&pic='.urlencode($goods[$k]['base64_pic']).'&name='.$goods[$k]['name_url'].'&url='.urlencode(base64_encode($row['url'])).'&price='.$row['showPrice'].'&fan='.urlencode($goods[$k]['fan']);
        $goods[$k]['mall_jump']='index.php?mod=jump&act=s8&url='.urlencode(base64_encode($row['url'])).'&name='.urlencode($row['merchantName']).'&fan='.urlencode($goods[$k]['fan']);
    }
}
else{
    error_html('商品不存在！');
}

$show_parameter=array('merchantId'=>$merchantId,'order'=>$order,'start_price'=>$start_price,'end_price'=>$end_price,'list'=>$list,'q'=>$q,'page'=>$page);

$showpic_list1=u(MOD,ACT,arr_replace($show_parameter,'list',1)); //小图显示

$showpic_list2=u(MOD,ACT,arr_replace($show_parameter,'list',2)); //大图显示

unset($show_parameter['page']);

$show_page_url=u(MOD,ACT,$show_parameter);

$start_price=$start_price==0?'':$start_price;
$end_price=$end_price==9999999?'':$end_price;