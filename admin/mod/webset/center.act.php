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

if(file_exists(DDROOT.'/update.php')){?>
<table width="700" border="0" align="center" style="border:#999999 1px solid;color:#FF0000; font-size:12px; padding-left:10px;">
<tr>
<td width="75" height="14"><img src="images/ipsecurity.gif" /></td>
<td width="613" height="26">您好，你的网站还没有升级完整，请点击 &quot;继续升级&quot; 以完成最后一步。<a href="../update.php" style="text-decoration:none; font-weight:bold; "> 继续升级</a><br>如果点击后还无法进入后台，请登录FTP删除后台目录内的update.php文件即可！</td>
</tr>
</table>
<?php exit;}?>
<?php
if(isset($_GET['zsy'])){
	$_GET['time']=TIME;
	unset($_GET['mod']);
	unset($_GET['act']);
	unset($_GET['go_mod']);
	unset($_GET['go_act']);
	$data['val']=serialize($_GET);
	$duoduo->update('webset',$data,'var="admintempdata"');
	dd_exit(date('Y-m-d H:i:s',TIME));
}

$admin_name=str_replace(DDROOT,'',ADMINROOT);
$admin_name=str_replace('/','',$admin_name);
$install=0;
$install=file_exists('../install');
$banben=include(DDROOT.'/data/banben.php');

$admin_log=$duoduo->select_all('adminlog','*','1=1 order by id desc limit 5');

//体现总额
$tixian_sum=$duoduo->sum('tixian','money','status=1');

//会员数量
$user_sum=$duoduo->count('user');

//需要支付
$need_to_pay=$duoduo->sum('user','money');

//淘宝联盟
$tao_goods_sum=$duoduo->sum('tradelist','pay_price');
$taobao_zsy=$duoduo->sum('tradelist','commission');
$taobao_tradenum=$duoduo->count('tradelist');
$tradenum_ok=$duoduo->count('tradelist','checked=2');

//拍拍联盟
$pai_goods_sum=$duoduo->sum('paipai_order','careAmount');
$paipai_zsy=$duoduo->sum('paipai_order','commission');
$paipai_tradenum=$duoduo->count('paipai_order');
$paipai_tradenum_ok=$duoduo->count('paipai_order','checked=2');

//商城联盟
$mall_goods_sum=$duoduo->sum('mall_order','sales','status=1');
$mall_zsy=$duoduo->sum('mall_order','commission','status=1');
$mall_tradenum=$duoduo->count('mall_order');
$mall_order_ok=$duoduo->count('mall_order','status=1');
$mall_order_no=$duoduo->count('mall_order','status=0');
$mall_no_user=$duoduo->count('mall_order','uid=0');

//待审核订单
$checked_trade_num=$duoduo->count('tradelist','checked=1');
//待回复站内信
$wait_see_msg_num=$duoduo->count('msg','see=0 and uid=0');
//待处理兑换
$wait_do_duihuan_num=$duoduo->count('duihuan','status=0');
//待处理体现
$wait_do_tixian_num=$duoduo->count('tixian','status=0');

$web_zsy=$taobao_zsy+$mall_zsy+$paipai_zsy;

$admintempdata=unserialize($duoduo->select('webset','val','var="admintempdata"'));
?>