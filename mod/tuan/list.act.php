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

include(DDROOT.'/mod/tuan/public.act.php');

$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=$webset['tuan']['listnum'];
$frmnum=($page-1)*$pagesize;

$mall_id=intval($_GET['mall_id']);

$cid=intval($_GET['cid']);
$sort=trim($_GET['sort']);
$q=trim($_GET['q']);

if($sort==''){
	$sort='sort';
}
elseif($sort!='edatetime' && $sort!='bought' && $sort!='price'){
    $sort='edatetime';
}
switch($sort){
    case 'edatetime':
	$sort_arr=array('edatetime'=>'时间','bought'=>'销量','price'=>'价格');
	break;
	case 'sort':
	$sort_arr=array('edatetime'=>'时间','bought'=>'销量','price'=>'价格');
	break;
	case 'bought':
	$sort_arr=array('bought'=>'销量','edatetime'=>'时间','price'=>'价格');
	break;
	case 'price':
	$sort_arr=array('price'=>'价格','edatetime'=>'时间','bought'=>'销量');
	break;
}

if($mall_id>0){
    $where_mall_id=' and a.mall_id="'.$mall_id.'"';
}
else{
    $where_mall_id='';
}

/*if($city_title!='全国'){
    $goods_num=$duoduo->count('tuan_goods','city="'.$cur_city.'"'); //如果此城市没有商品，则默认全国
    if($goods_num<1){
	    $city_id=159;
	    $city_title='全国'; //IP无对应城市，调用全国团购商
    }
}*/

if($cid>0){
    $row=$duoduo->select_all('tuan_goods as a,mall as b','a.id,a.url,a.city,a.title,a.cid,a.img,a.sdatetime,a.edatetime,a.value,a.price,a.rebate,a.bought,b.title as mall_name,b.id as mall_id,b.fan','a.edatetime>"'.TIME.'" and (a.city ="'.$city_title.'" or a.city="全国") and a.cid="'.$cid.'" '.$where_mall_id.' and a.mall_id=b.id order by a.'.$sort.' desc,a.salt desc limit '.$frmnum.','.$pagesize);//echo "<hr/>";
    $goods[$cid]=$row;
	$total=$duoduo->count('tuan_goods as a',' a.edatetime>"'.TIME.'" and (a.city ="'.$city_title.'" or a.city="全国") '.$where_mall_id.' and a.cid="'.$cid.'"');
}
else{
    foreach($tuan_cat2 as $k=>$v){
	    $limit=$webset['tuan']['shownum'];	
	    $row=$duoduo->select_all('tuan_goods as a,mall as b','a.id,a.url,a.city,a.title,a.cid,a.img,a.sdatetime,a.edatetime,a.value,a.price,a.rebate,a.bought,b.title as mall_name,b.id as mall_id,b.fan','a.edatetime>"'.TIME.'" and (a.city ="'.$city_title.'" or a.city="全国") and a.cid="'.$k.'" '.$where_mall_id.' and a.title like "%'.$q.'%" and a.mall_id=b.id order by a.'.$sort.' desc,a.salt desc limit 0,'.$limit,0);//echo "<hr/>";
        if(!empty($row)){$goods[$k]=$row;}
    }
    $total=$duoduo->count('tuan_goods as a',' a.edatetime>"'.TIME.'" '.$where_mall_id.' and (a.city ="'.$city_title.'" or a.city="全国") and a.title like "%'.$q.'%"');
}
$page_url=u(MOD,ACT,array('cid'=>$cid,'mall_id'=>$mall_id));