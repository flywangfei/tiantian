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

function no_pay_trade($pay_time,$fxje,$freeze,$freeze_limit){
	if($freeze==2 && TIME-$pay_time<3600*24*16 && $fxje>=$freeze_limit){
		return 1;
	}
	if($freeze==1 && $fxje>=$freeze_limit){
		if(date("d")>=$webset['taoapi']['auto_jiesuan']){
			if(date('m',$pay_time)==date("m")){
				return 1;
			}
		}
		else{
			if(date('m',$pay_time)==date("m") || date('m',$pay_time)==date("m",strtotime("-1 month"))){
				return 1;
			}
		}
	}
	return 0;
}

$do=empty($_GET['do'])?'taobao':$_GET['do'];
$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=10;
$frmnum=($page-1)*$pagesize;
$cat_arr=$webset['baobei']['cat'];
$status_arr=array(0=>'未确认',1=>'确认',-1=>'无效');
if($do=='taobao'){
	$total=$duoduo->count('tradelist','uid="'.$dduser['id'].'" and checked=2');	
	$dingdan=$duoduo->left_join('tradelist as a','baobei AS b ON a.id = b.trade_id','a.id, a.item_title, a.num_iid, a.pay_price,a.fxje, a.commission,a.trade_id,a.pay_time, b.id as baobei_id',"a.uid=".$dduser['id']." and a.checked=2 order by a.id desc limit $frmnum,$pagesize");
}
elseif($do=='lost'){
	if(isset($_GET['q'])){
		$q=$_GET['q'];
	    $where=' and trade_id = "'.$q.'"';
		$total=$duoduo->count('tradelist','uid=0'.$where);
	    $dingdan=$duoduo->select_all('tradelist','id,item_title,pay_price,fxje,pay_time,trade_id','uid=0'.$where.' order by id desc limit '.$frmnum.','.$pagesize);
	}
}
elseif($do=='paipai'){
	$total=$duoduo->count('paipai_order','uid="'.$dduser['id'].'"');	
	$dingdan=$duoduo->select_all('paipai_order','*','uid="'.$dduser['id'].'" order by  id desc limit '.$frmnum.','.$pagesize);
}
elseif($do=='paipailost'){
	if(isset($_GET['q'])){
		$q=$_GET['q'];
	    $where=' and dealId = "'.$q.'"';
		$total=$duoduo->count('paipai_order','uid=0'.$where);
	    $dingdan=$duoduo->select_all('paipai_order','id,dealId,chargeTime,commNum,careAmount,commName,fxje','uid=0'.$where.' limit '.$frmnum.','.$pagesize);
	}
}
elseif($do=='mall'){
	$total=$duoduo->count('mall_order','uid="'.$dduser['id'].'"');	
	$dingdan=$duoduo->select_all('mall_order','*','uid="'.$dduser['id'].'" order by  id desc limit '.$frmnum.','.$pagesize);
}
elseif($do=='malllost'){
	if(isset($_GET['q'])){
		$q=$_GET['q'];
	    $where=' and order_code = "'.$q.'"';
		$total=$duoduo->count('mall_order','uid=0'.$where);
	    $dingdan=$duoduo->select_all('mall_order','id,mall_name,item_count,item_price,sales,fxje,order_time,order_code','uid=0'.$where.' limit '.$frmnum.','.$pagesize);
	}
}
elseif($do=='checked'){
	$total=$duoduo->count('tradelist','uid="'.$dduser['id'].'" and checked=1');
	$dingdan=$duoduo->select_all('tradelist','*','uid="'.$dduser['id'].'" and checked=1');
}
//print_r($dingdan);
?>