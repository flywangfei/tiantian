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

function tao_item_cat($cid,$ddTaoapi){
	$TaobaokeData=$ddTaoapi->taobao_itemcat_msg($cid);
	$parent_cid=$TaobaokeData['parent_cid'];
	global $shai_cat_id_temp;
	$shai_cat_id_temp=in_tao_cat($parent_cid);
	if($shai_cat_id!=999){
		return false;
	}
	else{
	    tao_item_cat($parent_cid,$ddTaoapi);
	}
}

switch($act){
    case 'check_user':
	    echo $duoduo->check_user($_POST['username']);
	break;
	
	case 'check_oldpass':
	    echo $duoduo->check_oldpass($_POST['oldpass'],$_POST['dduserid']);
	break;
	
	case 'check_my_email':
	    $id=$duoduo->check_my_email($_POST['email'],$_POST['dduserid']);
		if($id>0){echo 'false';}
		else{echo 'true';}
	break;
	
	case 'check_my_alipay':
	    $id=$duoduo->check_my_alipay($_POST['alipay'],$_POST['dduserid']);
		if($id>0){echo 'false';}
		else{echo 'true';}
	break;
	
	case 'check_email':
	    echo $duoduo->check_email($_POST['email']);
	break;
	
	case 'check_alipay':
	    echo $duoduo->check_alipay($_POST['alipay']);
	break;
	
	case 'check_captcha':
	    dd_session_start();
	    if($_POST['captcha']==$_SESSION["captcha"]){
	        echo 'true';
	    }
	    else{
	        echo 'false';
	    }
	break;
	
	case 'get_msg':
	    $id = $_GET['id'];
	    if($dduser['id']>0){
			$info=$duoduo->select('msg','uid,senduser,see','id="'.$id.'"');
			if($dduser['id']==$info['uid'] || $dduser['id']==$info['senduser']){
			    if($info['uid']==$dduser['id'] && $info['see']==0){
			        $data=array('see'=>1);
			        $duoduo->update('msg',$data,'id="'.$id.'"');
			    }
	            echo $msg='<p style=" line-height:20px;">'.$duoduo->select('msg','content','id="'.$id.'"',2).'</p>';
			}
			else{
			    $re=json_encode(array('s'=>0,'id'=>10));
		        echo $re;
			}
	    }
		else{
		    $re=json_encode(array('s'=>0,'id'=>10));
		    echo $re;
		}
	break;
	
	case 'userinfo':
	    if($dduser['id']>0){
			if($msgnum==0){ 
	            $msgsrc="<img src=\"template/".MOBAN."/images/msg1.gif\" border=\"0\" alt=\"短消息\" />";
            }else{
	            $msgsrc="<img src=\"template/".MOBAN."/images/msg0.gif\" border=\"0\" alt=\"您有新的短消息\" /> (".$msgnum.")";
            }
			$userinfo=array('name'=>$dduser['name'],'id'=>$dduser['id'],'money'=>$dduser['money'],'jifen'=>$dduser['jifen'],'level'=>$dduser['level'],'msgsrc'=>$msgsrc,'avatar'=>a($dduser['id']));
			$re=array('s'=>1,'user'=>$userinfo);
		    echo json_encode($re);
		}
		else{
		    $re=array('s'=>0);
		    echo json_encode($re);
		}
	break;
	
	case 'tixian':
	    $data=array();
		$alipay=$_POST['alipay'];
		$money=(float)$_POST['money'];
		$realname=htmlspecialchars($_POST['realname']);
		$remark=htmlspecialchars($_POST['remark']);
		$mobile=(float)$_POST['mobile'];
		$ddpassword=$_POST['ddpassword'];
	    if($dduser['id']==''){
			$re=json_encode(array('s'=>0,'id'=>10));
		    echo $re;continue;
		}
		if($alipay!='' && reg_alipay($alipay)==0){
		    $re=json_encode(array('s'=>0,'id'=>35));
		    echo $re;continue;
		}
		if($mobile!=0 && reg_mobile($mobile)==0){
		    $re=json_encode(array('s'=>0,'id'=>36));
		    echo $re;continue;
		}
	    $user=$duoduo->select('user','money,txstatus,ddpassword,alipay,realname,mobile','id="'.$dduser['id'].'"');
		if($user['txstatus']==1){
		    $re=json_encode(array('s'=>0,'id'=>38));
		    echo $re;continue;
		}
		if(($money>$dduser['live_money'] || $money<$webset['tixian_limit']) || ($webset['txxz']>0 && $money%$webset['txxz']!=0)){
		    $re=json_encode(array('s'=>0,'id'=>42));
		    echo $re;continue;
		}
		if($user['alipay']=='' && $alipay==''){
		    $re=json_encode(array('s'=>0,'id'=>39));
		    echo $re;continue;
		}
		if($post['alipay']=='' && $alipay!=''){
			$data[]=array('f'=>'alipay','v'=>$alipay);
		}
		if($user['realname']=='' && $realname==''){
		    $re=json_encode(array('s'=>0,'id'=>40));
		    echo $re;continue;
		}
		if($user['realname']=='' && $realname!=''){
			$data[]=array('f'=>'realname','v'=>$realname);
		}
		if($user['mobile']==0 && $mobile!=''){
			$data[]=array('f'=>'mobile','v'=>$mobile);
		}
		if(reg_password($ddpassword)==0){
		    $re=json_encode(array('s'=>0,'id'=>3));
		    echo $re;continue;
		}
		if($user['ddpassword']!=md5($ddpassword)){
			$re=json_encode(array('s'=>0,'id'=>41));
		    echo $re;continue;
		}

		$alipay=$user['alipay']?$user['alipay']:$alipay;
		$realname=$user['realname']?$user['realname']:$realname;
		
		$data[]=array('f'=>'txstatus','v'=>1);
		$data[]=array('f'=>'money','e'=>'-','v'=>$money);
		$data[]=array('f'=>'lasttixian','e'=>'=','v'=>TIME);
		$duoduo->update('user',$data,'id="'.$dduser['id'].'"');
		unset($data);
		$data=array('uid'=>$dduser['id'],'money'=>$money,'alipay'=>$alipay,'addtime'=>TIME,'ip'=>get_client_ip(),'realname'=>$realname,'remark'=>$remark,'mobile'=>$mobile,'status'=>0);
		$duoduo->insert('tixian',$data);
		$re=json_encode(array('s'=>1));
		echo $re;
	break;
	
	case 'mall_comment':
	    if($dduser['id']==''){
			$re=json_encode(array('s'=>0,'id'=>10));
		    echo $re;continue;
		}
		$comment=reg_content($_POST['comment']);
		$mall_id=(int)$_POST['mall_id'];
		$fen=(int)$_POST['fen'];
		if($mall_id==0 || $fen==0 || $comment==''){
		    $re=json_encode(array('s'=>0,'id'=>11));
		    echo $re;continue;
	    }
		$lasttime=$duoduo->select('mall_comment','addtime',"uid=".$dduser['id']." and mall_id='".$mall_id."'"); //上次评论时间
	    if(TIME-$lasttime<$webset['comment_interval']){
	        $re=json_encode(array('s'=>0,'id'=>33));
		    echo $re;continue;
	    }
		$fen=$fen==0?5:$fen;
		$field_arr=array('mall_id'=>$mall_id,'uid'=>$dduser['id'],'fen'=>$fen,'content'=>$comment,'addtime'=>TIME);
		$duoduo->insert('mall_comment',$field_arr);
		$re=json_encode(array('s'=>1,'id'=>0));
		echo $re;
	break;
	
	case 'getTaoItem':
	    $url=$_POST['url'];
		$admin=$_POST['admin'];
		if(preg_match('/(taobao\.com|tmall\.com)/',$url)!=1){
		    $re=array('s'=>0,'id'=>49);
			ajax_exit(json_encode($re));
		}
		$tao_id_arr = include (DDROOT.'/data/tao_ids.php');
		$iid=get_tao_id($url,$tao_id_arr); //获取商品id
		if($iid==''){
		    $re=array('s'=>0,'id'=>22);
			ajax_exit(json_encode($re));
		}
		if($admin==1){ //后台获取商品信息
		    dd_session_start();
			if($_SESSION['ddadmin']['name']==''){
			    ajax_exit(json_encode($re));
			}
			$dduser['level']=9999; 
		}
		elseif($dduser['id']<=0){  //验证是否登录
		    $re=array('s'=>0,'id'=>10);
			ajax_exit(json_encode($re));
		}
		if($webset['share_limit_level']>$dduser['level']){ //验证分享所需等级
		    $re=array('s'=>0,'id'=>21);
			ajax_exit(json_encode($re));
		}
		$data['iid']=$iid;
		$data['outer_code']=$dduser['id'];
		$data['fields']='num_iid,title,cid,pic_url,price,click_url,nick';
		$data['get_commission']=1;
		$goods=$ddTaoapi->items_detail_get($data);
		if($goods['title']==''){
		    $re=array('s'=>0,'id'=>18);
			ajax_exit(json_encode($re));
		}
		$goods['title']=dd_replace($goods['title']);
		$cid=$goods['cid'];
		$shai_cat_id=in_tao_cat($cid);
	    if($shai_cat_id==999){
	        tao_item_cat($cid,$ddTaoapi);
	        $shai_cat_id=$shai_cat_id_temp;
	    }
		
		if($webset['share']['re_tao_cid']==1 && $shai_cat_id==999){ //是否记录漏网cid
		    create_file(DDROOT.'/data/tao_cid.txt',$url.'|||'.$shai_cat_id."\r\n",1);
	    }
		
		$goods['cid']=$shai_cat_id;
		$goods['tao_id']=$iid;
		$re=array('s'=>1,'re'=>$goods);
		echo json_encode($re);
	break;
	
	case 'save_share':
	    if($dduser['id']<=0){  //验证是否登录
		    $re=array('s'=>0,'id'=>10);
			ajax_exit(json_encode($re));
		}
	    $array=array('title','commission','tao_id','image','comment','cid','click_url','nick');
	    if(post2var($array)==0){
		    $re=array('s'=>0,'id'=>11);
			ajax_exit(json_encode($re));
		}

		if($trade_id==0){ //订单id为0表示分享
		    if($dduser['level']<$webset['baobei']['share_level']){
			    $re=array('s'=>0,'id'=>21);
			    ajax_exit(json_encode($re));
		    }
		}
		else{ //表示晒单，验证订单是否是自己的
		    $tao_trade=$duoduo->select('tradelist','num_iid,uid','uid="'.$dduser['id'].'" and num_iid="'.$_POST['tao_id'].'"');
			$tao_id=$tao_trade['num_iid'];
			if($dduser['id']!=$tao_trade['uid']){
			    $re=array('s'=>0,'id'=>42);
			    ajax_exit(json_encode($re));
			}
		}
		
		if($keywords!=''){
		    $keywords_arr = preg_split('/[\n\r\t\s]+/i', trim($keywords));
		    if(count($keywords_arr)>5){
	            $re=array('s'=>0,'id'=>28);
			    ajax_exit(json_encode($re));
	        }
		}
		if(str_utf8_mix_word_count($comment)>$webset['baobei']['word_num']){
		    $re=array('s'=>0,'id'=>26);
			ajax_exit(json_encode($re));
		}
		
		$id=$duoduo->select('baobei','id','uid="'.$dduser['id'].'" and tao_id="'.$tao_id.'"');
		if($id>0){
		    $re=array('s'=>0,'id'=>31);
			ajax_exit(json_encode($re));
		}
		
		$id=$duoduo->select('baobei_blacklist','id','tao_id="'.$tao_id.'"');
		if($id>0){
		    $re=array('s'=>0,'id'=>56);
			ajax_exit(json_encode($re));
		}
		
		if($trade_id==0){ //分享积分
		    $jifen=$webset['baobei']['share_jifen'];
			$shijian=5;
		}
		elseif($trade_id>0){  //晒单积分
		    $jifen=$webset['baobei']['shai_jifen'];
			$shijian=7;
		}

		$comment=reg_content($comment);
		if($comment==''){
		    $re=json_encode(array('s'=>0,'id'=>2));
		    echo $re;continue;
		}
		
		$field_arr=array('uid'=>$dduser['id'],'tao_id'=>$tao_id,'trade_id'=>$trade_id,'img'=>$image,'title'=>$title,'nick'=>$nick,'price'=>$price,'commission'=>$commission,'jifen'=>$jifen,'cid'=>$cid,'click_url'=>$click_url,'keywords'=>$keywords,'content'=>$comment,'addtime'=>TIME);
		$id=$duoduo->insert('baobei',$field_arr);
		
		if($jifen>0){
			$user_update=array('f'=>'jifen','e'=>'+','v'=>$jifen);
			$duoduo->update_user_mingxi($user_update,$dduser['id'],$shijian,$id);
		}
		
		$re=array('s'=>1);
		echo json_encode($re);
		
	break;
	
	case 'like':
	    if($dduser['id']<=0){  //验证是否登录
		    $re=array('s'=>0,'id'=>10);
			ajax_exit(json_encode($re));
		}
		$baobei_id=intval($_POST['id']);
		$uid=$dduser['id'];
		$baobei_hart_id=$duoduo->select('baobei_hart','id','uid="'.$uid.'" and baobei_id="'.$baobei_id.'"');
		if($baobei_hart_id>0){
		    $re=array('s'=>0,'id'=>30);
			ajax_exit(json_encode($re));
		}
		$duoduo->update('baobei',array('f'=>'hart','e'=>'+','v'=>1),'id='.$baobei_id);
		$duoduo->insert('baobei_hart',array('baobei_id'=>$baobei_id,'uid'=>$uid,'addtime'=>TIME));
		$baobei_user_id=$duoduo->select('baobei','uid','id="'.$baobei_id.'"');
		
		$user_update=array(array('f'=>'jifen','e'=>'+','v'=>$webset['baobei']['hart_jifen']),array('f'=>'hart','e'=>'+','v'=>1));
		$duoduo->update_user_mingxi($user_update,$baobei_user_id,16,$baobei_id);
		
		$re=array('s'=>1);
		echo json_encode($re);
	break;
	
	case 'save_share_comment':
	    $comment=$_POST['comment']?htmlspecialchars($_POST['comment']):'';
		$id=$_POST['id']?intval($_POST['id']):0;
	    if($dduser['id']<=0){  //验证是否登录
		    $re=array('s'=>0,'id'=>10);
			ajax_exit(json_encode($re));
		}
		if($dduser['level']<$webset['baobei']['comment_level']){
			$re=array('s'=>0,'id'=>21);
			ajax_exit(json_encode($re));
		}
		if($comment==''){
		    $re=array('s'=>0,'id'=>27);
			ajax_exit(json_encode($re));
		}
		if($id==0){
		    $re=array('s'=>0,'id'=>32);
			ajax_exit(json_encode($re));
		}
		if(str_utf8_mix_word_count($comment)>$webset['baobei']['comment_word_num']){
		    $re=array('s'=>0,'id'=>26);
			ajax_exit(json_encode($re));
		}
		$time=$duoduo->select('baobei_comment','addtime','uid="'.$dduser['id'].'" and baobei_id="'.$id.'"');
		if(TIME-$time<$webset['comment_interval']){
		    $re=array('s'=>0,'id'=>33);
			ajax_exit(json_encode($re));
		}
		$comment=reg_content($comment);
		if($comment==''){
		    $re=json_encode(array('s'=>0,'id'=>2));
		    echo $re;continue;
		}
		$data=array('baobei_id'=>$id,'uid'=>$dduser['id'],'comment'=>$comment,'addtime'=>TIME);
		$duoduo->insert('baobei_comment',$data);
		$re=array('s'=>1);
		echo json_encode($re);
	break;
	
	case 'huan':
	    $s=1;
		$id=(int)$_POST['id'];
		$realname=htmlspecialchars($_POST['realname']);
		$mobile=(float)$_POST['mobile'];
		$email=$_POST['email'];
		$qq=$_POST['qq'];
		$mode=(int)$_POST['mode'];
		$content=htmlspecialchars($_POST['content']);
		
		if($mobile!=0 && reg_mobile($mobile)==0){
		    $re=json_encode(array('s'=>0,'id'=>36));
		    echo $re;continue;
		}
		
		if($email!='' && reg_email($email)==0){
		    $re=json_encode(array('s'=>0,'id'=>7));
		    echo $re;continue;
		}
		
		if($qq!='' && reg_qq($qq)==0){
		    $re=json_encode(array('s'=>0,'id'=>9));
		    echo $re;continue;
		}
		
	    if($dduser['name']==''){  //未登录
		    $re=json_encode(array('s'=>0,'id'=>10));
		    echo $re;continue;
		}
		if($realname=='' || $mobile==0 || $email=='' || $qq=='' || $id==0 || $mode==0){ //缺少必要参数
		    $re=json_encode(array('s'=>0,'id'=>11));
		    echo $re;continue;
	    }
		if($dduser['dhstate']==1){  //正在处于兑换状态
		    $re=json_encode(array('s'=>0,'id'=>16));
		    echo $re;continue;
		}
		$huan=$duoduo->select('huan_goods','id,title,num,money,jifen,auto,array,edate,`limit`','id="'.$id.'" and hide="0"');
		if($huan['title']==''){ //商品不存在
		    $re=json_encode(array('s'=>0,'id'=>17));
		    echo $re;continue;
		}
		elseif($huan['num']<=0){  //商品已下架
		    $re=json_encode(array('s'=>0,'id'=>18));
		    echo $re;continue;
		}
		elseif($huan['edate']<TIME && $huan['edate']>0){  //商品已到期
		    $re=json_encode(array('s'=>0,'id'=>51));
		    echo $re;continue;
		}
		elseif($huan['sdate']>TIME){  //兑换未开始
		    $re=json_encode(array('s'=>0,'id'=>51));
		    echo $re;continue;
		}
		
		if($huan['limit']>0){
			$sdatetime=strtotime(date('Y-m-d').' 00:00:00');
			$edatetime=strtotime(date('Y-m-d').' 23:59:59');
			$duihuan_num=$duoduo->count('duihuan','uid="'.$dduser['id'].'" and huan_goods_id="'.$id.'" and addtime>="'.$sdatetime.'" and addtime<="'.$edatetime.'"');
			if($duihuan_num>=$huan['limit']){
		    	$re=json_encode(array('s'=>0,'id'=>52));  //兑换受限
		    	echo $re;continue;
			}
		}
		
		if($mode==1){  
		    if($huan['money']==0){
			    $re=json_encode(array('s'=>0,'id'=>48));
		        echo $re;continue;
			}
		    if($dduser['live_money']<$huan['money']){  //金额不足
			    $re=json_encode(array('s'=>0,'id'=>19));
		        echo $re;continue;
			}
			else{
			    $data=array(array('f'=>'money','e'=>'-','v'=>$huan['money']),array('f'=>'dhstate','e'=>'=','v'=>1));
				$spend=(float)$huan['money'];
			}
		}
		elseif($mode==2){  
		    if($huan['jifen']==0){
			    $re=json_encode(array('s'=>0,'id'=>48));
		        echo $re;continue;
			}
		    if($dduser['live_jifen']<$huan['jifen']){  //积分不足
			    $re=json_encode(array('s'=>0,'id'=>20));
		        echo $re;continue;
			}
			else{
			    $data=array(array('f'=>'jifen','e'=>'-','v'=>$huan['jifen']),array('f'=>'dhstate','e'=>'=','v'=>1));
				$spend=(int)$huan['jifen'];
			}
		}
		else{
		    ajax_exit();
		}

	    $info['uid']=$dduser['id'];
	    $info['ip']=get_client_ip();
	    $info['huan_goods_id']=$id;
		$info['spend']=$spend;
	    $info['realname']=$realname;
	    $info['address']=$address;
	    $info['email']=$email;
	    $info['mobile']=$mobile;
	    $info['qq']=$qq;
	    $info['content']=$content;
	    $info['addtime']=TIME;
		if($huan['auto']==1){
		    $info['shoptime']=TIME;
	        $info['status']=1;
			unset($data[1]);  //自动返货，不改变会员的兑换状态
		}
		else{
		    $info['shoptime']=0;
	        $info['status']=0;
		}
	    
	    $info['mode']=$mode;
	    $id=$duoduo->insert('duihuan', $info);
		
		if($id>0){
			$duoduo->update('user', $data, 'id="'.$dduser['id'].'"');
			
			$user=$duoduo->select('user','mobile,mobile_test','id="'.$dduser['id'].'"');
			$duihuan_data=array('goods_id'=>$huan['id'],'uid'=>$dduser['id'],'email'=>$info['email'],'mobile'=>$huan['mobile'],'money'=>$huan['money'],'jifen'=>$huan['jifen'],'title'=>$huan['title'],'array'=>$huan['array'],'auto'=>$huan['auto']);
			
			if($huan['mobile']!=$user['mobile']){
				$duihuan_data['mobile']=$huan['mobile'];
			}
			elseif($user['mobile_test']==1){
				$duihuan_data['mobile']=$user['mobile'];
			}
			else{
				$duihuan_data['mobile']='';
			}
			
			$s=$duoduo->duihuan($duihuan_data,0);
		}
		$re=json_encode(array('s'=>$s,'id'=>0));
		echo $re;
	break;
	
	case 'sign':
	    if($webset['sign']['open']==0){
		    $re=json_encode(array('s'=>0,'id'=>43));
		    echo $re;continue;
		} 
		
		$todaytime=strtotime(date('Y-m-d 00:00:00'));
		if($dduser['signtime']<$todaytime){
		    $data=array(array('f'=>'money','e'=>'+','v'=>$webset['sign']['money']),array('f'=>'jifen','e'=>'+','v'=>$webset['sign']['jifen']),array('f'=>'signtime','e'=>'=','v'=>TIME));
		    $duoduo->update('user',$data,'id="'.$dduser['id'].'"');
			$data=array('uid'=>$dduser['id'],'shijian'=>4,'money'=>$webset['sign']['money'],'jifen'=>$webset['sign']['jifen']);
		    $duoduo->mingxi_insert($data);
		    $re=json_encode(array('s'=>1));
		    echo $re;
		}
		else{
			$re=json_encode(array('s'=>0,'id'=>44));
		    echo $re;
		}
	break;
	
	case 'get_size':
	    echo round((directory_size($_GET['dir']) / (1024*1024)), 2);
	break;
	
	case 'goods_comment':
	    if($webset['taoapi']['goods_comment']==0){return;}
	    $comment_url=$_POST['comment_url'];
		$s=dd_get($comment_url);
        $s=str_replace('TB.detailRate = ','',$s);
        $s=trim(iconv("gb2312","utf-8//IGNORE",$s));
        echo $s;
	break;
	
	case 'pinyin':
	    $title=$_POST['title'];
		if(!class_exists('pinyin')){include(DDROOT.'/comm/pinyin.class.php');}
		echo $pinyin=fs('pinyin')->re($title);
	break;
	
	case 'malls':
	    $num=(int)$_POST['num'];
	    if(isset($_POST['cid'])){
		    $cid=(int)$_POST['cid'];
			if($cid>0){
			    $malls=$duoduo->select_all('mall','cid,title,id,img,fan','cid="'.$cid.'" order by sort desc limit '.$num);
				foreach($malls as $k=>$row){
					$malls[$k]['url']=u('mall','view',array('id'=>$row['id']));		
				}
			}
			else{
			    $taoshop_num=$_POST['taoshop_num']; 
				$shangcheng_num=$_POST['shangcheng_num'];
				$mall_num=$_POST['mall_num'];
				
				//淘宝店铺
				$shops=$duoduo->select_all('shop', 'title,id,pic_path,fanxianlv,nick', '1=1 order by index_top desc,sort desc limit '.$taoshop_num);

				//商城
				$shangcheng=$duoduo->select_all('mall', 'cid,title,id,img,fan', '1=1 order by sort desc limit '.$shangcheng_num);

				foreach($shops as $i=>$row){
					$row['url']=u('tao','shop',array('nick'=>$row['nick']));
					$row['fan']=$row['fanxianlv'];
					$row['img']=TAOLOGO.$row['pic_path'];
					$shops[$i]=$row;
				}

				foreach($shangcheng as $i=>$row){
					$row['url']=u('mall','view',array('id'=>$row['id']));
					$shangcheng[$i]=$row;
				}

				$malls=array_merge($shops,$shangcheng);
			}
		}
		elseif(isset($_POST['title'])){
			$title=$_POST['title'];
		    if(preg_match("/^[0-9a-zA-Z]*$/",$title)){
			    $malls=$duoduo->select_all('mall','cid,title,id,img,fan','pinyin like "'.$title.'%" order by sort desc limit '.$num);
			}
			else{
			    $malls=$duoduo->select_all('mall','cid,title,id,img,fan','title like "%'.$title.'%" order by sort desc limit '.$num);
			}
			foreach($malls as $k=>$row){
				$malls[$k]['url']=u('mall','view',array('id'=>$row['id']));		
			}
		}
		
		echo json_encode($malls);
	break;
	
	case 'tao_cuxiao':
		if(isset($_POST['iid'])){
			$iid=(float)$_POST['iid'];
			echo $ddTaoapi->taobao_ump_promotion_get($iid,'json');
		}
	    elseif(isset($_POST['iids'])){
			$iids=$_POST['iids'];
			$iid_arr=explode(',',$iids);
			
			foreach($iid_arr as $iid){
				$iid=(float)$iid;
				if($iid>0){
					$a=$ddTaoapi->taobao_ump_promotion_get($iid,'array');
					if($a['price']>0){
						$data[]=$a;
					}
				}
			}
			echo json_encode($data);
		}
	break;
	
	case 'chanet':
	    dd_session_start();
		if($_SESSION['ddadmin']['name']==''){
			$re=array('err'=>1,'msg'=>'未登录');
			ajax_exit(json_encode($re));
		}
		$do=$_GET['do'];
        if($do=='get_key'){
            $url=CHANET_GET_KEY_URL."?".$_SERVER['QUERY_STRING'];
	        echo dd_get($url);
		}
	    elseif($do=='get_info'){
		    $url=$_POST['url'];
	        $url=DUODUO_URL.'/getchanet.php?act=chanetid&url='.urlencode($url);
	        echo dd_get($url);
		}
	break;
	
	case 'send_mail':
		$email=trim($_GET['email']);
		$title=trim($_GET['title']);
		$content=trim($_GET['content']);
		echo mail_send($email, $title, $content);
	break;
	
	case 'addshop':
		$check=authcode($_GET['check'],'DECODE');
		if($_SERVER['REQUEST_TIME']-$check>5){
			//dd_exit('timeout_addshop');
		}

		$shop['sid']=(int)$_GET['sid'];
		$shop['cid']=(int)$_GET['cid'];
		$shop['pic_path']=isset($_GET['pic_path'])?$_GET['pic_path']:'';
		$shop['item_score']=(float)$_GET['item_score'];
		$shop['service_score']=(float)$_GET['service_score'];
		$shop['delivery_score']=(float)$_GET['delivery_score'];
		$shop['created']=$_GET['created'];
		$shop['title']=$_GET['title'];
		$shop['auction_count']=(int)$_GET['auction_count'];
		$shop['shop_click_url']=$_GET['click_url'];
		$shop['fanxianlv']=(float)$_GET['fanxianlv'];
		$shop['taoke']=(int)$_GET['taoke'];
		$shop['type']=$_GET['shop_type'];
		$shop['level']=(int)$_GET['seller_credit'];
		$admin=(int)$_GET['admin'];
		if($shop['type']=='B'){
			$shop['level']=21;
		}
		$shop['nick']=$_GET['seller_nick'];
		$shop['total_auction']=(int)$_GET['total_auction'];
		$shop['uid']=(int)$_GET['user_id'];
		$shop_info=$duoduo->select('shop', 'id,addtime', 'sid="'.$shop['sid'].'"');
		$shopid=$shop_info['id'];
		$addtime=(int)$shop_info['addtime'];
		if(!$shopid){
			$shop['hits']=0;
			$shop['sort']=0;
			$shop['addtime']=TIME;
			$shop['hits']=0;
			if($admin==1 || ($webset['shop']['open']==1 && $shop['fanxianlv']>0 && (($shop['level']>=$webset['shop']['slevel'] && $shop['level']<=$webset['shop']['elevel']) || $shop['level']==21))){
				$duoduo->insert('shop',$shop);
			}
		}
		elseif(TIME-$addtime>3600*24*5){ //店铺添加后大于5天触发更新
			$data['level']=$shop['level'];
			$data['type']=$shop['type'];
			$data['taoke']=$shop['taoke'];
			$data['total_auction']=$shop['total_auction'];
			$data['auction_count']=$shop['auction_count'];
			$data['item_score']=$shop['item_score'];
			$data['service_score']=$shop['service_score'];
			$data['delivery_score']=$shop['delivery_score'];
			$data['fanxianlv']=$shop['fanxianlv'];
			$data['pic_path']=$shop['pic_path'];
			$data['addtime']=TIME;
			$data['hits']=$shop['hits']+1;
			$duoduo->update('shop',$data,'sid="'.$shop['sid'].'"');
		}
	break;
	
	case 'jssdk_cache':
		$json=str_replace('’‘',"'",$_POST['json']);
		$dir=DDROOT.str_replace('http://'.$_SERVER['HTTP_HOST'].URLMULU,'',$_POST['dir']);
		//$dir=preg_replace('/\?(.*)/','',$dir);
		create_file($dir,$json,0,1,1);
		
	break;
	
	case 'shop_items_get':
	
		$check=authcode($_GET['check'],'DECODE');
		if($_SERVER['REQUEST_TIME']-$check>5){
			//dd_exit('timeout_shop_items_get');
		}
		
		$shop['taoke']=(int)$_GET['taoke'];
		$shop['shoplevel']=(int)$_GET['level'];
		$shop['uid']=(int)$_GET['uid'];
		$shop['nick']=$_GET['nick'];
		$shop['outer_code']=(int)$_GET['outer_code'];
		$list=(int)$_GET['list'];
		$TaobaokeItem=$ddTaoapi->shop_items_get($shop);
		if(!empty($TaobaokeItem)){
			if($list==1){
				foreach($TaobaokeItem as $row) {?>
                        <li class="info">
                        <div class="goodslist_main_left">
                        	<div class="goodslist_main_left_img"><a class="taopic" <?=webtype('rel="nofollow"')?> href="<?=$row["gourl"]?>" target="_blank" pic="<?=base64_encode($row["pic_url"].'_310x310.jpg')?>"><?=html_img($row["pic_url"],11,$row["name"])?></a></div>
                        	<div class="goodslist_main_left_bt title"><a target="_blank" <?=webtype('rel="nofollow"')?> href="<?=$row["gourl"]?>"><?php echo $row["title"] ?></a></div>
                            <div class="goodslist_main_left_sell"><p>本期已售出<span><?php echo $row["commission_num"] ?> </span>件 <img alt="等级" src="images/level_<?=$shop['shoplevel']?>.gif" align="absmiddle" /> </p> </div>
                            <div class="goodslist_main_left_seller"><p>卖家：<A href="<?=$row["go_shop"]?>" target=_blank title="逛逛<?=$row["nick"]?>的店铺"><?=$row["nick"]?></a> <?=wangwang($row["nick"])?><?php if($webset['taoapi']['goods_comment']==1){?>&nbsp;&nbsp; (<a url="userNumId=<?=$shop['uid']?>&auctionNumId=<?=$row["num_iid"]?>" goto="<?=$goods['jump']?>" style="color:#06F; text-decoration:underline; cursor:pointer" class="seecomment">查看评价</a>) <?php }?></p>
                            </div>
                        </div>
                        <div class="goodslist_main_right">
                        	<div class="goodslist_main_right_price">
                            <p class="price">淘宝价：<span><?=$row["price"]?></span> 元 </p> 
                            <?php if($row["fxje"]>0){?>
                            <p class="fxje"> 可返现<span class="greenfont"><?=$row["fxje"]?></span> 元 </p> 
                            <?php }else{?>
                            <p> <span class="greenfont">暂无返现</span> </p>
                            <?php }?>
                            <p>&nbsp;<a target="_blank" href="<?=$row["go_view"]?>">详情</a></p>
                            <p id="<?=$row["num_iid"]?>" class="tbcuxiao" style="clear:both; margin-top:5px; width:150px;"></p>
                        	</div>
                            <div style="clear:both"></div>
                            <div class="goodslist_main_right_tb">
                                <a target="_blank" href="<?=u('tao','list',array('cid'=>0,'q'=>$row["name"]))?>"><div class="goodslist_main_right_bj"></div></a>
                                <a target="_blank" <?php if($webset['taoapi']['fanlitip']==1){?> class="fanlitip" <?php }?> rel="nofollow" href="<?=$row['jump']?>"><div class="goodslist_main_right_buy">去淘宝购买</div></a>
                            </div>
                        </div>
                        </li>
                    <?php }}
					
			if($list==2){
				foreach($TaobaokeItem as $row) {?>
                        <li class="info">
                            <div class="goodslist_main_left_img_2"><a <?=webtype('rel="nofollow" class="fanlitip"')?> href="<?=$row["gourl"]?>" target="_blank"><?=html_img($row["pic_url"],12,$row["name"],'',160,160)?></a></div>
                        	<div class="goodslist_main_left_bt_2 title"><a target="_blank" <?=webtype('rel="nofollow"')?> href="<?=$row["gourl"]?>"><?php echo $row["title"] ?></a></div>
                            <div class="goodslist_main_left_xy_2"><p>卖家信用：<img alt="等级" src="images/level_<?=$shop['shoplevel']?>.gif" align="absmiddle" /></p> </div>
                            <div class="goodslist_main_left_seller_2"><p>卖家：<A href="<?=$row["go_shop"]?>" target=_blank title="逛逛<?=$row["nick"]?>的店铺"><?=$row["nick"]?></a> <?=wangwang($row["nick"],2)?></p>
                            </div>
                        	<p class="price">淘宝价：<span><?=$row["price"]?></span> 元 </p> 
                            <p id="<?=$row["num_iid"]?>" class="tbcuxiao">淘宝热卖商品</p>
                            <p class="fxje"> 可返现：<span class="greenfont"><?=$row["fxje"]?></span> 元 </p>
                            <div class="goodslist_main_right_tb_2">
                                  <a rel="nofollow" href="<?=$row['jump']?>" target="_blank" ><div class="goodslist_main_right_buy">去淘宝购买</div></a><?php if($webset['taoapi']['goods_comment']==1){?>&nbsp;&nbsp; (<a url="userNumId=<?=$shop['uid']?>&auctionNumId=<?=$row["num_iid"]?>" goto="<?=$goods['jump']?>" style="color:#06F; text-decoration:underline; cursor:pointer" class="seecomment">查看评价</a>) <?php }?>
                            </div>
                        </li>
                    <?php }}
					
					?>
        
		<?php }
		else{
			
		}
	break;
}
$duoduo->close();
unset($duoduo);
unset($ddTaoapi);
unset($webset);
exit;
?>