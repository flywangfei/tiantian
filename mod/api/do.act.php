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

$do=$_GET['do'];
if($do!='add' && $do!='del'){
    $do='add';
}
if($do=='del'){
    $web=$_GET['web'];
	if($web==''){error_html();}
	if($dduser['id']>0){
	    $duoduo->delete('apilogin','uid="'.$dduser['id'].'" and web="'.$web.'"');
		jump(u('user','info',array('do'=>'apilogin')));
	}
	else{
	    error_html('非法操作！');
	}
}
$webname=$_POST['webname'];
$webid=authcode($_POST['webid'],'DECODE',DDKEY);
$web=$_POST['web'];

if($webname=='' || $webid=='' || $web==''){
    error_html('缺少必要参数');
}

if(strlen($webid)>20){
	$webid=substr($webid,0,20);
}

$row=$duoduo->select('apilogin as a,user as b', 'b.id,b.ddusername,b.ddpassword,b.ucid,a.webid,a.web,a.uid,a.id as apilogin_id', 'a.uid=b.id and a.webid="'.$webid.'" and a.web="'.$web.'"');

if($dduser['id']>0){ //处于登陆状态
	if($row['id']>0){ //此登陆信息存在
		if($dduser['id']==$row['uid']){ //验证是否是自己，是自己，返回
	        jump(u('user','info',array('do'=>'apilogin')));
		}
		else{ //不是自己，更新api记录
			$data=array('uid'=>$dduser['id']);
		    $duoduo->update('apilogin',$data,'id="'.$row['apilogin_id'].'"');
			jump(u('user','info',array('do'=>'apilogin')));
		}
	}
	else{ //登陆信息不存在，插入
	    $data=array('uid'=>$dduser['id'],'webid'=>$webid,'webname'=>$webname,'web'=>$web);
		$duoduo->insert('apilogin',$data);
		jump(u('user','info',array('do'=>'apilogin')));
	}
}
else{
	if($row['id']>0){
		$set_con_arr=array(array('f'=>'lastlogintime','v'=>$sj),array('f'=>'loginnum','e'=>'+','v'=>1));
		$duoduo->update('user', $set_con_arr, 'id="' . $row['uid'].'"');
		user_login($row['uid'],$row['ddpassword']);
		if($webset['ucenter']['open']==1){
			include DDROOT.'/comm/uc_define.php';
			include_once DDROOT.'/uc_client/client.php';
			echo $ucsynlogin = uc_user_synlogin($row['ucid']); //同步登陆代码
		}
	    jump(u('user','index'));
	}
	else{
	    $input=array('webname'=>$webname,'webid'=>$webid,'web'=>$web,'apireg'=>authcode(1,'ENCODE',DDKEY));
	    echo postform(SITEURL.'/'.u('user','register'),$input);
	}
}