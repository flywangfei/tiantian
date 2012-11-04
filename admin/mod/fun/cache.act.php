<?php
/**
 * ============================================================================
 * 版权所有 2008-2012 多多网络，并保留所有权利。
 * 网站地址: http://soft.duoduo123.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/

if(!defined('ADMIN')){
	exit('Access Denied');
}

$tao_goods=dd_get_cache('tao_goods','array');

function get_tao_goods_tag($tao_goods,$num_iid){
	foreach($tao_goods as $tag=>$row){
		foreach($row as $k=>$arr){
			if($arr['num_iid']==$num_iid){
				$a['tag']=$tag;
				$a['k']=$k;
				return $a;
			}
		}
	}
}

if(!empty($_POST)){
	$a=str_replace("'",'"',$_POST['a']);
	$a=json_decode($a,1);
	if(!empty($a)){
		foreach($a as $row){
			$row['fxje']=fenduan($row['commission'],$webset['fxbl'],0);
			$c=get_tao_goods_tag($tao_goods,$row['num_iid']);
			$b[$c['tag']][$c['k']]=$row;
			ksort($b[$c['tag']]);
		}
		dd_set_cache('tao_goods',$b,'array');
	}
	dd_exit('更新完毕');
}

//更新缓存
function del_session($dir) {
	if (!file_exists($dir)) {
		return false;
	} 
	if (!preg_match('#/data/temp/session/'.date('Ymd').'$#', $dir)) {
		if($dh = opendir($dir)){
			while ($file = readdir($dh)) {
				if ($file != "." && $file != "..") {
					$fullpath = $dir . "/" . $file;
					if (!is_dir($fullpath)) {
						unlink($fullpath);
					} else {
						del_session($fullpath);
					}
				}
			}
		closedir($dh);
		}
		if(judge_empty_dir($dir)==1){
			rmdir($dir);
			return true;
		}
		else {
			return false;
		} 
	}
}

$duoduo->webset();
define('UPDATECACHE',1);
include(ADMINROOT.'/mod/public/mod.update.php');
del_session(DDROOT.'/data/temp/session');

$a=glob(DDROOT.'/data/css/*');
foreach($a as $v){
	$b=str_replace(DDROOT.'/data/css/','',$v);
	if(preg_match('/^index_index.*/',$b)){
		if($webset['static']['index']['index'] != 1){
			unlink($v);
		}
	}
	else{
		unlink($v);
	}
}

$a=glob(DDROOT.'/data/js/*');
foreach($a as $v){
	$b=str_replace(DDROOT.'/data/js/','',$v);
	if(preg_match('/^index_index.*/',$b)){
		if($webset['static']['index']['index'] != 1){
			unlink($v);
		}
	}
	else{
		unlink($v);
	}
}

set_cookie('liebiao','',0,0);

if (isset ($webset['static']['index']['index']) && $webset['static']['index']['index'] == 1) {
	$c=dd_get(SITEURL.'/index.php');
	file_put_contents(DDROOT.'/index.html',$c);
}

PutInfo('更新缓存完毕！',-1);

if(is_array($tao_goods)){
	$num_iids='';
	foreach($tao_goods as $row){
		foreach($row as $arr){
			$num_iids.=$arr['num_iid'].',';
		}
	}
	$num_iids=preg_replace('/,$/','',$num_iids);

	$jssdk_items_convert['method']='taobao.taobaoke.widget.items.convert';
	$jssdk_items_convert['outer_code']=0;
	$jssdk_items_convert['user_level']=0;
	$jssdk_items_convert['num_iids']=$num_iids;
	$jssdk_items_convert['fields']='num_iid,title,nick,pic_url,price,click_url,commission';
	$jssdk_items_convert['promotion_bl']=1;
	?>
    <script src="http://a.tbcdn.cn/apps/top/x/sdk.js?appkey=<?=$webset['taoapi']['jssdk_key']?>"></script>
	<script src="../js/jquery.js"></script>
	<script src="../js/base64.js"></script>
	<script src="../comm/jssdk.php"></script>
	<script src="../js/md5.js"></script>
	<script src="../js/fun.js"></script>
	<script>
	items={};
	function getItems(){
		if(!isEmpty(items)){
			$.post('index.php?mod=<?=MOD?>&act=<?=ACT?>',{a:json2str(items)},function(data){
				alert(data);
				history.go(-1);
			});
			clearInterval(getItemsProcess);
		} 
	}
	getItemsProcess = setInterval("getItems()", 500);
    <?php
	php2js_array($jssdk_items_convert,'parame');
	echo "taobaoTaobaokeWidgetItemsConvert(parame);";
	?>
	</script>
    <?php
}else{
	PutInfo('更新缓存完毕！',-1);
}
?>