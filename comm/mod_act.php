<?php
$front_mod_arr=array('index','tao','shop','mall','user','ajax','article','fxb','jump','sitemap','huan','huodong','baobei','js','api','tuan','help','cache','about','paipai'); //前台模块
$index_act_arr=array('index'); //index模块行为
$tao_act_arr=array('index','list','view','shop','report','cache','zhe','session'); //tao模块行为
$shop_act_arr=array('list'); //shop模块行为
$mall_act_arr=array('list','view','goods'); //mall模块行为
$huan_act_arr=array('list','view'); //huan模块行为
$baobei_act_arr=array('list','view','user'); //baobei模块行为
$huodong_act_arr=array('index','list','view'); //article模块行为
$user_act_arr=array('index','register','login','exit','savereg','checklogin','tradelist','mingxi','msg','tuiguang','info','getpassword','avatar','up_avatar','baobei','huan','confirm','jihuo'); //user模块行为
$ajax_act_arr=array('check_user','check_oldpass','check_email','check_alipay','check_captcha','get_msg','check_my_email','check_my_alipay','mall_comment','huan','dhFormHtml','tixian','getTaoItem','like','userinfo','save_share','save_share_comment','sign','get_size','goods_comment','pinyin','tao_cuxiao','malls','chanet','send_mail','shop_items_get','addshop','jssdk_cache'); //ajax模块行为
$js_act_arr=array('txform'); //js模块行为
$api_act_arr=array('sina','qq','tb','do','qqweibo','kaixin'); //api模块行为
$tuan_act_arr=array('list','view','collect'); //团购模块行为
$article_act_arr=array('list','view','index'); //文章模块行为
$jump_act_arr=array('goods','shop','s8','mall','huodong','tuan','mall_goods','paipaigoods'); //跳转模块行为
$help_act_arr=array('index'); //帮助模块行为
$about_act_arr=array('index'); //帮助模块行为
$sitemap_act_arr=array('index'); //网站地图模块行为
$cache_act_arr=array('del'); //缓存模块行为
$paipai_act_arr=array('index','list','report'); //拍拍模块行为

include(DDROOT.'/comm/my_mod_act.php'); //引入自定义模块

if(!in_array($mod,$front_mod_arr)){ //模块验证
    dd_exit('miss mod!');
}	

$mod_arr_name=$mod.'_act_arr';  //行为验证
if(!in_array($act,$$mod_arr_name)){
	dd_exit('miss '.MOD.' act!');
}