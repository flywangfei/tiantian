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
define('INDEX',1);

include ('comm/dd.config.php');
include (DDROOT.'/comm/checkpostandget.php');

if($webset['gzip']==1){ //gzip输出
	ob_start('ob_gzip');
}

if($webset['webclose']==1){
	echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" /><title>".WEBNICK."网站关闭提示</title><table width=\"550\" height=\"176\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" style=\"border:1px dotted #ddd\"><tr><td colspan=\"2\" align=\"center\"><img src=\"images/alert.gif\" width=\"100\" height=\"90\" /></td><td width=\"370\" style=\"font-size:25px; font-weight:bold;\">".$webset['webclosemsg']."</td></tr></table><table width=\"550\" height=\"25\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\"><tr><td colspan=\"3\" align=\"right\">- by ".WEBNICK."</td></tr></table>";
	exit;
}

include(DDROOT.'/comm/mod_act.php');

include (DDROOT . '/comm/Taoapi.php');
include (DDROOT . '/comm/ddTaoapi.class.php');
include (DDROOT . '/mod/header.act.php');

$no_words = dd_get_cache('no_words');
$wjt_mod_act_arr=dd_get_cache('wjt');
$alias_mod_act_arr=dd_get_cache('alias');

define('TPLPATH',DDROOT.'/template/'.MOBAN);
define('TPLURL','template/'.MOBAN);

if(MOD=='tao' || MOD=='index' || MOD=='ajax' || MOD=='jump' || MOD=='shop' || MOD=='cache'){ //只在淘宝,ajax和首页模块下实例化淘宝api
    $ddTaoapi = new ddTaoapi;
	if(!empty($user)){
	    $ddTaoapi->dduser=$dduser;
	}
	$ddTaoapi->nowords=$no_words;
	$virtual_cid = include (DDROOT.'/data/virtual_cid.php');
	$ddTaoapi->virtual_cid=$virtual_cid;
	if($webset['seo']['spider_limit']==1){ //只在淘宝调用下限制蜘蛛
	    spider_limit($webset['spider']);
	}
	if(MOD=='tao' && ACT=='list' && isset($_GET['cid']) && !is_numeric($_GET['cid'])){ //list页面加密处理
	    $_GET['cid']=dd_decrypt($_GET['cid'],URLENCRYPT);
	}
	elseif(MOD=='tao' && ACT=='view' && isset($_GET['iid']) && !is_numeric($_GET['iid'])){  //view页面加密处理
	    $_GET['iid']=dd_decrypt($_GET['iid'],URLENCRYPT);
	}

	if($act=='list' || $act=='shop'){
        if($webset['searchlimit']>0){
            if(TIME-get_cookie('lastsearchtime')<=$webset['searchlimit']){
				error_html('搜索过于频繁，请'.$webset['searchlimit'].'秒后再进行搜索！');
            }
            set_cookie("lastsearchtime", TIME,10000);
        }
	}
}

if($webset['yiqifaapi']['key']!='' && (MOD=='mall' || MOD=='cache')){ //mall，cache模块实例化一起发api
	include('comm/Yiqifa.class.php');
    include('comm/ddYiqifa.class.php');
    include('comm/yiqifa.config.php');
}

if(MOD=='user'){ //user模块特别处理
	if($act=='login' || $act=='register' || $act=='getpassword' || $act=='jihuo'){
	    if($_COOKIE['userlogininfo']!=''){
            jump('index.php','您已经在登陆状态');
        }
	}
	else{
	    if($_COOKIE['userlogininfo']==''){
            jump(u('user','login'),'您还没有登陆或登录超时');
        }
	}
}

$mod_name=mod_name($mod,$act);

if(browser()!=''){ //判断浏览器，节省淘宝api
    define('BROWSER',1);
}
else{
    define('BROWSER',0);
}

if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
	define('AJAX',1);
}
else{
	define('AJAX',0);
}

if(WJT==1 && isset($_GET['q'])){
	if(is_url($_GET['q'])==0){
		$_GET['q']=gbk2utf8($_GET['q']);
	}
}

$page_tag=dd_get_cache('page_tag');
if(isset($page_tag[MOD.'/'.ACT])){
	define('PAGETAG',$page_tag[MOD.'/'.ACT]);
}
else{
	define('PAGETAG',MOD);
}

include(DDROOT . '/mod/'.$mod_name.'.act.php'); //引入功能

if (is_file(DDROOT . '/template/' . MOBAN . '/' . $mod_name . '.tpl.php')) {
	$tpl_dir_name=DDROOT . '/template/' . MOBAN . '/' . $mod_name . '.tpl.php';
	if (isset ($webset['static'][MOD][ACT]) && $webset['static'][MOD][ACT] == 1) { //如果此模块有静态设置
		if(is_file(DDROOT.'/'.$mod_name . '.html')){ //如果存在此模块静态页
			$tpl_dir_name=DDROOT.'/'.$mod_name . '.html';
		}
	}
	include ($tpl_dir_name); //引入模板
	include(DDROOT.'/comm/cron.php'); //计划任务
}

$duoduo->close();
unset ($duoduo);
unset ($ddTaoapi);
unset ($webset);
?>