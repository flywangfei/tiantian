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

$id=intval($_GET['id']);

$data=array('f'=>'hits','e'=>'+','v'=>1);
$duoduo->update('article',$data,'id="'.$id.'"');

$article=$duoduo->select('article','id,cid,title,`keyword`,`desc`,`addtime`,`source`,`hits`,`content`','id="'.$id.'"');
$article['content']=dd_tag_replace($article['content']);

if($article['id']<=0){
	error_html('文章不存在');
}

$last_article=$duoduo->select('article','id,title','id<"'.$id.'" order by id desc');
$next_article=$duoduo->select('article','id,title','id>"'.$id.'" order by id asc');

//热门文章
$hotnews=$duoduo->select_all('article','id,title','1=1 order by sort desc  limit 0,10');

?>