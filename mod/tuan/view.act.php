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

include(DDROOT.'/mod/tuan/public.act.php');

$id=empty($_GET['id'])?0:intval($_GET['id']);

//商品数据
$goods=$duoduo->select('tuan_goods as a,mall as b','a.id,a.url,a.city,a.title,a.cid,a.mall_id,a.img,a.sdatetime,a.edatetime,a.value,a.price,a.rebate,a.bought,b.title as mall_name,b.img as mall_logo,b.id as mall_id,b.fan,b.url as mall_url','a.id="'.$id.'" and a.mall_id=b.id');

//当地团购
$state_goods=$duoduo->select_all('tuan_goods as a,mall as b','a.title,a.price,a.id,b.title as mall_name,b.fan,b.id as mall_id','a.city="'.$goods['city'].'" and a.mall_id=b.id order by a.sort desc,a.salt desc limit 0,3');

$goods['jump']='index.php?mod=jump&act=tuan&tid='.$goods['id'];