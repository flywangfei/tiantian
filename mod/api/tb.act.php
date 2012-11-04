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

$app = $duoduo->select('api', '`key`,secret,title,code,open', 'code="'.ACT.'"');
$do=$_GET['do']?$_GET['do']:'go';
if($do=='go'){ //登陆
    $urls = 'https://oauth.taobao.com/authorize?response_type=user&client_id='.$app['key'].'&redirect_uri=http%3A%2F%2F'.URL.'%2Findex.php%3Fmod%3Dapi%26act%3Dtb%26do%3Dback';
    header("Location:".$urls);
}
elseif($do=='back'){  //回调
    $top_parameters=$_GET['top_parameters'];
	$top_sign=$_GET['top_sign'];

	if(base64_encode(md5($top_parameters.$app['secret'],true))!=$top_sign){
	    error_html('签名错误！');
	} 
	
    $top_parameters_de=base64_decode($top_parameters);
    parse_str($top_parameters_de,$b);
    $nick_taobao=$b['nick'];
	$row=$duoduo->select('apilogin','uid,webid','webname="'.$nick_taobao.'" and web="'.ACT.'"');

	if($row['uid']>0){
	    $taobao_user_id=$row['webid'];
	}
	else{
	    $taobao_user_id=dd_crc32(DDKEY.$nick_taobao);
	}

	$webname=$nick_taobao;
	if($webname==''){$webname=ACT.rand(1000,9999);}
	$webid=$taobao_user_id;
	$web=ACT;
		
	$input=array('webname'=>$webname,'webid'=>$webid,'web'=>$web);
	echo postform(SITEURL.'/'.u('api','do'),$input);
	
	/*$url='https://oauth.taobao.com/token?grant_type=authorization_code&code='.$code.'&client_id='.$app['key'].'&client_secret='.$app['secret'].'&redirect_uri=http%3A%2F%2F'.URL.'%2Findex.php%3Fmod%3Dapi%26act%3Dtb%26do%3Dback&scope=item%2Cpromotion%2Cusergrade&view=web&state=1';
	$collect=new collect;
	$collect->get($url,'post');
	$s=$collect->val;
	$row=json_decode($s,1);
	if($row['error']!=''){
	    exit($row['error_description']);
	}
	$id_taobao=$row['taobao_user_id'];
	$nick_taobao=$row['taobao_user_nick'];
	if ($id_taobao>0 || $nick_taobao!='') {
		$webname=$nick_taobao;
		if($webname==''){$webname=ACT.rand(1000,9999);}
		$webid=$id_taobao;
		$web=ACT;
		
		$input=array('webname'=>$webname,'webid'=>$webid,'web'=>$web);
		echo postform(SITEURL.'/'.u('api','do'),$input);
	}*/
}
?>