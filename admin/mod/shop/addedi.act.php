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

if(!defined('ADMIN')){
	exit('Access Denied');
}

if ($_POST['sub'] != '') {
	$id = empty ($_POST['id']) ? 0 : (int) $_POST['id'];
	unset ($_POST['id']);
	unset ($_POST['sub']);
	if ($id == 0) {
		include (DDROOT . '/comm/Taoapi.php');
		include (DDROOT . '/comm/ddTaoapi.class.php');
		$ddTaoapi = new ddTaoapi;
        
		$nick=$_POST['nick'];
		if($nick==''){jump(-2,'掌柜昵称不能为空！');}
		$shop=$ddTaoapi->taobao_shop_get($nick);
		if($shop==104){
			jump('-2', '您输入的淘宝账号不是掌柜！');
		}
		else{
			$jssdk_shops_convert['method']='taobao.taobaoke.widget.shops.convert';
			$jssdk_shops_convert['outer_code']=(int)$dduser['id'];
			$jssdk_shops_convert['user_level']=(int)$dduser['level'];
			$jssdk_shops_convert['jssdk_time']=$jssdk['jssdk_time'];
			$jssdk_shops_convert['jssdk_sign']=$jssdk['jssdk_sign'];
			$jssdk_shops_convert['seller_nicks']=$nick;
			$jssdk_shops_convert['admin']=1;
			$jssdk_shops_convert['list']=$list;
			foreach($shop as $k=>$v){
				$jssdk_shops_convert[$k]=$v;
			}
			echo '<script src="http://a.tbcdn.cn/apps/top/x/sdk.js?appkey='.$webset['taoapi']['jssdk_key'].'"></script>';
			echo '<script src="../js/jquery.js"></script>';
			echo '<script src="../js/base64.js"></script>';
			echo '<script src="../comm/jssdk.php"></script>';
			echo '<script src="../js/md5.js"></script>';
			echo '<script src="../js/fun.js"></script>';
			?>
            <script>
            <?php
			echo "shopsInfo=new Array();j=0;";
			$parame['seller_nicks']=$nick;
			php2js_array($jssdk_shops_convert,'parame');
			echo "taobaoTaobaokeWidgetShopsConvert(parame);\r\n";
			?>
			function showShopInfo(){
				if(shopsInfo['level']==-1){
					alert('店铺没有参见阿里妈妈推广或者不存在');
					clearInterval(showShopInfoProcess);
                    history.go(-1);
				}
				else if(shopsInfo['level']>0){
					alert('录入成功');
					clearInterval(showShopInfoProcess);
                    history.go(-1);
				}	
			}
			showShopInfoProcess = setInterval("showShopInfo()", 100);
            </script>
            <?php
		}
		dd_exit('数据获取中。。。');
	} else {
		$_POST['index_top']=(int)$_POST['index_top'];
		$_POST['tao_top']=(int)$_POST['tao_top'];
		$duoduo->update(MOD, $_POST, 'id="' . $id . '"');
		jump('-2', '修改成功');
	}
} else {
	$id = empty ($_GET['id']) ? 0 : (int) $_GET['id'];
	if ($id == 0) {
		$row = array ();		
	} else {
		$row = $duoduo->select(MOD, '*', 'id="' . $id . '"');
	}
}
?>