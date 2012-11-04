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
	
	if($duoduo->check_my_email($_POST['email'],$_POST['id'])>0){
		jump(-1,'email已被使用！');
	}
	
	if($_POST['ddpassword']!='' && $_POST['ddpassword']!=DEFAULTPWD && $webset['ucenter']['open']==1){
		include DDROOT.'/comm/uc_define.php';
		include_once DDROOT.'/uc_client/client.php';
		$uc_name=iconv("utf-8","utf-8",$_POST['ddusername']);
		$ucresult = uc_user_edit($uc_name,'',$_POST['ddpassword'],$_POST['email'],1);
		if ($ucresult == -4) {
			jump(-1,'email格式错误！');
		}
		elseif ($ucresult == -5) {
			jump(-1,'email已被使用！');
		}
		elseif ($ucresult == -6) {
			jump(-1,'email已被使用！');
		}
		elseif($ucresult<0){
			jump(-1,'未知错误！');
		}
	}
	
	$arr=array('money','jifen','level','tjr','yitixian','mobile','lasttixian');
	empty2zero($_POST,$arr);
	
	if(isset($_POST['ddpassword'])){
		if($_POST['ddpassword']=='' || $_POST['ddpassword']==DEFAULTPWD){
	    	unset($_POST['ddpassword']);
		}
		else{
	    	$_POST['ddpassword']=md5($_POST['ddpassword']);
		}
	}
	
	if(reg_time($_POST['lasttixian'])==1){
	    $_POST['lasttixian']=strtotime($_POST['lasttixian']);
	}
	else{
	    $_POST['lasttixian']=0;
	}
	
	if(isset($_POST['signtime'])){
		$_POST['signtime']=(int)strtotime($_POST['signtime']);
	}
	
    $id=empty($_POST['id'])?0:(int)$_POST['id'];
	unset($_POST['id']);
	unset($_POST['sub']);
	if($id==0){
	    $id=$duoduo->insert(MOD,$_POST);
		jump('-2','保存成功');
	}
	else{
	    $duoduo->update(MOD,$_POST,'id="'.$id.'"');
		jump('-2','修改成功');
	}
}
else{
	$id=empty($_GET['id'])?0:(int)$_GET['id'];
    if($id==0){
	    $row=array();
	}
	else{
	    $row=$duoduo->select(MOD,'*','id="'.$id.'"');
		$apiweb=$duoduo->select_all('apilogin as a,api as b','b.code,b.title','a.uid="'.$id.'" and a.web=b.code');
		foreach($apiweb as $k=>$arr){
		    $webnames='<img src="../template/'.MOBAN.'/images/login/'.$arr['code'].'_1.gif" alt="'.$arr['title'].'" /> ';
		}
		if($webset['taoapi']['freeze']==1){
			$freeze_money=$duoduo->sum('income','money','uid="'.$id.'"');
			$freeze_jifen=$duoduo->sum('income','jifen','uid="'.$id.'"');
			
			$row['live_money']=$row['money'];  //可用金额
			$row['freeze_money']=$freeze_money;  //冻结金额
			$row['money']+=$freeze_money; //总金额
			$row['live_jifen']=$row['jifen'];  //可用积分
			$row['freeze_jifen']=$freeze_jifen;  //冻结积分
			$row['jifen']+=$freeze_jifen; //总积分
			
		}
		elseif($webset['taoapi']['freeze']==2){
			$freeze=$duoduo->sum('tradelist','fxje,jifen','uid="'.$id.'" and checked=2 and qrsj>="'.strtotime("-16 day").'" and fxje>"'.$webset['taoapi']['freeze_limit'].'"');
			$freeze_money=$freeze['fxje'];
			$freeze_jifen=$freeze['jifen'];
			
			$row['live_money']=round($row['money']-$freeze_money,2);  //可用金额
			$row['freeze_money']=$freeze_money;  //冻结金额
			$row['live_jifen']=$row['jifen']-$freeze_jifen;  //可用积分
			$row['freeze_jifen']=$freeze_jifen;  //冻结积分
		}
		else{
			$row['live_money']=$row['money'];
			$row['live_jifen']=$row['jifen'];
		}
	}
}
?>