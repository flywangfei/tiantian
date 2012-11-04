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

//首页控制器
if($webset['static']['index']['random']==1){
	$tao_hot_page=rand(1,5);
	$pai_hot_page=rand(1,5);
	$tuan_start_num=rand(1,5)*5;
	$tao_zhe_page=rand(1,5);
}
else{
	$tao_hot_page=1;
	$pai_hot_page=1;
	$tuan_start_num=0;
	$tao_zhe_page=1;
}

//幻灯片
function dd_slides($duoduo,$num=10,$fileds='img,url,title'){
	$slides=$duoduo->select_all('slides',$fileds,'hide=0 and cid=1 order by sort desc limit 0,'.$num);
	return $slides;
}

//网站前台公告
function dd_article($duoduo,$cid,$num=4,$fileds='id,title'){
	$article=$duoduo->select_all('article',$fileds,'cid="'.$cid.'" order by sort desc,id desc limit 0,'.$num);
	return $article;
}

//淘宝店铺
function dd_shop($duoduo,$webset,$dduser,$num,$fileds='title,id,pic_path,fanxianlv,nick'){
	$shops=$duoduo->select_all('shop', $fileds, '1=1 order by index_top desc, sort desc limit '.$num);
	foreach($shops as $i=>$row){
		$row['url']=u('tao','shop',array('nick'=>$row['nick']));
		$row['fan']=$row['fanxianlv'];
		$row['img']=TAOLOGO.$row['pic_path'];
		$shops[$i]=$row;
	}
	return $shops;
}

//商城
function dd_mall($duoduo,$num,$fileds='cid,title,id,img,fan'){
	$shangcheng=$duoduo->select_all('mall',$fileds , '1=1 order by sort desc limit '.$num);
	foreach($shangcheng as $i=>$row){
		$row['url']=u('mall','view',array('id'=>$row['id']));
		$shangcheng[$i]=$row;
	}
	return $shangcheng;
}

//淘宝热卖
function dd_index_tao_goods($duoduo,$webset,$dduser,$ddTaoapi,$tao_hot_page,$num){
	if($webset['taoapi']['goods_show']==0){
		$Tapparams['keyword']=$webset['hotword'][0]; //关键字或栏目ID必填一项
    	$Tapparams['page_size']=$num;
		$Tapparams['outer_code']=$dduser['id'];
		$Tapparams['page_no']=$tao_hot_page;
    	$tao_goods=$ddTaoapi->taobao_taobaoke_items_get($Tapparams);
	}
	else{
    	$tao_goods1=$duoduo->select_all('goods','title as name,pic_url,iid,price,click_url,commission','cid=1 order by sort desc limit '.$num);
		$c=count($tao_goods1);
		foreach($tao_goods1 as $k=>$row){
        	$tao_goods1[$k]['fxje']=fenduan($row['commission'],$webset['fxbl'],$dduser['level']);
	       	$tao_goods1[$k]['gourl']=u('tao','view',array('iid'=>$row['iid']));
    	}
		if($c<5){
			$Tapparams['keyword']=$webset['hotword'][0]; //关键字或栏目ID必填一项
    		$Tapparams['page_size']=$num-$c;
    		$tao_goods2=$ddTaoapi->taobao_taobaoke_items_get($Tapparams);
		}
		else{
			$tao_goods2=array();
		}
    	$tao_goods=array_merge($tao_goods1,$tao_goods2);
	}
	$tao_goods=def('tao_hot_goods',$tao_goods,array('fxbl'=>$webset['fxbl'],'user_level'=>$dduser['level']));
	return $tao_goods;
}

function dd_paipai($paipai_set,$dduser,$pai_hot_page){
	$paipai=new paipai($dduser,$paipai_set);
	$parame['keyWord']=$paipai_set['keyWord'];
	$parame['pageIndex']=$pai_hot_page;
	$parame['pageSize']=5;
	$paipai_goods=$paipai->cpsCommSearch($parame);
	unset($paipai_goods['total']);
	return $paipai_goods;
}

//大家正在省
function dd_index_dingdan($duoduo,$webset,$dduser,$ddTaoapi,$num=10){
	$num_iids='';
	$dingdaning=$duoduo->select_all('tradelist as a,user as b','a.item_title,a.num_iid,a.fxje,a.commission_rate,a.uid,b.ddusername','a.uid=b.id and a.fxje>0 order by a.id desc limit '.$num);
	if(!empty($dingdaning)){
		foreach($dingdaning as $k=>$row){
    		$dingdaning[$k]['name']=utf_substr($row['ddusername'],4).'***';
			if(!empty($dduser)){
		    	$dingdaning[$k]['commission_rate']=fenduan($row['commission_rate'],$webset['fxbl'],$dduser['level'])*100;
			}
			$dingdaning[$k]['gourl']=u('tao','view',array('iid'=>$row['num_iid']));
			$num_iids.=$row['num_iid'].',';
		}
		$Tapparams['iids']=preg_replace('/,$/','',$num_iids);
		$Tapparams['outer_code']=$dduser['level'];
		$Tapparams['fields']='num_iid,pic_url';
		$a=$ddTaoapi->items_detail_get_iids($Tapparams);
		foreach($a as $row){
			$b[(string)$row['num_iid']]=$row['pic_url'].'_100x100.jpg';
		}

		foreach($dingdaning as $k=>$row){
			$img=$b[(string)$row['num_iid']];
			$dingdaning[$k]['img']=$img;
		}
	}
	if(count($dingdaning)<$num){ //数据不足调用默认数据
		$a=dd_get_cache('dingdan','array');
		$b=rand(0,57);
		for($i=$b;$i<=$b+$num-count($dingdaning);$i++){
			$a[$i]['gourl']=u('tao','view',array('iid'=>$a[$i]['num_iid']));
	    	$dingdaning[]=$a[$i];
		}
	}
	$dingdaning=def('dingdaning',$dingdaning);
	return $dingdaning;
}

//团购商品
function dd_tuan($duoduo,$tuan_start_num,$num){
	$tuan_goods=$duoduo->select_all('tuan_goods as a,mall as b','a.title,a.img,a.price,a.value,a.rebate,a.id,b.fan,b.title as mall_name','a.mall_id=b.id and a.edatetime>"'.TIME.'" order by a.sort desc,a.salt desc limit '.$tuan_start_num.','.$num);
	return $tuan_goods;
}

//淘宝打折
function dd_tao_zhe($tao_zhe,$ddTaoapi,$tao_zhe_page,$fxbl,$user_level){	
	$Tapparams['keyword']=$tao_zhe['keyword']; 
	$Tapparams['page_size']=5; 
	$Tapparams['page_no']=$tao_zhe_page;
	$goods=$ddTaoapi->taobao_taobaoke_items_coupon_get($Tapparams);
	$goods=def('tao_zhe_goods',$goods,array('fxbl'=>$fxbl,'user_level'=>$user_level));
	return $goods;
}

//热门分享
function dd_baobei($duoduo,$num=5,$fileds='img,title,id,hart'){
	$baobei=$duoduo->select_all('baobei',$fileds,'1=1 order by sort desc,id desc limit '.$num);
	return $baobei;
}

//友情链接
function dd_link($duoduo,$num=30,$type=0,$fileds='id,url,title'){
	if($type==1){$fileds.=',img';}
	$yqlj=$duoduo->select_all('link',$fileds,'type='.$type.' order by sort desc limit '.$num);
	return $yqlj;
}
?>