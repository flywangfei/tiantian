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
include_once '../comm/dd.config.php';

/*$_GET=array (
  'unique_id' => '176582190',
  'create_date' => '2012-08-06 11:40:55',
  'action_id' => '255',
  'action_name' => 'Vancl凡客诚品CPS',
  'sid' => '50552',
  'wid' => '449444',
  'order_no' => '212080618419',
  'order_time' => '2012-08-06 11:34:22',
  'prod_id' => '',
  'prod_name' => '',
  'prod_count' => '1',
  'prod_money' => '228.0',
  'feed_back' => '1',
  'status' => 'R',
  'comm_type' => '0',
  'commision' => '22.8',
  'chkcode' => '3c4897b3ed4e16a7e60e516aabffd858',
  'prod_type' => '0',
  'am' => '0.0',
  'exchange_rate' => '0.0',
);*/

$get=var_export($_GET, true)."\r\n";
$dir =DDROOT.'/data/yiqifa_'.substr(md5(DDKEY),0,16).'/'. date("Y").'/'.date('md').'.php';
$get='<?php exit;?>'.$get;
create_file($dir,$get,1);

$unique_id=$_GET['unique_id']; //数据唯一编号
$action_id=$_GET['action_id']; //活动id
$action_name=$_GET['action_name'];
$order_code=$_GET['order_no']; //订单编号
$order_time=$_GET['order_time']?strtotime($_GET['order_time']):TIME; //下单时间
$product_code=trim(iconv('gbk', 'utf-8', $_GET['prod_id'])); //商品编号
if($product_code=='汇总'){ //商品数量
	$item_count=1;
}
else{
	$item_count=$_GET['prod_count'];
}
$item_price=$_GET['prod_money']; //商品单价
$sales = $item_price * $item_count; //总额
$commission=$_GET['commision']; //网站主佣金
$uid=$_GET['feed_back']; //反馈标签
$status=$_GET['status']; //订单状态
$chkcode=$_GET['chkcode']; //验证密钥   action_id+order_no+prod_money+order_time+ 站点push数据key值
$code=md5($_GET['action_id'].$_GET['order_no'].$_GET['prod_money'].$_GET['order_time'].$webset['yiqifa']['key']);
if($code!=$chkcode){
    dd_exit('err code');
}
switch($status){
    case 'R': $status=0;
	break;
	case 'A': $status=1;
	break;
	case 'F': $status=-1;
	break;
}

if(strpos($uid,'_')!==false){
    $abc=explode('_',$uid);
	$uid=$abc[0];
}
else{
	$uid=rep($uid);
}
if($uid=='null'){
	$uid=0;
}

$uid=(int)$uid;

$mall=$duoduo->select('mall','id,title,type','yiqifaid="'.$action_id.'"');
$mall_name=$mall['title']?$mall['title']:preg_replace('/cps/i','',$action_name); //如果没有
$dduser=$duoduo->select('user','id,level,tjr','id="'.$uid.'"');
$fxje=fenduan($commission,$webset['mallfxbl'],$dduser['level']);
$jifen=round($fxje*$webset['jifenbl']);
if($mall['type']==2){  //返积分
	$fxje=0;
}
if($user['tjr']>0){
	$tgyj=round($fxje*$webset['tgbl']);
}
else{
	$tgyj=0;
}

$mall_order = $duoduo->select("mall_order", "id,mall_name,status,fxje,jifen,commission,order_code,unique_id", 'unique_id="'.$unique_id.'"'); //一起发用唯一编号查
if ($mall_order['id'] == '') { //交易不存在
	$field_arr = array (
		'adid' => $action_id,
		'lm' => 3,
		'order_time' => $order_time,
		'mall_name' => $mall_name,
		'mall_id'=>(int)$mall['id'],
		'uid' => $uid,
		'order_code' => $order_code,
		'item_count' => $item_count,
		'item_price' => $item_price,
		'sales' => $sales,
		'commission' => $commission,
		'status' => $status,
		'fxje' => $fxje,
		'jifen' => $jifen,
		'tgyj' => $tgyj,
		'addtime'=>TIME,
		'unique_id'=>$unique_id
	);
	if($status==1){
	    $field_arr['qrsj']=TIME;
	}
	$insert=$duoduo->insert("mall_order", $field_arr);
	$mall_order=$field_arr;
	$mall_order['id']=$insert;
	
	if($status==1 && $insert>0){
		if($dduser['id']>0 && ($fxje>0 || $jifen>0)){
		    $duoduo->rebate($dduser,$mall_order,3);
		}
	}
    echo 1;
}
elseif($mall_order['id']>0 and $mall_order['status']==0 and $status==1){
	$mall_order['commission']=$commission;
	$mall_order['fxje']=$fxje;
	$mall_order['jifen']=$jifen;
	if($dduser['id']>0 && ($fxje>0 || $jifen>0)){
	    $duoduo->rebate($dduser,$mall_order,3);
	}
	echo 1;
}
elseif($mall_order['id']>0 and $mall_order['status']==0 and $status==-1){
	$field_arr_order=array('status'=>-1,'qrsj'=>TIME);
	$duoduo->update('mall_order', $field_arr_order, "id='".$mall_order['id']."'");
    echo 1;
}
else{
    echo 0;
}