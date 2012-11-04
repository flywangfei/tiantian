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

$ids=$_GET['ids'];
foreach($ids as $v){
	$hart=$duoduo->select('baobei_hart','id,uid','baobei_id="'.$v.'"');
	if($hart['uid']>0){
	    $data[]=array('f'=>'hart','e'=>'-','v'=>1);
		$duoduo->delete('baobei_hart','id="'.$hart['id'].'"');
	}
	$baobei=$duoduo->Select('baobei','tao_id,jifen,uid','id="'.$v.'"');
	if($baobei['jifen']>0){
	    $data[]=array('f'=>'jifen','e'=>'-','v'=>$baobei['jifen']);
	    $duoduo->update('user',$data,'id="'.$baobei['uid'].'"');
	    unset($data);
	}
	$data=array('tao_id'=>$baobei['tao_id'],'addtime'=>TIME);
	$duoduo->insert('baobei_blacklist',$data);
}
$ids=implode($ids,',');
$re=$duoduo->delete_id_in($ids);
if($re==1){
    jump('-1','删除完成');
}
else{
    echo "error";
}
?>