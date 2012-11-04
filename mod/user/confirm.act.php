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

$do = empty ($_GET['do']) ? 'tao' : $_GET['do'];

if ($do == 'tao') {
	if ($_POST['sub'] == '') {
		$id = $_GET["id"] ? intval($_GET["id"]) : 0; //订单ID
		$trade = $duoduo->select('tradelist', 'id,trade_id,item_title,fxje,pay_price,item_num', 'id="' . $id . '"');
		if (!$trade['id']) {
			jump(-1,$errorData[46]);
		}
		$trade['trade_id'] = fuzzyTradeId($trade['trade_id']);
	} 
	else {
		dd_session_start();
		$captcha=$_POST['captcha'];
		if ($captcha != $_SESSION["captcha"]) {
		    jump(-1,$errorData[5]);
		}
		$trade_id=trim($_POST['trade_id']);
		$id = $_POST["id"] ? intval($_POST["id"]) : 0; //订单ID
		$trade=$duoduo->select('tradelist','id,checked,fxje,jifen,trade_id,commission,pay_time','id="'.$id.'"');
		if($trade['checked']!=0){
		    jump(-1,$errorData[45]);
		}
		if($trade['trade_id']!=$trade_id){
		    jump(-1,$errorData[47]);
		}
		$uploadname = 'up_pic';
		$file_name=upload($uploadname);
		if(is_numeric($file_name)){
		    jump(-1,$errorData[$file_name]);
		}
		else{
			if($webset['taoapi']['trade_check']==1){ //人工审核
			    $checked=1;
				$data=array('checked'=>1,'ddjt'=>$file_name,'qrsj'=>TIME,'outer_code'=>$dduser['id'],'uid'=>$dduser['id']);
				
				$duoduo->update('tradelist',$data,'id="'.$id.'"');
			    jump(u('user','tradelist'),'确认成功，等待网站审核');
			}
			elseif($webset['taoapi']['trade_check']==0){  //自动审核
				$trade['ddjt']=$file_name;
				$trade['checked']=2;
				$duoduo->rebate($dduser,$trade,8); //8号明细，确认淘宝订单
			    jump(u('user','tradelist'),'确认成功');
			}
		}
	}
}
elseif($do=='paipai'){
	if ($_POST['sub'] == '') {
		$id = $_GET["id"] ? intval($_GET["id"]) : 0; //订单ID
		$trade = $duoduo->select('paipai_order', 'id,dealId,commName,fxje,careAmount,commNum', 'id="' . $id . '"');
		if (!$trade['id']) {
			jump(-1,$errorData[46]);
		}
		$trade['dealId'] = fuzzyTradeId($trade['dealId']);
	}
	else{
	    dd_session_start();
		$captcha=$_POST['captcha'];
		if ($captcha != $_SESSION["captcha"]) {
		    jump(-1,$errorData[5]);
		}
		$dealId=trim($_POST['dealId']);
		$id = $_POST["id"] ? intval($_POST["id"]) : 0; //订单ID
		$trade=$duoduo->select('paipai_order','*','id="'.$id.'"');
		if($trade['uid']>0){
		    jump(-1,$errorData[45]);
		}
		if($trade['dealId']!=$dealId){
		    jump(-1,$errorData[47]);
		}
		$duoduo->rebate($dduser,$trade,18);  //18号明细，确拍拍认订单
		jump(u('user','tradelist',array('do'=>'paipai')),'确认成功');
	}
}
elseif($do=='mall'){
    if ($_POST['sub'] == '') {
		$id = $_GET["id"] ? intval($_GET["id"]) : 0; //订单ID
		$trade = $duoduo->select('mall_order', '*', 'id="' . $id . '"');
		if (!$trade['id']) {
			jump(-1,$errorData[46]);
		}
		$trade['order_code'] = fuzzyTradeId($trade['order_code']);
	}
	else{
	    dd_session_start();
		$captcha=$_POST['captcha'];
		if ($captcha != $_SESSION["captcha"]) {
		    jump(-1,$errorData[5]);
		}
		$order_code=trim($_POST['order_code']);
		$id = $_POST["id"] ? intval($_POST["id"]) : 0; //订单ID
		$trade=$duoduo->select('mall_order','*','id="'.$id.'"');
		if($trade['uid']>0){
		    jump(-1,$errorData[45]);
		}
		if($trade['order_code']!=$order_code){
		    jump(-1,$errorData[47]);
		}
		if($trade['status']==1){
			$duoduo->rebate($dduser,$trade,12);  //12号明细，确认商城订单
		}
		else{
			$data=array('uid'=>$dduser['id']);
			$duoduo->update('mall_order',$data,'id="'.$id.'"');
		}
		jump(u('user','tradelist',array('do'=>'malll')),'确认成功');
	}
}
?>