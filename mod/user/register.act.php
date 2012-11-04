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

if($webset['yinxiangma']['open']==1){
    include(DDROOT."/api/YinXiangMaLib.php");   //印象验证码
	$yinxiangma=YinXiangMa_GetYinXiangMaWidget();
}

if(array_key_exists('web',$_POST)){
	$webname=$_POST['webname'];
	$webid=$_POST['webid'];
    $webid=authcode($webid,'DECODE',DDKEY);
	$web=$_POST['web'];
}
else{
	$webname='';
	$webid='';
	$web='';
}

if (isset($_POST['username']) && $_POST['username']!='') {
	unset($_POST['sub']);
	$tjr = (int)get_cookie("tjr");

	$captcha = trim($_POST['captcha']);
	$from = trim($_POST['from']);
	$username = trim($_POST['username']);
	$password = trim($_POST['password']);
	$md5pwd = md5($password);
	$email = trim($_POST['email']);
	$qq = trim($_POST['qq']);
	$alipay = trim($_POST['alipay']);
	$ip=get_client_ip();
	
	if(limit_ip('user_limit_ip',$ip)){
		jump(-1,54); //禁用IP
	}
	
	if($tjr>0){
		$n=$duoduo->select('user','id','id="'.$tjr.'"');
		if(!$n){
			jump(-1,57); //推荐人ID错误
		}
	}
	
	$shield_arr = dd_get_cache('no_words'); //屏蔽词语
    
	if($webset['user']['autoreg']==0){
		if($webset['yinxiangma']['open']==0 || $captcha!=''){
			if (reg_captcha($captcha)==0){
				jump(-1,5); //验证码错误
	    	}
		}
		else{
			$YinXiangMa_response = new YinXiangMaResponse(); 
        	$YinXiangMa_response=YinXiangMa_validRequest($_POST['YinXiangMa_response'],$_POST['YinXiangMa_challenge']); 
        	if($YinXiangMa_response->is_valid != "true"){ 
		    	jump(-1,5); //验证码错误
        	} 
    	}
	}

	$username_pass = reg_name($username, 3, 15, $shield_arr);
	if ($username_pass == -1) {
		jump(-1,1); //用户名不合法
	}
	elseif ($username_pass == -2) {
		jump(-1,2); //包含非法词汇
	}
	elseif ($duoduo->check_user($username) == 'false') {
		jump(-1,6); //用户名已存在
	}

	$password_pass = reg_password($password);
	if ($password_pass == 0) {
		jump(-1,3); //密码位数错误
	}

	$email_pass = reg_email($email);
	if ($email_pass == 0) {
		jump(-1,7); //邮箱格式错误
	}
	elseif ($duoduo->check_email($email) == 'false') {
		jump(-1,8); //邮箱已存在
	}

    if($webset['user']['need_qq']==1 && $webid==''){
	    $qq_pass = reg_qq($qq);
	    if ($qq_pass == 0) {
		    jump(-1,9); //QQ格式错误
	    }
	}
	
	if($webset['user']['need_alipay']==1 && $webid==''){
	    $alipay_pass = reg_alipay($alipay);
	    if ($alipay_pass == 0) {
		    jump(-1,35); //支付宝格式错误
	    }
		elseif ($duoduo->check_alipay($alipay) == 'false') {
		    jump(-1,37); //邮箱已存在
	    }
	}

	if($webset['user']['reg_between']>0){
	    $regtime=$duoduo->select('user','regtime','regip="'.$ip.'" order by id desc');
		$regtime=strtotime($regtime);
	    if($regtime>0 && TIME-$regtime<$webset['user']['reg_between']*3600){
		    jump(-1,50); //注册受限
		}
	}

	if($webset['ucenter']['open']==1){
		include DDROOT.'/comm/uc_define.php';
        include_once DDROOT.'/uc_client/client.php';
		$uc_name = iconv("utf-8", "utf-8", $username);
	    $ucid = uc_user_register($uc_name, $password, $email);
		
		if ($ucid == -1) {
		    jump(-1,1); //用户名不合法
	    }
	    elseif ($ucid == -2) {
		    jump(-1,2); //包含非法词汇
	    }
	    elseif ($ucid == -3) {
		    jump(-1,6); //用户名已存在
	    }
	    elseif ($ucid == -4) {
		   jump(-1,7); //邮箱格式错误
	    }
	    elseif ($ucid == -5) {
		    jump(-1,7); //邮箱格式错误
	    }
	    elseif ($ucid == -6) {
		    jump(-1,8); //邮箱已存在
	    }
		elseif($ucid<=0){
			jump(-1,999); //邮箱已存在
		}
	}
	else{
	    $ucid=0;
	}

	$info = arr_diff($_POST, array (
		'sub',
		'captcha',
		'from',
		'agree',
		'password_confirm',
		'password',
		'username',
		'web',
		'webid',
		'webname',
		'YinXiangMa_response',
		'YinXiangMa_challenge'
	));
	$info['regtime'] = $sj;
	$info['regip'] = $ip;
	$info['lastlogintime'] = $sj;
	$info['loginnum'] = 1;
	$info['money'] = $webset['user']['reg_money'];
	$info['jifen'] = $webset['user']['reg_jifen'];
	$info['ddpassword'] = $md5pwd;
	$info['ddusername'] = $username;
	$info['tjr'] = $tjr;
	$info['ucid'] = $ucid;
	
	if($webset['user']['jihuo']==1){ //如果需要激活，会员初始的激活状态为0
	    $info['jihuo'] = 0;
	}
	else{
	    $info['jihuo'] = 1;
	}

	$uid = $duoduo->insert('user', $info, 0); //插入会员
	if ($uid <= 0) {
		exit(mysql_error().'插入会员失败');
	}

	if($web!=''){
	    $data=array('webid'=>$webid,'webname'=>$webname,'web'=>$web,'uid'=>$uid);
		$duoduo->insert('apilogin', $data, 0);
	}

	$tg = $webset['tgbl'];
	unset($data);
	$data['uid']=$uid;
	$data['username']=$username;
	$data['tg']=$tg;
	$data['webnick']=WEBNICK;
	$data['email']=$email;
	$msg_zhuce=$duoduo->msg_insert($data, 1);//1号站内信

	if ($webset['user']['reg_money']>0 || $webset['user']['reg_jifen']>0) { //注册送大于0时，发送明细
		unset ($info);
		$info['uid'] = $uid;
		$info['shijian'] = 1;
		$info['money'] = (float)$webset['user']['reg_money'];
		$info['jifen'] = (int)$webset['user']['reg_jifen'];
		$mingxi_id = $duoduo->mingxi_insert($info);
		if (!$mingxi_id) {
			echo '插入明细失败';
			exit;
		}
	}
    
	if($webset['user']['jihuo']==1){
		jump(u('user','jihuo',array('uid'=>$uid)));
    }
	
	user_login($uid,$md5pwd);
	if($from!=''){$goto=$from;}
	else{$goto=u('user','index');}
	if(strpos($goto,'http://')===false){
	    $goto=SITEURL.'/'.$goto;
	}
	if($webset['phpwind']['open']==1){
		$user['id']=$uid;
		$user['name']=$username;
		$user['password']=$password;
		$user['email']=$email;
		$user['cookietime']=1200;
	    $goto=$duoduo->phpwind($user,$goto);
	}
	if($webset['ucenter']['open']==1 && $ucid>0 && AJAX==0){
		echo $ucsynlogin = uc_user_synlogin($ucid); //同步登陆代码
	}
	jump($goto);
} 
else {
	$apps = $duoduo->select_all('api', 'title,code', 'open=1 order by sort desc');
	
	if(isset($_GET['url'])){
		$url_from=$_GET['url'];
	}
	elseif(isset($_GET['forward'])){
		$url_from=$_GET['forward'];
	}
	else{
	    $url_from='';
	}
	
	if($webname!=''){
		$apireg=authcode($_POST['apireg'],'DECODE',DDKEY);
	    if($apireg!=1){
	        error_html('参数错误！');
	    }
		$default_name=$webname;
		if($webset['user']['autoreg']==1){
		    $default_pwd=dd_crc32(DDKEY.$webid);
		    $default_pwd2=$default_pwd;
		    $default_email=$webid.'@'.$web.'.com';
		    $default_qq=11111;
		}
	}
	else{
	    $default_name='';
	    $default_pwd='';
		$default_pwd2='';
		$default_email='';
		$default_qq='';
	}
	
	if($webset['user']['autoreg']==1 && $web!=''){
	    $auto_submit=1;
		dd_session_start();
	}
	else{
	    $auto_submit=0;
	}
	
	if(count($apps)>0){
		$app_show=1;
	}
	else{
	    $app_show=0;
	}
}
?>