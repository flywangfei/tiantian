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

include(DDROOT.'/comm/paipai.class.php');
$paipai_set['userId']=$webset['paipai']['userId'];
$paipai_set['fxbl']=$webset['paipaifxbl'];
$paipai_set['cache_time']=$webset['paipai']['cache_time'];
$paipai_set['errorlog']=$webset['paipai']['errorlog'];
$paipai=new paipai($dduser,$paipai_set);

$sort_arr=include(DDROOT.'/data/paipai_sort.php');
for($i=30;$i<=33;$i++){
	unset($sort_arr[$i]);
}
$property_arr=array('16'=>'免运费','512'=>'7天包退','0x20000'=>'假1赔3');

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

$q=$_GET['q']?$_GET['q']:$webset['paipai']['keyWord'];
$cid=(int)$_GET['cid'];

if(is_url($q)){
	$commId=$paipai->url2commId($q);
	if($commId!=''){
		$thegoods=$paipai->cpsCommQueryAction(array('commId'=>$commId));
		if($thegoods==102){error_html('该商品无返利',-1,1);}
		$q=$thegoods['title'];
		$list=1;
	}
	else{
		error_html('您输入的规范的拍拍网址，如：http://auction1.paipai.com/AF5AF632000000000401000013577BF3');
	}
}

$begPrice=(float)$_GET['begPrice'];
$endPrice=(float)$_GET['endPrice'];

if(isset($_GET['sort'])){
	$sort = (int)$_GET['sort'];
	if(!isset($sort_arr[$sort])) $sort=$webset['paipai']['sort'];
}
else{
	$sort=$webset['paipai']['sort'];
}
if(isset($_GET['property'])){
	$property = $_GET['property'];
	if(!isset($property_arr[$property])) $property='';
}
else{
	$property='';
}

$property=$_GET['property'];

$page=$_GET['page']?$_GET['page']:'1';
$pagesize=$webset['paipai']['pageSize'];

$parame['classId']=$cid;
$parame['keyWord']=$q;
$parame['orderStyle']=$sort;
$parame['begPrice']=$begPrice;
$parame['endPrice']=$endPrice;
$parame['property']=$property;
$parame['pageIndex']=$page;
$parame['pageSize']=$pagesize;
$goods=$paipai->cpsCommSearch($parame);
$total=$goods['total'];
unset($goods['total']);

if($total>0){
    //最多显示100页
    if($total>$pagesize*100){
	    $total=100*$pagesize;
    }
	//网站头
	if($q=='') $q='拍拍精选商品';
}
else{
    error_html('商品不存在',-1,1);
}

$show_parameter=array('cid'=>$cid,'q'=>$q,'sort'=>$sort,'property'=>$property,'begPrice'=>$begPrice,'endPrice'=>$endPrice,'list'=>$list,'page'=>$page);
$showpic_list1=u(MOD,ACT,arr_replace($show_parameter,'list',1)); //小图显示
$showpic_list2=u(MOD,ACT,arr_replace($show_parameter,'list',2)); //大图显示
unset($show_parameter['page']);
$show_page_url=u(MOD,ACT,$show_parameter);

