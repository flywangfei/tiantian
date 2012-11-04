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

$total = 0;
$i = 0; //插入订单
$j = 0; //返利订单
$n = 0; //本次处理订单
$code=$_GET['code'];
$sday = $_GET['sday'] ? $_GET['sday'] : date('Ymd');
$eday = $_GET['eday'] ? $_GET['eday'] : date('Ymd');
if ($eday > date('Ymd')) {
	$eday = date('Ymd');
}
$page_no = $_GET['page_no'] ? intval($_GET['page_no']) : 1;

if(isset($_GET['show']) && authcode($_GET['show'],'DECODE')==1){
    $admin=1;
}
else{
	$admin=0;
	if(TIME-authcode($code,'DECODE',DDKEY)>60){
        PutInfo('访问超时');
	    dd_exit();
    }
}

$num = $_GET['num'] ? intval($_GET['num']) : 0;
$url = u('tao','report');
$collect = new collect;
if ($page_no == 1) {
	if(file_exists($ddTaoapi->ApiConfig->CachePath . '/taobao.taobaoke.report.get')){
	    deldir($ddTaoapi->ApiConfig->CachePath . '/taobao.taobaoke.report.get');
	}
	//刷新token
	if($webset['taobao_session_auto']==1){
		dd_get('https://oauth.taobao.com/token?client_id='.$webset['taoapi']['jssdk_key'].'&client_secret='.$webset['taoapi']['jssdk_secret'].'&grant_type=refresh_token&refresh_token='.$webset['taobao_session'],'post');
	}
}
if ($admin == 1 || $admin==0) {
	$data = $ddTaoapi->taobao_taobaoke_report_get($sday, $page_no);
	$total = $data['total'];
	$pages = ceil($total / 40);

	$data = arr_diff($data, array (
		'total'
	)); //因为返回的数组中包含个数total，需要去
	if ($total > 0) {
		foreach ($data as $row) {
		    $duoduo->do_report($row);
		    $n++;
	    }
	}
	
	$num = $n + $num;
	$msg = date('Y-m-d', strtotime($sday)) . " | 本次获取订单" . $n . '条！<br/><b style="color:red">订单获取中，不要操作浏览器！</b><br/><img src="images/wait2.gif" />';
	if ($total > 40 && $pages > $page_no) {
		$page_no++;
		$param = '&sday=' . $sday . '&eday=' . $eday . '&page_no=' . $page_no . '&num=' . $num . '&n=' . $n;
		if ($admin == 0) {
			$param .= '&code='.urlencode(authcode(TIME,'ENCODE',DDKEY));
			only_send(SITEURL.'/'.$url . $param);
		} else {
			$param .= '&show='.urlencode(authcode(1,'ENCODE'));
			$url = $url.$param;
			PutInfo($msg, $url);
		}
	}
	elseif ($pages <= $page_no && $sday < $eday) {
		$sday = date('Ymd', strtotime($sday . ' +1 day'));
		$param = '&sday=' . $sday . '&eday=' . $eday . '&page_no=1&num=' . $num;
		if ($admin == 0) {
			$param .= '&code='.urlencode(authcode(TIME,'ENCODE',DDKEY));
			only_send(SITEURL.'/'.$url . $param);
		} else {
			$param .= '&show='.urlencode(authcode(1,'ENCODE'));
			$url = $url.$param;
			PutInfo($msg, $url);
		}
	}
	else{
		if ($admin == 1) {
			$msg = "<b style='color:red'>获取订单完毕！</b><br/>共有订单" . $num . '条';
			PutInfo($msg);
		}
		else{
			//自动获取结束，无操作
		}
	}
}
?>