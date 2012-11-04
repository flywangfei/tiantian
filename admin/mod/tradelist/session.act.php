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

if(!defined('ADMIN')){
	exit('Access Denied');
}

if($_POST['sub']!=''){
	if($_POST['taobao_session']==''){
		jump(-1,'淘宝session不能为空');
	}
	$data['val']=TIME;
	$duoduo->update('webset',$data,'var="taobao_session_time"');
	unset($data);
	$data['val']=$_POST['taobao_session'];
	$duoduo->update('webset',$data,'var="taobao_session"');
	
	$duoduo->set_webset('taobao_session_auto',$_POST['taobao_session_auto']);

	$duoduo->webset(1);
	jump(u('webset','center'),'保存成功');
}
else{
	if(isset($_GET['test_ssl']) && $_GET['test_ssl']==1){
		if($webset['taobao_session']==''){
			jump(-1,'请先获取淘宝授权');
		}
	
		$url='https://oauth.taobao.com/token?client_id='.$webset['taoapi']['jssdk_key'].'&client_secret='.$webset['taoapi']['jssdk_secret'].'&grant_type=refresh_token&refresh_token='.$webset['taobao_session'];
	
		$a=dd_get($url,'post');
		$a=json_decode($a,1);
		if(!is_array($a)){
			jump(-1,'不可用');
		}
		if(isset($a['error'])){
			if($a['error_description']=='refresh times limit exceed'){
				jump(-1,'自动刷新淘宝授权可用');
			}
			else{
				jump(-1,'检测失败，请从新获取淘宝授权后再检测');
			}
		}
		if(urldecode($a['taobao_user_nick'])==$webset['taobao_nick']){
			jump(-1,'自动刷新淘宝授权可用');
		}
		else{
			jump(-1,'检测失败，请核对后台淘宝账号是否正确');
		}
	}
}
?>