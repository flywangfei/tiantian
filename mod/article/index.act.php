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

$i=0;

$article_category=$duoduo->select_2_field('type','id,title','tag="article" and id<>26 and id<>27 and id<>28 order by sort desc,id desc');
foreach($article_category as $k=>$v){
	$arr=$duoduo->select_all('article','id,title,addtime',"cid='".$k."' order by sort desc,id desc limit 0,10");
	if(!empty($arr)){
		$articles[$k]=$arr;
	}
}
//热门文章
$hotnews=$duoduo->select_all('article','id,title','1="1" order by sort desc ,id desc limit 0,10');

?>