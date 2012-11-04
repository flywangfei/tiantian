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

$no_mall_url=include(DDROOT.'/data/no_mall_url.php');
$act=$_GET['act'];

if($act==''){
	jump('index');
}
if(isset($_GET['url'])){
    $url=base64_decode($_GET['url']);
}
else{
	$url='';
}
if(isset($_GET['pic'])){
    $pic=base64_decode($_GET['pic']);
}
else{
	$pic='';
}

StopAttack(array($url,$pic));

if($dduser['id']>0){
	$uid=$dduser['id'];
}
elseif(isset($_GET['dduserid'])&& $_GET['dduserid']>0){
	$uid=$_GET['dduserid'];
}
else{
	$uid=0;
}

$fanli=1;

if($uid==0){
    $api=$duoduo->select_all('api','title,code','open=1 order by sort desc');
}

switch($act){
    case 'goods':
	    $mallname="淘宝";
		$iid=(float)$_GET['iid'];
        $fan=(float)$_GET['fan'];
        $price=(float)$_GET['price'];
        $name=$_GET['name'];
		
		if(isset($_GET['promotion_endtime']) && $_GET['promotion_endtime']>0){
			$promotion_endtime=$_GET['promotion_endtime'];
			if($promotion_endtime>TIME){
				$price=$_GET['promotion_price'];
				$fan=$fan;
			}
		}
		elseif($webset['taoapi']['promotion']==1){
			$promotion_arr=$ddTaoapi->taobao_ump_promotion_get($iid,'array');
	    	if($promotion_arr['price']>0){
		    	$fan=$fan;
		    	$price=$promotion_arr['price'];
	    	}
		}

		$fan.='元';
		$iframe_url='http://item.taobao.com/item.htm?id='.$iid;
	break;
	
	case 'paipaigoods':
	    $mallname="拍拍";
		$id=$_GET['id'];
        $fan=(float)$_GET['fan'];
        $price=(float)$_GET['price'];
        $name=$_GET['name'];
		
		if($fan<=0) $fanli=0;
		$fan.='元';
		$iframe_url='http://auction1.paipai.com/'.$id;
	break;
	
	case 's8':
	    $mallname="去拿返利";
		$name=$_GET['name'];
		if($name!=''){$mallname=$name;}
		$fan=$_GET['fan'];
		$iframe_url=$url;
	break;
	case 'shop':
	    $mallname="淘宝";
		$sid=(float)$_GET['sid'];
        $fan=(float)$_GET['fan'];
        $price=(float)$_GET['price'];
        $name=$_GET['name'];
		if($fan<=0) $fanli=0;
		$fan.='%';
		//$iframe_url=$url;
		$iframe_url='http://shop'.$sid.'.taobao.com/';
		if($url==''){
		    dd_exit('miss url');
		}
		//$iframe_url='http://store.taobao.com/shop/view_shop.htm?user_number_id='.$user_number_id;
	break;
	case 'mall':
		$mid=(int)$_GET['mid'];
		$mall=$duoduo->select('mall','*','id="'.$mid.'"');

		if($mall['lm']==2){
            $url="http://click.linktech.cn/?m=".$mall['merchant']."&a=".$webset['linktech']['wzbh']."&l=99999&l_cd1=0&l_cd2=1&tu=".urlencode($mall['url'])."&u_id=0";
        }
        elseif($mall['lm']==3){
            $url=$mall['yiqifaurl'];
        }
	    elseif($mall['lm']==4){
            $url="http://c.duomai.com/track.php?sid=".$webset['duomai']['uid'].$webset['duomai']['wzbh']."&aid=".$mall['duomaiid']."&euid=0&t=".urlencode($mall['url']);
        }
	    elseif($mall['lm']==1){
            $url="http://count.chanet.com.cn/click.cgi?a=".$webset['chanet']['wzid']."&d=".$mall['chanet_draftid']."&u=0&e=";
        }
		else{
		    dd_exit('miss lm');
		}
	
	    $pic=http_pic($mall['img']);
	    $fan=$mall['fan'];
	    $mallname=$mall['title'];
	    $iframe_url=$mall['url'];
	break;
	case 'huodong':
	    $hid=$_GET['hid'];
		$mall=$duoduo->select('mall as a,huodong as b','b.url,a.title,a.fan,a.img,a.url as iframe_url','b.id="'.$hid.'" and a.id=b.mall_id');

		if(strstr($mall['url'],'http://c.duomai.com/track.php')){
	        $mall['url']=str_replace($webset['duomai']['uid'],$webset['duomai']['uid'].$webset['duomai']['wzbh'],$mall['url']);
	    }
		
		$url=$mall['url'];
	    $pic=http_pic($mall['img']);
	    $fan=$mall['fan'];
	    $mallname=$mall['title'];
	    $iframe_url=$mall['iframe_url'];
	break;
	case 'tuan':
	    $tid=(int)$_GET['tid'];
		$mall=$duoduo->select('tuan_goods as a,mall as b','a.url as iframe_url,a.title,a.img,b.merchant,b.lm,b.yiqifaurl,b.chaneturl,b.title as mall_name,b.fan,b.duomaiid','a.id="'.$tid.'" and a.mall_id=b.id');

		if($mall['lm']==2){
            $url="http://click.linktech.cn/?m=".$mall['merchant']."&a=".$webset['linktech']['wzbh']."&l=99999&l_cd1=0&l_cd2=1&tu=".urlencode($mall['iframe_url'])."&u_id=0";
        }
        elseif($mall['lm']==3){
	        $qu=strstr($mall['yiqifaurl'],'&t=');
	        $url=str_replace($qu,'&t='.$mall['iframe_url'],$mall['yiqifaurl']);
        }
	    elseif($mall['lm']==4){
            $url="http://c.duomai.com/track.php?sid=".$webset['duomai']['uid'].$webset['duomai']['wzbh']."&aid=".$mall['duomaiid']."&euid=0&t=".urlencode($mall['iframe_url']);
        }
	    elseif($mall['lm']==1){
			$qu=strstr($mall['chaneturl'],'&t=');
	        $url=str_replace($qu,'&t='.$mall['iframe_url'],$mall['chaneturl']);
            //$url="http://count.chanet.com.cn/click.cgi?a=".$webset['chanet']['wid']."&d=".$mall['chanetid']."&u=0&e=";
        }
		else{
		    dd_exit('miss lm');
		}
		
	    $pic=http_pic($mall['img']);
	    $fan=$mall['fan'];
	    $mallname=$mall['mall_name'];
	    $iframe_url=$mall['iframe_url'];
	break;
	
	case 'mall_goods':
        $fan=$_GET['fan'];
        $price=(float)$_GET['price'];
        $name=$_GET['name'];
		$mallname='商城';
	break;
}

foreach($no_mall_url as $v){
    if(strpos($iframe_url,$v)!==false){
	    $iframe_url='';
		break;
	}
}

$url=check_jump_url($url,$uid);
if($webset['login_tip']==0){
    jump($url);
}
elseif($uid>0 && $url!=''){
	jump($url);
}
?>