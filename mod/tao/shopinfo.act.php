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

$shop=$ddTaoapi->taobao_shop_get($nick);

if($shop==104){
}
else{
	$jssdk_shops_convert['method']='taobao.taobaoke.widget.shops.convert';
	$jssdk_shops_convert['outer_code']=(int)$dduser['id'];
	$jssdk_shops_convert['user_level']=(int)$dduser['level'];
	$jssdk_shops_convert['seller_nicks']=$nick;
	$jssdk_shops_convert['list']=(int)$list;
	foreach($shop as $k=>$v){
		$jssdk_shops_convert[$k]=$v;
	}
}

?>