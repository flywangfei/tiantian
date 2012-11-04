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
	$diff_arr=array('sub');
	$_POST=logout_key($_POST, $diff_arr);
	foreach($_POST as $k=>$v){
		if(is_array($v)){$v=serialize($v);}
		$data=array('val'=>$v);
	    $duoduo->update('webset',$data,'var="'.$k.'"');
	}
	
	$duoduo->webset(); //配置缓存
	jump('-1','保存成功');
	
}
else{
	$a=glob(DDROOT.'/data/yiqifa_*');
	if(!empty($a)){
        $yiqifa_status='<span style="color:#00CC00">数据接收正常</span>';
    }
    else{
        $yiqifa_status='<span style="color:#FF0000">没有收到数据</span>';
    }
	
	$a=glob(DDROOT.'/data/linktech*');
	if(!empty($a)){
        $linktech_status='<span style="color:#00CC00">数据接收正常</span>';
    }
    else{
        $linktech_status='<span style="color:#FF0000">没有收到数据</span>';
    }

    $a=glob(DDROOT.'/data/duomai*');
	if(!empty($a)){ 
        $duomai_status='<span style="color:#00CC00">数据接收正常</span>';
    }
    else{
        $duomai_status='<span style="color:#FF0000">没有收到数据</span>';
    }
	
	$a=glob(DDROOT.'/data/chanet*');
	if(!empty($a)){
        $chanet_status='<span style="color:#00CC00">数据接收正常</span>';
    }
    else{
        $chanet_status='<span style="color:#FF0000">没有收到数据</span>';
    }
}