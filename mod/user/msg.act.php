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

no_cache();    

$do=$_GET['do']?$_GET['do']:'in';
$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=10;
$page2=($page-1)*$pagesize;

if($do=='in'){
	$total = $duoduo->count('msg'," uid='".$dduser["id"]."'");
	$mgs_row=$duoduo->select_all('msg','id,senduser,content,see,addtime'," uid='".$dduser["id"]."' order by id desc limit $page2,$pagesize");
}
elseif($do=='out'){
	$total = $duoduo->count('msg'," senduser='".$dduser["id"]."'");
	$mgs_row=$duoduo->select_all('msg','id,senduser,uid,content,see,addtime'," senduser='".$dduser["id"]."' order by id desc limit $page2,$pagesize");
}
elseif($do=='del'){
	$ids=$_GET['ids'];
    foreach($ids as $id){
        if($id>0){
            $sql="delete from ".$BIAOTOU."msg where id='".$id."'";
            $duoduo->query($sql);
        }
    }
	jump('-1','删除成功');
}
elseif($do=='save_send'){
    $content=htmlspecialchars($_POST['content']);
	if($content!=''){
		$field_arr=array('title'=>'站内消息','content'=>$content,'addtime'=>$sj,'see'=>0,'uid'=>0,'senduser'=>$dduser['id']);
		$duoduo->insert('msg', $field_arr,0);
	}
	jump('-1','发送成功');
}
elseif($do=='read'){
    
}
?>