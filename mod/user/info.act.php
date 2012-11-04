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

//会员信息
$do=$_GET['do']?$_GET['do']:'myinfo';

if($do=='myinfo'){
	if($_POST['sub']!=''){
		
		if($webset['ucenter']['open']==1){
			include DDROOT.'/comm/uc_define.php';
        	include_once DDROOT.'/uc_client/client.php';
			$uc_name = iconv("utf-8", "utf-8", $dduser['name']);
			$ucresult = uc_user_edit($uc_name, $_POST['old_password'], $_POST['old_password'], $_POST['email']);
			
			if ($ucresult == -1) {
				jump(-1,'密码错误！');	
			}
			elseif ($ucresult == -4) {
				jump(-1,'email格式错误！');
			}
			elseif ($ucresult == -5) {
				jump(-1,'email已被使用！');
			}
			elseif ($ucresult == -6) {
				jump(-1,'email已被使用！');
			}
		}
		
		if($duoduo->check_oldpass($_POST['old_password'],$dduser['id'])=='false'){
		    jump(-1,'密码错误！');
		}
		if(reg_email($_POST['email'])==0){
		    jump(-1,'email格式错误！');
		}
		if(reg_mobile($_POST['mobile'])==0){
		    jump(-1,'手机号码格式错误！');
		}
		if(reg_alipay($_POST['alipay']==0)){
		    jump(-1,'支付宝格式错误！');
		}
        
		if($duoduo->check_my_email($_POST['email'],$dduser['id'])>0){
		    jump(-1,'email已被使用！');
		}
		
		if($dduser['alipay']!=''){
		    unset($_POST['alipay']);
		}
		elseif($duoduo->check_my_alipay($_POST['alipay'],$dduser['id'])>0){
		    jump(-1,'支付宝已被使用！');
		}
		
		if($dduser['realname']!=''){
		    unset($_POST['realname']);
		}
		
	    $field_arr=arr_diff($_POST, array('old_password','password_confirm','sub','ddpassword'));
		$duoduo->update('user', $field_arr, 'id='.$dduser['id']);
		
		$userlogininfo=unserialize(get_cookie('userlogininfo')); 
		
	    $goto=SITEURL.'/'.u('user','info');

	    if($webset['phpwind']['open']==1){
		    $user['id']=$dduser['id'];
		    $user['name']=$dduser['name'];
		    $user['password']=$_POST['old_password'];
		    $user['email']=$_POST['email'];
	        $goto=$duoduo->phpwind($user,$goto);
	    }
		jump($goto);
	}
}
elseif($do=='apilogin'){
    $api=$duoduo->select_all('api','title,code','open=1 order by sort desc');
	$user_api=$duoduo->sel_one_arr_sql('apilogin','web','uid="'.$dduser['id'].'"');
}
elseif($do=='txpwd'){
    if($_POST['sub']!=''){
		if($_POST['tixianpwd']!=$_POST['tixianpwd_confirm']){
		    $re=json_encode(array('s'=>0,'id'=>34));
		    dd_exit($re);
		}
		if(reg_password($_POST['tixianpwd'])==0){
		    $re=json_encode(array('s'=>0,'id'=>3));
		    dd_exit($re);
		}
		elseif($duoduo->check_tixianpwd($_POST['old_tixianpwd'],$dduser['id'])=='false'){
		    $re=json_encode(array('s'=>0,'id'=>4));
		    dd_exit($re);
		}
		$field_arr['tixianpwd']=deep_jm($_POST['tixianpwd']);
		$duoduo->update('user', $field_arr, 'id='.$dduser['id']);
		$re=json_encode(array('s'=>1));
		dd_exit($re);
	}
}
elseif($do=='pwd'){
    if($_POST['sub']!=''){
		
		if($_POST['ddpwd']!=$_POST['pwd_confirm']){ //两次密码对比
		    $re=json_encode(array('s'=>0,'id'=>34));
		    dd_exit($re);
		}
		if(reg_password($_POST['ddpwd'])==0){ //密码格式
		    $re=json_encode(array('s'=>0,'id'=>3));
		    dd_exit($re);
		}

		if($duoduo->check_oldpass($_POST['old_pwd'],$dduser['id'])=='false'){
		    $re=json_encode(array('s'=>0,'id'=>4));
		    dd_exit($re);
		}
		
		if($webset['ucenter']['open']==1){
			include DDROOT.'/comm/uc_define.php';
        	include_once DDROOT.'/uc_client/client.php';
			$uc_name = iconv("utf-8", "utf-8", $username);
			$ucresult = uc_user_edit($dduser['name'], $_POST['old_pwd'], $_POST['ddpwd']);
			if($ucresult<=0){
				$re=json_encode(array('s'=>0,'id'=>4));
		    	dd_exit($re);
			}
		}
		
		$field_arr['ddpassword']=md5($_POST['ddpwd']);
		$duoduo->update('user', $field_arr, 'id='.$dduser['id']);
		user_login($dduser['id'],$field_arr['ddpassword'],$userlogininfo['ddsavetime']); //重置登陆状态
		$re=json_encode(array('s'=>1));
		dd_exit($re);
	}
}
?>