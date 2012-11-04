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

if (isset($_POST['sub']) && $_POST['sub']!='') {
	
	if(limit_ip('user_limit_ip')){
		jump(-1,54); //禁用IP
	}
	
	$username = trim($_POST['username']);
	$password = trim($_POST['password']);
	$remember = trim($_POST['remember'])?trim((int)$_POST['remember']):0;
	$md5pwd = md5($password);
	$from = trim($_POST['from']);
	
	$errorid=0;
	
	if($webset['ucenter']['open']==1){
		include DDROOT.'/comm/uc_define.php';
        include_once DDROOT.'/uc_client/client.php';
		$uc_name = iconv("utf-8", "utf-8", $username);
	    list ($ucid, $uc_name, $pwd, $email) = uc_user_login($uc_name, $password); //第一次查询用户名
		if($ucid==-1){ //如果失败在查询邮箱
		    list ($ucid, $uc_name, $pwd, $email) = uc_user_login($username, $password,2);
		}
		if($ucid>0){
		    $id=$duoduo->select('user','id','ddusername="'.$username.'"');
			if(!$id){ //不存在就插入多多
				$info['ddusername'] = $username;
				$info['ddpassword'] = $md5pwd;
				$info['email'] = $email;
			    $info['regtime'] = $sj;
	            $info['regip'] = get_client_ip();
	            $info['lastlogintime'] = $sj;
	            $info['loginnum'] = 1;
	            $info['money'] = $webset['reg_money'];
	            $info['jifen'] = $webset['reg_jifen'];
	            $info['ddpassword'] = $md5pwd;
	            $info['tjr'] = 0;
	            $info['ucid'] = $ucid;
				$info['jihuo'] = 1;
				
				$uid = $duoduo->insert('user', $info, 0); //插入会员
	            if ($uid <= 0) {
		            echo '插入会员失败'.mysql_error();
					exit;
	            }
				
				if ($webset['reg_money']>0 || $webset['reg_jifen']>0) { //注册送大于0时，发送明细和站内信
		            unset ($info);
		            $info['uid'] = $uid;
		            $info['shijian'] = 1;
		            $info['money'] = $webset['reg_money'];
		            $info['jifen'] = $webset['reg_jifen'];
		            $mingxi_id = $duoduo->mingxi_insert($info);
		            if (!$mingxi_id) {
			            echo '插入明细失败';
			            exit;
		            }
	            }
				
				$tg = round($webset['tgbl'] / $webset['fxbl'][0] * 100, 2);
	            unset($data);
	            $data['uid']=$uid;
	            $data['username']=$username;
	            $data['tg']=$tg;
	            $data['webnick']=$webset['webnick'];
				$data['email']=$email;
	            $duoduo->msg_insert($data, 1); //1号站内信
			}
		}
		else{
		    jump(-1,4);//账号密码错误
		}
	}

	$shield_arr = dd_get_cache('no_words'); //屏蔽词语

	$username_pass = reg_name($username, 3, 30, $shield_arr);
	if ($username_pass == -1) {
		jump(-1,1);  //用户名不合法
	}
	elseif ($username_pass == -2) {
		jump(-1,2);  //包含非法词汇
	}

	$password_pass = reg_password($password);
	if ($password_pass == 0) {
		jump(-1,3); //密码位数错误
	}

	$dduser = $duoduo->select('user', 'id,ddusername,email,jihuo', "(ddusername='" . $username . "' or email='" . $username . "') and ddpassword='".$md5pwd."'");
	$uid=$dduser['id'];
	if ($uid > 0) { //如果会员存在
		$id=$dduser['id'];
	    $username=$dduser['ddusername'];
		$email=$dduser['email'];
		$jihuo=$dduser['jihuo'];
		if($jihuo==0){
			jump(u('user','jihuo',array('uid'=>$id)),'您的账号需要激活！');
		}
		
	    if($remember==1){$life=3600*24*100;}
		else{$life='';}
	    user_login($uid,$md5pwd,$life); //登陆状态
		
		$set_con_arr=array(array('f'=>'ddpassword','v'=>$md5pwd),array('f'=>'lastlogintime','v'=>$sj),array('f'=>'loginnum','e'=>'+','v'=>1));
		$duoduo->update('user', $set_con_arr, 'id="' . $uid.'"');
		if($webset['ucenter']['open']==1 && $ucid>0 && AJAX==0){
			echo $ucsynlogin = uc_user_synlogin($ucid); //同步登陆代码
		}
		if($from!=''){$goto=$from;}
		else{$goto=u('user','index');}
		if(strpos($goto,'http://')===false){
	        $goto=SITEURL.'/'.$goto;
	    }
		
		if($webset['phpwind']['open']==1 && AJAX==0){
		    $user['id']=$uid;
		    $user['name']=$username;
		    $user['password']=$md5pwd;
			$user['email']=$email;
		    $user['cookietime']=$life;
	        $goto=$duoduo->phpwind($user,$goto);
	    }
		
		jump($goto);
	} 
	else {
		jump(-1,4);//账号密码错误
	}
} 
else {
	if(isset($_GET['url'])){
		$url_from=$_GET['url'];
	}
	elseif(isset($_GET['forward'])){
		$url_from=$_GET['forward'];
	}
	elseif(isset($_GET['from'])){
		$url_from=$_GET['from'];
	}
	else{
	    $url_from='';
	}
}
?>