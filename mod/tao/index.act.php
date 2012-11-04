<?php //淘宝首页
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

$tag=dd_get_cache('tao_index.tag');

//幻灯片
$slides=$duoduo->select_all('slides','img,url,title','hide=0 and cid=2 order by sort asc limit 0,10');

$shops=$duoduo->select_all('shop','id,sid,pic_path,nick,level,fanxianlv,shop_click_url,title','1=1 order by tao_top desc, sort desc limit 0,7');
foreach($shops as $i=>$row){
	$shops[$i]["logo"]=TAOLOGO.$shops[$i]["pic_path"];
	$shops[$i]['fanxianlv']=fenduan($shops[$i]['fanxianlv'],$webset['fxbl'],$dduser['level']);
	if($shops[$i]['level']==21){
	    $shops[$i]['onerror']='images/tbsc.gif';
		if($shops[$i]["pic_path"]=='Array'){
	        $shops[$i]["logo"]='images/tbsc.gif';
	    }
	}
	else{
	    $shops[$i]['onerror']='images/tbdp.gif';
		if($shops[$i]["pic_path"]=='Array'){
	        $shops[$i]["logo"]='images/tbdp.gif';
	    }
	}
	$shops[$i]['jump']=u('tao','shop',array('nick'=>$shops[$i]["nick"]));
}
?>