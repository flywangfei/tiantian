<?php
/**
 * ============================================================================
 * 版权所有 2008-2012 多多网络，并保留所有权利。
 * 网站地址: http://soft.duoduo123.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/

if(!defined('ADMIN')){
	exit('Access Denied');
}

if($_POST['sub']!='' || $_GET['subm']!=''){  //$_GET['subm']表示群发全站会员的提交标记
	$page = !($_GET['page'])?'1':intval($_GET['page']);
	$pagesize=200;
	$frmnum=($page-1)*$pagesize;
	
	$name=$_POST['username'];
	$content=$_POST['content']?$_POST['content']:$_GET['content'];
	if($content==''){
		jump('-1','发送内容不能为空！');
	}
	if($name==''){
		$user_arr=$duoduo->select_all('user','id','1=1 order by id asc limit '.$frmnum.', '.$pagesize);
		if(!empty($user_arr)){
			foreach($user_arr as $i=>$row){
		    	$uid=$row['id'];
		    	$data=array('title'=>'站内消息','content'=>$content,'uid'=>$uid,'senduser'=>0,'addtime'=>date('Y-m-d H:i:s'),'see'=>0);
				$duoduo->insert('msg',$data);
			}
			PutInfo('已发送会员'.($i+1).'人<br/><br/><img src="../images/wait2.gif" />',u('msg','addedi',array('content'=>$content,'page'=>$page+1,'subm'=>1)));
		}
		else{
			PutInfo('发送完毕',u('msg','list',array('do'=>'from','uname'=>'网站客服')));
		}
	}
    elseif(strstr($name,'|')){
	    $name_arr=explode('|',$name);
		foreach($name_arr as $k=>$v){
			$uid=$duoduo->select('user','id','ddusername="'.$v.'"');
		    $data=array('title'=>'站内消息','content'=>$content,'uid'=>$uid,'senduser'=>0,'addtime'=>date('Y-m-d H:i:s'),'see'=>0);
			$duoduo->insert('msg',$data);
		}
	}
	else{
	    $uid=$duoduo->select('user','id','ddusername="'.$name.'"');
		$data=array('title'=>'站内消息','content'=>$content,'uid'=>$uid,'senduser'=>0,'addtime'=>date('Y-m-d H:i:s'),'see'=>0,'sid'=>$_POST['sid']);
		$duoduo->insert('msg',$data);
	}
	jump(u('msg','list'),'发送成功！');
}
else{
	$id=empty($_GET['id'])?0:(int)$_GET['id'];
	$sid=empty($_GET['sid'])?0:(int)$_GET['sid'];
    if($id==0){
	    $row=array();
		$name=$_GET['name'];
	}
	else{
	    $row=$duoduo->select(MOD,'*','id="'.$id.'"');
		if($row['uid']==0 && $row['see']==0){
		    $duoduo->update('msg',array('see'=>1),'id="'.$row['id'].'"');
		}
		if($row['uid']==0){
		    $msg_re=$duoduo->select_all('msg','*','sid="'.$row['id'].'" order by id asc');
		}
		//$msg_tree=$duoduo->select_all('msg','*','(uid="'.$row['uid'].'" and senduser="'.$row['senduser'].'") or (uid="'.$row['senduser'].'" and senduser="'.$row['uid'].'") order by id desc limit 10');
	}
}