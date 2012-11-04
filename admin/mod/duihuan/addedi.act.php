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
    $id=empty($_POST['id'])?0:(int)$_POST['id'];
	$do=$_POST['do'];
	$row=$duoduo->select('duihuan as a,huan_goods as b','a.*,b.title ,b.array,b.auto,b.id','a.id="'.$id.'" and a.huan_goods_id=b.id');
	if((int)$row['status']!==0){
	    jump('-1','数据错误');
	}
	
	$user=$duoduo->select('user','ddusername,mobile,mobile_test','id="'.$row['uid'].'"');
	if($user['ddusername']==''){
		jump('-1','会员不存在');
	}
	
	if($row['mode']==1){
	    $row['money']=$row['spend'];
		$row['jifen']=0;
	}
	elseif($row['mode']==2){
	    $row['money']=0;
		$row['jifen']=$row['spend'];
	}
	
	$user_data=array(array('f'=>'dhstate','e'=>'=','v'=>0));
	
	if($do=='yes'){
		$row['user_mobile']=$user['mobile'];
		$row['mobile_test']=$user['mobile_test'];
		$duoduo->duihuan($row,1);
		$data=array('f'=>'status','e'=>'=','v'=>'1');
	}
	elseif($do=='no'){
		$user_data[]=array('f'=>'money','e'=>'+','v'=>$row['money']);
		$user_data[]=array('f'=>'jifen','e'=>'+','v'=>$row['jifen']);
		$msg_data=array('uid'=>$row['uid'],'why'=>$_POST['why'],'goods_title'=>$row['goods_title'],'email'=>$row['email']);
		if($row['mobile']!=$user['mobile']){
			$msg_data['mobile']=$row['mobile'];
		}
		else{
			if($user['mobile_test']==1){
				$msg_data['mobile']=$user['mobile'];
			}
		}
		$msg=$duoduo->msg_insert($msg_data,5); //兑换失败5号站内信
		$duoduo->update('huan_goods',array('f'=>'num','e'=>'+','v'=>1),'id="'.$row['id'].'"');
		$data=array('f'=>'status','e'=>'=','v'=>'2');
	}
	$duoduo->update('duihuan',$data,'id="'.$id.'"');
	$duoduo->update('user',$user_data,'id="'.$row['uid'].'"');
	jump('-2','处理完毕');
}
else{
	$id=empty($_GET['id'])?0:(int)$_GET['id'];
	$do=$_GET['do'];
    if($id==0){
	    $row=array();
	}
	else{
	    $row=$duoduo->select(MOD,'*','id="'.$id.'"');
	}
}
?>