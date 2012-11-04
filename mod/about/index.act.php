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

$id=(int)$_GET['id'];
$articles=$duoduo->select_all('article','id,title','cid=28 order by sort desc');
if($id==0){
	$id=$articles[0]['id'];
}
$article=$duoduo->select('article','title,content','id="'.$id.'"');
$article['content']=dd_tag_replace($article['content']);
?>