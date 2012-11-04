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

$tao_area=include (DDROOT.'/data/tao_area.php');
$tao_sort=include (DDROOT.'/data/tao_list_sort.php');
$shield_cid = include (DDROOT.'/data/shield_cid.php');
$pagesize=$webset['taoapi']['pagesize'];
$q=empty($_GET['q']) ? '' : $_GET['q'];
$cid = empty($_GET['cid'])?'':intval($_GET['cid']);

if($webset['taoapi']['shield']==1 && in_array($cid,$shield_cid)){
    error_html('商品不存在',-1);
}

if($cid=='' && $q==''){$q=$webset['hotword'][0];}
$search=(int)$_GET['search'];
$page=empty($_GET['page'])?'1':(int)$_GET['page'];
$list=(int)$_GET['list'];  //注意全局变量
$liebiao=(int)get_cookie('liebiao',0);
if($list==0){
	if($liebiao>0){
	    $list=$liebiao;
	}
	else{
	    $list=$webset['liebiao'];
	}
}
set_cookie('liebiao', $list, 12000,0);

$Tapparams['keyword']=$q; 
$Tapparams['cid']=$cid;
$Tapparams['page_no']=$page;
$Tapparams['page_size']=$pagesize;
$Tapparams['sort']=$webset['taoapi']['sort']; 
$Tapparams['outer_code']=$dduser['id'];
if(BROWSER==1){ //浏览器行为，获取掌柜信息
    $Tapparams['seller']=1;
}
$Tapparams['total']=1;

$goods=$ddTaoapi->taobao_taobaoke_items_get($Tapparams);

if(!is_numeric($goods)){
    //最多显示10页
    if($goods['total']>$pagesize*10){
	    $TotalResults=10*$pagesize;
    }
    else{
	    $TotalResults=$goods['total'];
    }
    $goods=arr_diff($goods, array('total')); //因为返回的数组中包含个数total，需要去掉

	//网站头
    $itemcatsname=$Tapparams['keyword'];
    //获取商品类目信息
    if($itemcatsname==''){
	    $cat_list=$ddTaoapi->taobao_itemcat_msg($cid);
	    $itemcatsname=$cat_list['name'];
    }
    if($cat_list['parent_cid']==0){
        $item_cid=$cid;
    }
    else{
        $item_cid=$cat_list['parent_cid'];
    }
    if($item_cid>0){
        $cat_list=$ddTaoapi->taobao_itemcats($item_cid);
    }
}
else{
    error_html('商品不存在',-1,1);
}

$show_parameter=array('cid'=>$cid,'q'=>$q,'list'=>$list,'page'=>$page);
$showpic_list1=u(MOD,ACT,arr_replace($show_parameter,'list',1)); //小图显示
$showpic_list2=u(MOD,ACT,arr_replace($show_parameter,'list',2)); //大图显示
unset($show_parameter['page']);
$show_page_url=u(MOD,ACT,$show_parameter);
?>