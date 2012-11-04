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

$select_arr=array('uid'=>'会员名','alipay'=>'支付宝');
$status2_arr['']='全部';
$status_arr=$status2_arr+$status_arr;
$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=20;
$frmnum=($page-1)*$pagesize;

if(isset($_GET['ids'])){
	foreach($_GET['ids'] as $id){
		$re=$duoduo->tixian($id,'yes');
	}
	jump(u('tixian','list',array('status'=>0)),'确认完毕');
}

if($_GET['first']==1){
    $sql='select * from (SELECT status, count(`id`) as cishu FROM `'.BIAOTOU.'tixian` group by `uid`) m where m.`status` = "0" and m.`cishu` = "1"';
    $rs = $duoduo->query($sql);
    $total = $duoduo->num_rows($rs);	
	
	$sql='select sum(money) as sum from (SELECT `id`,`status`,`money`,count(`id`) as cishu FROM `'.BIAOTOU.'tixian` group by `uid`) m where m.`status` = "0" and m.`cishu` = "1"';
	$rs = $duoduo->query($sql);
	$row = $duoduo->fetch_array($rs);
	$sum=$row['sum'];
	
    $sql='select * from (SELECT a.*,count(a.`id`) as cishu,b.ddusername FROM `'.BIAOTOU.'tixian` as a,'.BIAOTOU.'user as b where a.uid=b.id group by  a.`uid`) m where m.`status` = "0" and m.`cishu` = "1" order by m.`addtime` desc  limit '.$frmnum.','.$pagesize;
    $row = $duoduo->select2arr($sql);

	$page_arr['first'] = 1;
}
else {
	$q = $_GET['q'];
	$se = $_GET['se'];
	$status = $_GET['status'];
	$where = '1=1';

	if (isset ($status) && $status !== '') {
		$where .= ' and a.`status` = "' . $status . '"';
		$page_arr['status'] = $status;
	} else {
		unset ($status);
	}

	if ($se == 'uid') {
		$q = $duoduo->select('user', 'id', 'ddusername="' . $q . '"');
	}

	if (isset ($se) && $q != '') {
		$where .= ' and a.`' . $se . '` = "' . $q . '"';
		$page_arr['q'] = $q;
		$page_arr['se'] = $se;
	}

	$total = $duoduo->count('tixian as a,user as b', $where.' and a.uid=b.id');
	$row = $duoduo->select_all('tixian as a,user as b', 'a.*,b.ddusername', $where . ' and a.uid=b.id order by a.id desc limit ' . $frmnum . ',' . $pagesize);
	$sum=$duoduo->sum('tixian as a,user as b','a.money',$where.' and a.uid=b.id and a.status=0 order by a.id desc limit ' . $frmnum . ',' . $pagesize);
	
	if ($se == 'uid') {
		$q = $_GET['q'];
	}
}