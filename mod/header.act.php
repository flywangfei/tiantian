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

//获取推荐人信息
if(isset($_GET["rec"])){
    if((int)$_GET["rec"]>0){
        set_cookie('tjr',(int)$_GET["rec"],3600);
    }
}

$apps = dd_get_cache('apps');
if(!empty($apps)){
	$app_show=1;
}
else{
	$app_show=0;
}

$nav=dd_get_cache('nav');

$userlogininfo=unserialize(get_cookie('userlogininfo')); 
$hcookieuid = $userlogininfo['uid']; 
$hcookiepassword = $userlogininfo['ddpassword']; 
$hcookiesavetime = $userlogininfo['ddsavetime']; 
$dduser['name'] = '';
$dduser['id'] = 0;
$dduser['level'] = 0;
if($hcookieuid>0 && $hcookiepassword<>NULL){	
	$user=$duoduo->select('user','id,ddusername,ddpassword,money,jifen,level,txstatus,dhstate,realname,qq,alipay,email,mobile,yitixian,hart,tjr,ucid,fxb,lastlogintime,signtime',"id='".$hcookieuid."' and ddpassword='".$hcookiepassword."'");
	if($user['id']>0){
	    $dduser['name'] = $user['ddusername'];
		$dduser['id'] = $user['id'];
		$dduser['ddpassword'] = $user['ddpassword'];
		$dduser['level'] = $user['level'];
		$dduser['money'] = $user['money'];
		$dduser['jifen'] = $user['jifen'];
		$dduser['qq'] = $user['qq'];
		$dduser['alipay'] = $user['alipay'];
		$dduser['txstatus'] = $user['txstatus'];
		$dduser['dhstate'] = $user['dhstate'];
		$dduser['realname'] = $user['realname'];
		$dduser['email'] = $user['email'];
		$dduser['mobile'] = $user['mobile']=='0'?'':$user['mobile'];
		$dduser['yitixian'] = $user['yitixian'];
		$dduser['hart'] = $user['hart'];
		$dduser['tjr'] = $user['tjr'];
		$dduser['ucid'] = $user['ucid'];
		$dduser['fxb'] = $user['fxb'];
		$dduser['signtime'] = $user['signtime'];
		$dduser['lastlogintime'] = $user['lastlogintime'];
		$msgnum = $duoduo->count('msg',"uid='".$dduser['id']."' and see=0");

		user_login($hcookieuid,$hcookiepassword,$hcookiesavetime);
		
		if($webset['taoapi']['freeze']==1){
			$freeze_money=$duoduo->sum('income','money','uid="'.$dduser['id'].'"');
			$freeze_jifen=$duoduo->sum('income','jifen','uid="'.$dduser['id'].'"');
			
			$dduser['live_money']=$dduser['money'];  //可用金额
			$dduser['freeze_money']=$freeze_money;  //冻结金额
			$dduser['money']+=$freeze_money; //总金额
			$dduser['live_jifen']=$dduser['jifen'];  //可用积分
			$dduser['freeze_jifen']=$freeze_jifen;  //冻结积分
			$dduser['jifen']+=$freeze_jifen; //总积分
			
		}
		elseif($webset['taoapi']['freeze']==2){
			$freeze=$duoduo->sum('tradelist','fxje,jifen','uid="'.$dduser['id'].'" and checked=2 and qrsj>="'.strtotime("-16 day").'" and fxje>"'.$webset['taoapi']['freeze_limit'].'"');
			$freeze_money=$freeze['fxje'];
			$freeze_jifen=$freeze['jifen'];
			
			$dduser['live_money']=round($dduser['money']-$freeze_money,2);  //可用金额
			$dduser['freeze_money']=$freeze_money;  //冻结金额
			$dduser['live_jifen']=$dduser['jifen']-$freeze_jifen;  //可用积分
			$dduser['freeze_jifen']=$freeze_jifen;  //冻结积分
		}
		else{
			$freeze_money=0;
			$freeze_jifen=0;
			$dduser['live_money']=$dduser['money'];
			$dduser['live_jifen']=$dduser['jifen'];
		}
    }
	else{
        set_cookie('userlogininfo','',0);
    }
}
else{
    set_cookie('userlogininfo','',0);
}
?>