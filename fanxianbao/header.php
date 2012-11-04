<?php
define('INDEX',1);
include ('../comm/dd.config.php');
include ('../comm/checkpostandget.php');
include ('../mod/header.act.php');

define('TPLPATH',DDROOT.'/template/'.MOBAN);
define('TPLURL','template/'.MOBAN);
define('PAGETAG','fxb');
$mod='fxb';
$act='index';

if(MOD!='index' || ACT!='index'){
	dd_exit('参数错误');
}

$shoucang_code="javascript:void((function(d){var c=window.location.href;h=window.location.host;window.location.href='".SITEURL."/index.php?mod=tao&act=view&host='+h+'&q='+encodeURIComponent(c)+'&uid=".$dduser['id']."'})(document));";
?>