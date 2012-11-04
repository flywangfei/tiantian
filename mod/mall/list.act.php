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

$page = isset($_GET['page'])?intval($_GET['page']):1;
$pagesize=24;
$frmnum=($page-1)*$pagesize;
$mall_name=isset($_GET['q'])?trim($_GET['q']):'';
$q=isset($_GET['cid'])?$_GET['cid']:'';
$where='`title` like "%'.$mall_name.'%"';

//商城类型
$type_all=dd_get_cache('type');
$mall_type=$type_all['mall'];

if($q==''){
    $type=0;
	$thiscatname='返现商城';
}
elseif(is_numeric($q)){ //cid是数组，栏目搜索
	$type=1;
	$where="cid = '$q'";
	$thiscatname=$mall_type[$q];
}
else{ //cid不是数字 拼音首字母搜索
    if(preg_match('/^[a-zA-Z]{1}$/',$q)){
	    $type=2;
		$q=strtolower($q);
		$where='`pinyin` like "'.$q.'%"';
		$thiscatname=$q.'-返现商城';
	}
	else{
	    error_html('参数错误',-1);
	}
}

if($where==''){
	$where='edate>"'.TIME.'"';
}
else{
	$where.=' and edate>"'.TIME.'"';
}

//查找店铺数据库
$total=$duoduo->count('mall',$where);
$malls=$duoduo->select_all('mall', 'id,title,url,img,cid,fan,des,score,pjnum', "$where order by sort desc limit $frmnum,$pagesize");

?>