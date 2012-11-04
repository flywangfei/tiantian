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

$tao_level=include (DDROOT.'/data/tao_level.php');
$tao_area=include (DDROOT.'/data/tao_area.php');
$tao_shop=include(DDROOT.'/data/tao_shop_cid.php');
//店铺类型
$type_all=dd_get_cache('type');
$page = isset($_GET['page'])?(int)$_GET['page']:1;
$pagesize=27;
$frmnum=($page-1)*$pagesize;
$default_sreach_word='查询掌柜昵称';

if(isset($_GET['cid'])){
	$cid=$_GET['cid'];
	if(!is_numeric($cid)){
		$_GET['nick']=$cid;
		$cid=0;
	}
	else{
		$cid=(int)$cid;
	}
}
else{
	$cid=0;
}

$start_level=empty($_GET['start_level'])?'0':intval($_GET['start_level']);
$end_level=empty($_GET['end_level'])?'21':intval($_GET['end_level']);
$type=empty($_GET['type'])?'0':intval($_GET['type']);
$px=empty($_GET['px'])?'0':intval($_GET['px']);
switch($px){
	case '0':
		$sort='sort desc';
	break;
	case '1':
		$sort='level desc';
	break;
	case '2':
		$sort='level asc';
	break;
}

$nick=gbk2utf8(trim($_GET['nick']));
if($nick==$default_sreach_word){$nick='';}

$query_item = array(
	array(
        'f' => 'nick',
        'e' => 'like',
		'v' => '%'.$nick.'%'
    ),
	array(
        'f' => 'level',
        'e' => '>=',
		'v' => $start_level
    ),
	array(
        'f' => 'level',
        'e' => '<=',
		'v' => $end_level
    ),
	array(
        'f' => 'shop_click_url',
        'e' => '<>',
		'v' => ''
    ),
);

if(WEBTYPE=='0'){ //简易模式，店铺必须要有推广连接
	$query_item[]=array('f' => 'shop_click_url','e' => '<>','v' => '');
}

if($type==1){
    $query_item[]=array('f' => 'type','e' => '=','v' => 'B');
}

if($cid!=0){
    $query_item[]=array('f' => 'cid','e' => '=','v' => $cid);
}

$conditions = $duoduo->get_query_conditions($query_item);
$md5_conditions=md5($conditions);

if(isset($webset['shop_count'][$md5_conditions])){ 
	if(TIME-$webset['shop_count'][md5($conditions)]['time']>600){//店铺个数，缓存10分钟
		$total=$duoduo->count('shop',$conditions);
		$webset['shop_count'][$md5_conditions]=array('count'=>$total,'time'=>TIME);
		$data=array('val'=>serialize($webset['shop_count']));
		$duoduo->update('webset',$data,'var="shop_count"');
	}
	else{
		$total=$webset['shop_count'][$md5_conditions]['count'];
	}
}
else{
	$total=$duoduo->count('shop',$conditions);
	$webset['shop_count'][$md5_conditions]=array('count'=>$total,'time'=>TIME);
	$data=array('val'=>serialize($webset['shop_count']));
	$duoduo->update('webset',$data,'var="shop_count"');
}

$shops=$duoduo->sel_page_sql('shop','nick,type,level,shop_click_url,title,pic_path,fanxianlv,auction_count,sid',$conditions.' order by '.$sort,$frmnum,$pagesize);
if(empty($shops)){
    $c=0;
}
else{
    $c=count($shops);
}

for ($i=0;$i<$c;$i++) {
	$shops[$i]["logo"]=TAOLOGO.$shops[$i]["pic_path"];
	if($shops[$i]['type']=='B'){$shops[$i]['level']==21;}
	if($shops[$i]['level']==21){
	    $shops[$i]['onerror']='images/tbsc.gif';
		if($shops[$i]["pic_path"]=='Array'){
	        $shops[$i]["logo"]='images/tbsc.gif';
	    }
	}
	else{
	    $shops[$i]['onerror']='images/tbdp.gif';
		if($shops[$i]["pic_path"]=='Array'){
	        $shops[$i]["logo"]='images/tbdp.gif';
	    }
	}
	if(WEBTYPE=='0'){
		$shops[$i]['jump']="index.php?mod=jump&act=shop&sid=".$shops[$i]["sid"].'&url='.urlencode(base64_encode($shops[$i]["shop_click_url"])).'&pic='.urlencode(base64_encode($shops[$i]["logo"])).'&fan='.urlencode($shops[$i]["fanxianlv"]).'&name='.urlencode($shops[$i]["title"]);
	}else{
		$shops[$i]['jump']=u('tao','shop',array('nick'=>$shops[$i]["nick"]));
	}
}

if($c==0 && $cid==0 && $nick!=''){
    include(DDROOT.'/mod/tao/shopinfo.act.php'); //获取店铺信息
	if($shop!=104 && $shop['sid']>0){
	    $shops[0]=$shop;
	}
	else{
	    $shops=array();
		$no_shops=1;
	}
}

$page_num=ceil($total/$pagesize);
$page_url=u(MOD,ACT,array('cid'=>$cid,'start_level'=>$start_level,'end_level'=>$end_level,'type'=>$type,'nick'=>$nick));

$next_page=$page+1>$page_num?1:$page+1;
$next_page_url=u(MOD,ACT,array('cid'=>$cid,'start_level'=>$start_level,'end_level'=>$end_level,'type'=>$type,'nick'=>$nick,'page'=>$next_page));

$last_page=$page-1<1?1:$page-1;
$last_page_url=u(MOD,ACT,array('cid'=>$cid,'start_level'=>$start_level,'end_level'=>$end_level,'type'=>$type,'nick'=>$nick,'page'=>$last_page));
?>