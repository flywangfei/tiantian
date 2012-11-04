<?php
$webcache = 0;

if (TIME - $webset['tao_report_time'] > 600) { //自动获取淘宝订单
	$url = SITEURL . '/index.php?mod=tao&act=report&code=' . urlencode(authcode(TIME, 'ENCODE', DDKEY));
	only_send($url);
	$duoduo->update('webset', array (
		'val' => TIME
	), 'var="tao_report_time"');
	$webcache = 1;
}

if ($webset['paipai']['open'] == 1 && TIME - $webset['paipai_report_time'] > 3600*24) { //自动获取拍拍订单
	only_send(SITEURL . '/index.php?mod=paipai&act=report&code=' . urlencode(authcode(TIME, 'ENCODE', DDKEY)));
	$duoduo->update('webset', array (
		'val' => TIME
	), 'var="paipai_report_time"');
	$webcache = 1;
}

if ($webset['taoapi']['freeze'] == 1 && $webset['taoapi']['auto_jiesuan'] > 0 && date('d') == $webset['taoapi']['auto_jiesuan']) {
	$last_month = date("Ym", strtotime("-1 month")); //上个月
	if ($last_month > $webset['taoapi']['jiesuan_date']) { //上个月的日期大于记录结算日
		$row = $duoduo->select_all('income', '*', 'date="' . $last_month . '"  order by  id asc limit 50');
		if (!empty ($row)) {
			foreach ($row as $income) {
				$data = array (
					array (
						'f' => 'money',
						'e' => '+',
						'v' => $income['money']
					),
					array (
						'f' => 'jifen',
						'e' => '+',
						'v' => $income['jifen']
					)
				);
				$duoduo->update('user', $data, 'id="' . $income['uid'] . '"');
				$duoduo->delete('income', 'id="' . $income['id'] . '"');
				$data = array (
					'date' => $last_month,
					'uid' => $income['uid'],
					'money' => $income['money'],
					'jifen' => $income['jifen']
				);
				
				$user=$duoduo->select('user','ddusername,email,mobile,mobile_test','id="'.$income['uid'].'"');
				$data['name']=$user['ddusername'];
				$data['email']=$user['email'];
				if($user['mobile_test']){
					$data['mobile']=$user['mobile'];
				}
				$duoduo->msg_insert($data, 6); //解冻通知，6号站内信
			}
		} else {
			$duoduo->update('webset', array (
				'val' => $last_month
			), 'var="jiesuan_date"');
		}
		$webcache = 1;
	}
}

if ($webset['tuan']['open'] == 1 && TIME - $webset['tuan_goods_time'] > $webset['tuan']['autoget'] * 3600) { //自动获取团购商品
	only_send(SITEURL . '/index.php?mod=tuan&act=collect&code=' . urlencode(authcode(TIME, 'ENCODE', DDKEY)));
	$duoduo->update('webset', array (
		'val' => TIME
	), 'var="tuan_goods_time"');
	$webcache = 1;
}

if (MOD == 'tuan' && $webset['tuan']['open'] == 1 && $webset['tuan']['autogdel'] == 1) { //自动删除团购过期商品
	$sql = "delete from " . BIAOTOU . "tuan_goods where edatetime<'" . TIME . "'";
	$duoduo->query($sql);
}

if ($webset['taoapi']['cache_time'] > 0 && TIME - $webset['tao_cache_time'] > $webset['taoapi']['cache_time'] * 3600) { //自动删除淘宝api缓存
	only_send(SITEURL . '/index.php?mod=cache&act=del&do=tao');
	$duoduo->update('webset', array (
		'val' => TIME
	), 'var="tao_cache_time"');
	$webcache = 1;
}

if ($webset['yiqifaapi']['open']==1 && $webset['yiqifaapi']['cache_time'] > 0 && TIME - $webset['yiqifa_cache_time'] > $webset['yiqifaapi']['cache_time'] * 3600) { //自动删除一起发api缓存
	only_send(SITEURL . '/index.php?mod=cache&act=del&do=yiqifa');
	$duoduo->update('webset', array (
		'val' => TIME
	), 'var="yiqifa_cache_time"');
	$webcache = 1;
}

if ($webcache == 1) {
	$duoduo->webset(1);
}
?>