<?php
class ddTaoapi extends Taoapi{
    public $dduser;
	public $nowords;
	public $virtual_cid;
	public $format='json';
	public $jssdk_time='';
	public $jssdk_sign='';
	
	function __construct(){
		parent::__construct();
		if(empty($this->nowords)){
			$this->nowords=dd_get_cache('no_words');
		}
		if(empty($this->virtual_cid)){
			$this->virtual_cid=include (DDROOT.'/data/virtual_cid.php');
		}
	}

	function taobao_taobaoke_items_get($Tapparams){
		
		/*if(isset($Tapparams['tag'])){
			$a=def($Tapparams['tag'],array(),array('page_size'=>$Tapparams['page_size']));
			if($a['page_size']>0){
				$Tapparams['page_size']=$a['page_size'];
				$tag_goods=$a['goods'];
			}
		}*/
		
		if($Tapparams['keyword']=='' && $Tapparams['cid']==''){
		    return 'miss keyword or cid';
		}
	    $this->method = 'taobao.taobaoke.items.get';
        if(!isset($Tapparams['fields']) || $Tapparams['fields']==''){
		    $Tapparams['fields'] = 'num_iid,title,nick,seller_credit_score,pic_url,price,click_url,shop_click_url,volume,commission,commission_rate,commission_num,commission_volume,item_location';
		}
        $this->fields = $Tapparams['fields'];
		if(isset($Tapparams['keyword'])){
            $this->keyword = $Tapparams['keyword'];
		}
		if(isset($Tapparams['cid'])){
		    $this->cid = $Tapparams['cid'];
		}
        $this->page_size = $Tapparams['page_size'];
		if(isset($Tapparams['page_no'])){
		    $this->page_no=$Tapparams['page_no'];
		}
		if(isset($Tapparams['sort'])){
		    $this->sort = $Tapparams['sort'];
		}
		else{
		    $this->sort = 'commissionNum_desc';
		}
		if(isset($Tapparams['start_credit'])){
            $this->start_credit=$Tapparams['start_credit'];
		}
		if(isset($Tapparams['end_credit'])){
            $this->end_credit=$Tapparams['end_credit'];
		}
		if(isset($Tapparams['start_price'])){
            $this->start_price=$Tapparams['start_price'];
		}
		if(isset($Tapparams['end_price'])){
            $this->end_price=$Tapparams['end_price'];
		}
		if(isset($Tapparams['area'])){
            $this->area=$Tapparams['area'];
		}
		if(isset($Tapparams['mall_item'])){
		   $this->mall_item=$Tapparams['mall_item'];
		}
		if(isset($Tapparams['outer_code'])){
		    $this->outer_code=$Tapparams['outer_code'];
		}

        $TaobaokeData = $this->Send('get',$this->format)->getArrayData();
        $TaobaokeItem1 = $TaobaokeData["taobaoke_items"]["taobaoke_item"]; 
		if(isset($tag_goods) && is_array($tag_goods) && !empty($tag_goods)){
			$TaobaokeItem1=array_merge($tag_goods,$TaobaokeItem1);
		}
		
        $TotalResults = $TaobaokeData["total_results"]; 
		if(!is_array($TaobaokeItem1[0])){
	        $TaobaokeItem[0]=$TaobaokeItem1;
        }else{
	        $TaobaokeItem=$TaobaokeItem1;
        }
		
		if($TotalResults>0){
		    $TaobaokeItem=$this->do_TaobaokeItem($TaobaokeItem);
			if(isset($Tapparams['total'])){
		        $TaobaokeItem['total']=$TotalResults?$TotalResults:0;
		    }
			return $TaobaokeItem;
		}
		else{
		    return 102; 
		}
	}
	
	function do_TaobaokeItem($TaobaokeItem,$type=0){ //type特别类型，打折页面是否强制缓存
	    foreach($TaobaokeItem as $k=>$row){
			if(array_key_exists('coupon_rate',$row)){
				if($row['coupon_end_time']>'2038-01-01 00:00:00'){
				    $TaobaokeItem[$k]['coupon_end_time']='2038-01-01 00:00:00';
				}
				$end_time=strtotime($TaobaokeItem[$k]['coupon_end_time']);
			    $TaobaokeItem[$k]["coupon_commission"]=round($TaobaokeItem[$k]["commission"]*($row['coupon_price']/$row['price']),2);
				$TaobaokeItem[$k]['coupon_fxje']=fenduan($TaobaokeItem[$k]["coupon_commission"],$this->ApiConfig->fxbl,$this->dduser['level']);
				if($type==1){
				    $data=array('name'=>'打折促销','end_time'=>$end_time,'price'=>$row['coupon_price']);
				    $dir=$this->ApiConfig->CachePath.'/cuxiao/'.substr($row['num_iid'], 0, 3).'/'.substr($row['num_iid'], 3, 3) . '/' . substr($row['num_iid'], -5);
				    $filename=$dir.'_'.$data['end_time'].'.php';
			        $content=json_encode($data);
			        $c="<?php\r\nreturn '".$content."';";
			        create_file($filename,$c,0,1);
				}
			}
		    $TaobaokeItem[$k]['fxje']=fenduan($TaobaokeItem[$k]["commission"],$this->ApiConfig->fxbl,$this->dduser['level']);
			$TaobaokeItem[$k]["title"]=dd_replace($TaobaokeItem[$k]["title"],$this->nowords);
			if(array_key_exists('shop_type',$row)){
			    if($row['shop_type']=='C'){
				    $TaobaokeItem[$k]['level']=$row['seller_credit_score'];
				}
				elseif($row['shop_type']=='B'){
				    $TaobaokeItem[$k]['level']=21;
				}
			}
			if(isset($row['seller_credit_score'])){
				$TaobaokeItem[$k]['level']=$row['seller_credit_score'];
			}

			$TaobaokeItem[$k]['name']=strip_tags($TaobaokeItem[$k]['title']);
	        $TaobaokeItem[$k]['name_url']=urlencode($TaobaokeItem[$k]['name']);
			
			if(isset($TaobaokeItem[$k]['coupon_price']) && $TaobaokeItem[$k]['coupon_price']>0){
			    $TaobaokeItem[$k]['jump']="index.php?mod=jump&act=goods&url=".urlencode(base64_encode($TaobaokeItem[$k]["click_url"])).'&pic='.urlencode(base64_encode($TaobaokeItem[$k]["pic_url"].'_100x100.jpg')).'&iid='.$TaobaokeItem[$k]['num_iid'].'&fan='.$TaobaokeItem[$k]["fxje"].'&price='.$TaobaokeItem[$k]["price"].'&name='.$TaobaokeItem[$k]["name_url"].'&coupon_price='.$TaobaokeItem[$k]['coupon_price'].'&coupon_end_time='.$TaobaokeItem[$k]['coupon_end_time'];
	        	$TaobaokeItem[$k]['go_view']=u('tao','view',array('iid'=>$TaobaokeItem[$k]["num_iid"],'promotion_price'=>$TaobaokeItem[$k]['coupon_price'],'promotion_endtime'=>$end_time));
			}
			else{
			    $TaobaokeItem[$k]['jump']="index.php?mod=jump&act=goods&url=".urlencode(base64_encode($TaobaokeItem[$k]["click_url"])).'&pic='.urlencode(base64_encode($TaobaokeItem[$k]["pic_url"].'_100x100.jpg')).'&iid='.$TaobaokeItem[$k]['num_iid'].'&fan='.$TaobaokeItem[$k]["fxje"].'&price='.$TaobaokeItem[$k]["price"].'&name='.$TaobaokeItem[$k]["name_url"];
	       	 	$TaobaokeItem[$k]['go_view']=u('tao','view',array('iid'=>$TaobaokeItem[$k]["num_iid"]));
			}

	        if(WEBTYPE=='0'){
	            $TaobaokeItem[$k]['gourl']=$TaobaokeItem[$k]['jump'];
				$TaobaokeItem[$k]['go_shop']=u('tao','shop',array('nick'=>$TaobaokeItem[$k]["nick"]));
	        }else{
		        $TaobaokeItem[$k]['gourl']=$TaobaokeItem[$k]['go_view'];
				$TaobaokeItem[$k]['go_shop']=u('tao','shop',array('nick'=>$TaobaokeItem[$k]["nick"]));
	        }
		}
		/*if($type==1 && !empty(coupon_cahche_arr)){
		    make_cache_arr(DDROOT.'/data/Apicache/cuxiao','');
		}*/
		return $TaobaokeItem;
	}
	
	function taobao_items_get($Tapparams){
	    if($Tapparams['keyword']=='' && $Tapparams['cid']==''){
		    return 101;
		}
		$this->method = 'taobao.items.get';
		if(!isset($Tapparams['fields']) || $Tapparams['fields']==''){
            $this->fields = 'iid,detail_url,num_iid,title,nick,type,cid,seller_cids,props,input_pids,input_str,desc,pic_path,num,valid_thru,list_time,delist_time,stuff_status,location,price,post_fee,express_fee,ems_fee,has_discount,freight_payer,has_invoice,has_warranty,has_showcase,modified,increment,auto_repost,approve_status,postage_id,product_id,auction_point,property_alias,itemimg,propimg,sku,outer_id,is_virtural,is_taobao,is_ex,video';
		}
		$this->fields = $Tapparams['fields'];
		if(isset($Tapparams['keyword'])){
            $this->q = $Tapparams['keyword'];
		}
		if(isset($Tapparams['cid'])){
		    $this->cid = $Tapparams['cid'];
		}
        $this->page_size = $Tapparams['page_size'];
		if(isset($Tapparams['page_no'])){
		    $this->page_no=$Tapparams['page_no'];
		}
		if(isset($Tapparams['sort'])){
		    $this->sort = $Tapparams['sort'];
		}
		else{
		    $this->sort = 'commissionNum_desc';
		}
		if(isset($Tapparams['start_credit'])){
            $this->start_credit=$Tapparams['start_credit'];
		}
		if(isset($Tapparams['end_credit'])){
            $this->end_credit=$Tapparams['end_credit'];
		}
		if(isset($Tapparams['start_price'])){
            $this->start_price=$Tapparams['start_price'];
		}
		if(isset($Tapparams['end_price'])){
            $this->end_price=$Tapparams['end_price'];
		}
		if(isset($Tapparams['area'])){
            $this->area=$Tapparams['area'];
		}
		if(isset($Tapparams['mall_item'])){
		   $this->mall_item=$Tapparams['mall_item'];
		}
		$TaobaokeData = $this->Send('get',$this->format)->getArrayData();
        $TaobaokeItem1 = $TaobaokeData["items"]["item"]; 
        $TotalResults = $TaobaokeData["total_results"]; 
		if(!is_array($TaobaokeItem1[0])){
	        $TaobaokeItem[0]=$TaobaokeItem1;
        }else{
	        $TaobaokeItem=$TaobaokeItem1;
        }
		foreach($TaobaokeItem as $k=>$row){
		    $TaobaokeItem[$k]['fxje']=0;
			$TaobaokeItem[$k]["title"]=dd_replace($TaobaokeItem[$k]["title"],$this->nowords);
			$TaobaokeItem[$k]['name']=strip_tags($TaobaokeItem[$k]['title']);
	        $TaobaokeItem[$k]['name_url']=urlencode($TaobaokeItem[$k]['name']);
			$TaobaokeItem[$k]['click_url']=$TaobaokeItem[$k]['detail_url'];
	        $TaobaokeItem[$k]['jump']="index.php?mod=jump&act=goods&url=".urlencode(base64_encode($TaobaokeItem[$k]["click_url"])).'&pic='.urlencode(base64_encode($TaobaokeItem[$k]["pic_url"].'_100x100.jpg')).'&iid='.$TaobaokeItem[$k]['num_iid'].'&fan=0&price='.$TaobaokeItem[$k]["price"].'&name='.$TaobaokeItem[$k]["name_url"];
	        $TaobaokeItem[$k]['go_view']=u('tao','view',array('iid'=>$TaobaokeItem[$k]["num_iid"]));
	        
	        if(WEBTYPE=='0'){
	            $TaobaokeItem[$k]['gourl']=$TaobaokeItem[$k]['jump'];
				$TaobaokeItem[$k]['go_shop']=u('shop','list',array('nick'=>$TaobaokeItem[$k]["nick"]));
	        }else{
		        $TaobaokeItem[$k]['gourl']=$TaobaokeItem[$k]['go_view'];
				$TaobaokeItem[$k]['go_shop']=u('tao','shop',array('nick'=>$TaobaokeItem[$k]["nick"]));
	        }
		}
		if(isset($Tapparams['total'])){
		    $TaobaokeItem['total']=$TotalResults?$TotalResults:0;
		}
		if($TotalResults>0){
		    return $TaobaokeItem;
		}
		else{
		    return 102;
		}
	}
	
	function taobao_itemcat_msg($cid,$fields='cid,parent_cid,name,is_parent'){
	    $this->method = 'taobao.itemcats.get';
        $this->fields = $fields;
		$this->cids = $cid;
		$TaobaokeData = $this->Send('get',$this->format)->getArrayData();
		$TaobaokeItem = $TaobaokeData["item_cats"]["item_cat"];
		return $TaobaokeItem[0];
	}
	
	function taobao_itemcats_get($cid){
	    $TaobaokeItem=$this->taobao_itemcat_msg($cid);
		
		if($TaobaokeItem['is_parent']=='true') $cid=$cid;
		elseif($TaobaokeItem['parent_cid']>0) $cid=$TaobaokeItem['parent_cid'];
		
		if($cid){
			$this->method = 'taobao.itemcats.get';
			$this->cids = '';
		    $this->parent_cid = $cid;
			$this->fields = 'cid,parent_cid,name,is_parent';
		    $TaobaokeData = $this->Send('get',$this->format)->getArrayData();
		    $TaobaokeItem = $TaobaokeData["item_cats"]["item_cat"];
			return $TaobaokeItem;
		}
	}
	
	function taobao_itemcats($cid){
		$this->method = 'taobao.itemcats.get';
		$this->cids = '';
		$this->parent_cid = $cid;
		$this->fields = 'cid,parent_cid,name,is_parent';
		$TaobaokeData = $this->Send('get',$this->format)->getArrayData();
		$TaobaokeItem = $TaobaokeData["item_cats"]["item_cat"];
		return $TaobaokeItem;
	}
	
	function taobao_users_get($nicks){
	    $this->method = 'taobao.users.get';
        $this->fields = 'user_id,nick,seller_credit,location,type';
        $this->nicks = $nicks;
        $TaoapiUsers = $this->Send('get',$this->format)->getArrayData();
        $Result_users1 = $TaoapiUsers["users"]["user"]; 
        if(!is_array($Result_users1[0])){
	        $Result_users[0]=$Result_users1;
        }else{
	        $Result_users=$Result_users1;
        }
	    return $Result_users;
	}
	
	function taobao_item_get($iid){
		$fields='iid,detail_url,num_iid,title,nick,type,cid,seller_cids,num,list_time,delist_time,stuff_status,location,price,post_fee,express_fee,ems_fee,has_discount,freight_payer,item_img';
		if(WEBTYPE==1){
			$fields.='desc';
		}
		$this->method = 'taobao.item.get';
        $this->fields = $fields;
        $this->num_iid = $iid;
		$TaobaoData = $this->Send('get',$this->format)->getArrayData();
		$a=$TaobaoData['item'];
		if($a['title']==''){
			return 102;
		}
		else{
			if(isset($a['item_imgs']['item_img'][0])){
			    $a['pic_url']=$a['item_imgs']['item_img'][0]['url'];
			}
			else{
			    $a['pic_url']=$a['item_imgs']['item_img']['url'];
			}
		}
		$a['notaoke']=1;
		return $a;
			
		/*//查询是否有缓存数据
		$cacheid=array ( 'method' => 'taobao.item.get', 'fields' => $fields, 'num_iid' => $iid, 'format' => $this->format, 'v' => '2.0', 'sign_method' => 'md5') ;
		$cacheid = md5($this->createStrParam($cacheid));
		$taobaoData=$this->Cache->getCacheData($cacheid,'taobao.item.get');
		if($taobaoData!=''){
		    $xmlCode = simplexml_load_string($taobaoData, 'SimpleXMLElement', LIBXML_NOCDATA);
		    $taobaoData = self::$collect->get_object_vars_final($xmlCode);
		    return $taobaoData['item'];
		}
        
		$url='http://item.taobao.com/item.htm?id='.$iid; //检测商品是否存在，避免api错误
		self::$collect->get($url);
		$html=self::$collect->val;
		if(strpos($html,'http://img01.taobaocdn.com/tps/i1/T1CXucXf4vXXXXXXXX-51-63.png')!==false){
		    return 102; //商品不存在
		}
		else{
		    $this->method = 'taobao.item.get';
            $this->fields = $fields;
            $this->num_iid = $iid;
		    $TaobaoData = $this->Send('get',$this->format)->getArrayData();
		    return $TaobaoData['item'];
		}*/
	}
	
	function taobao_taobaoke_items_detail_get($Tapparams){
	    $this->method = 'taobao.taobaoke.items.detail.get';
        $this->num_iids = $Tapparams['iid'];
        $this->outer_code=$Tapparams['outer_code'];
        if($Tapparams['fields']!=''){
		    $this->fields = $Tapparams['fields'];
		}
		else{
		    $this->fields = 'iid,detail_url,num_iid,title,nick,type,cid,desc,pic_url,num,list_time,delist_time,stuff_status,location,price,post_fee,express_fee,ems_fee,has_discount,freight_payer,seller_credit_score,shop_click_url,click_url,volume,stuff_status,has_invoice,cid,auction_point';
		}
        $TaobaokeData = $this->Send('get',$this->format)->getArrayData();
		$goods=$TaobaokeData["taobaoke_item_details"]["taobaoke_item_detail"][0]['item'];

		if(strpos($goods['title'],"'")!==false){
			$goods['title']=str_replace("'",'',$goods['title']);
		}
		
		if($goods['title']!=''){
			$goods['click_url']=$TaobaokeData["taobaoke_item_details"]["taobaoke_item_detail"][0]['click_url'];
			$goods['seller_credit_score']=$TaobaokeData["taobaoke_item_details"]["taobaoke_item_detail"][0]['seller_credit_score'];
			$goods['shop_click_url']=$TaobaokeData["taobaoke_item_details"]["taobaoke_item_detail"][0]['shop_click_url'];
		}

		if($goods['title']=='' && $Tapparams['all_get']==1){ //商品没有返利也获取商品信 推广链接跟商品链接相同
		    $TaobaoData=$this->taobao_item_get($Tapparams['iid']);
			if($TaobaoData==102){
			    return 102;
			}
			$TaobaoData['click_url']=$TaobaoData['detail_url'];
			$goods=$TaobaoData;
		}
		
		if($goods['title']!=''){
			if($goods['freight_payer']=="seller"){$goods['freight_payer']="卖家承担";}else{$goods['freight_payer']="买家承担";}
        	$goods['desc']=preg_replace("/<a [^>]*>|<\/a>/","", $goods['desc']);
			$goods['title']=dd_replace($goods['title'],$this->nowords);
			$goods['desc']=dd_replace($goods['desc'],$this->nowords);
		}
		else{
			$goods=102;
		}
		return $goods;
	}
	
	function items_detail_get_iids($Tapparams){
		$this->method = 'taobao.taobaoke.items.detail.get';
        $this->num_iids = $Tapparams['iids'];
        $this->outer_code=$Tapparams['outer_code'];
        if(isset($Tapparams['fields']) && $Tapparams['fields']!=''){
		    $this->fields = $Tapparams['fields'];
		}
		else{
		    $this->fields = 'num_iid,title,nick,cid,pic_url,num,location,price,seller_credit_score,shop_click_url,click_url,volume';
		}
		
		$TaobaokeData = $this->Send('get',$this->format)->getArrayData();
		$goods=$TaobaokeData["taobaoke_item_details"]["taobaoke_item_detail"];
		
		foreach($goods as $k=>$row){
			$goods[$k]=$row['item'];
			unset($goods[$k]['item']);
		}
		return $goods;
	}
	
	function taobao_taobaoke_items_convert($iid,$outer_code=''){
		$iid_arr=str2arr($iid,20);
		$a=array();
		foreach($iid_arr as $v){
			$this->method = 'taobao.taobaoke.items.convert';
        	$this->fields = 'commission,commission_num,commission_rate,commission_volume,num_iid,click_url';
			if($outer_code!=''){
		    	$this->outer_code=$outer_code;
			}
        	$this->num_iids=$v;
        	$CommData = $this->Send('get',$this->format)->getArrayData();
        	$a1=$CommData['taobaoke_items']['taobaoke_item'];
	        $a=array_merge($a,$a1);
		}
		return $a;
	}
	
	function taobao_user_get($nick){
	    $this->method = 'taobao.user.get';
        $this->fields = 'user_id,nick,good_num,total_num,seller_credit,location,type';
        $this->nick = $nick;
        $TaoapiUsers = $this->Send('get',$this->format)->getArrayData();
        $Result_users = $TaoapiUsers["user"];
        $sellers['uid']=$Result_users["user_id"];
        $sellers['type']=$Result_users["type"];
        $sellers['level']=$Result_users["seller_credit"]["level"];
        $sellers['good_num']=$Result_users["seller_credit"]["good_num"];
		$sellers['total_num']=$Result_users["seller_credit"]["total_num"];
		$sellers['score']=$Result_users["seller_credit"]["score"];
        $sellers['state']=$Result_users["location"]['state'];
		$sellers['city']=$Result_users["location"]['city'];
		$sellers['type']=$Result_users["type"]; //B(商城用户),C(普通卖家)
		$sellers['nick']=$nick;
		return $sellers;
	}
	
	function taobao_shop_get($nick){
	    $this->method = 'taobao.shop.get';
		$this->fields = 'sid,cid,title,desc,pic_path,created,shop_score,nick';
		$this->nick = $nick;
		$ShopData = $this->Send('get',$this->format)->getArrayData();
		$Result_shop=$ShopData['shop'];
		$info['logo']=TAOLOGO.$Result_shop['pic_path'];
		$info['pic_path']=$Result_shop['pic_path'];
		$info['onerror']='images/tbdp.gif';
	    $info['cid']=$Result_shop['cid'];
		$info['sid']=$Result_shop['sid'];
		$info['item_score']=$Result_shop["shop_score"]["item_score"];
		$info['service_score']=$Result_shop["shop_score"]["service_score"];
	    $info['delivery_score']=$Result_shop["shop_score"]["delivery_score"];
		$info['created']=$Result_shop['created'];
		$info['title']=$Result_shop['title'];
		$info['nick']=$Result_shop['nick'];
		if($info['nick']==''){return 104;}
		else{return $info;}
	}
	
	function taobao_taobaoke_shops_convert($Tapparams){
		$this->method = 'taobao.taobaoke.shops.convert';
	    $this->fields = 'commission_rate,click_url,user_id,shop_title,seller_credit,seller_nick,shop_type,auction_count,shop_id,total_auction';
		$this->outer_code=$Tapparams['outer_code'];
		$shopinfo=array();
		if($Tapparams['nick']!=''){
			$nick_arr=explode(',',$Tapparams['nick']);
			$strnicks='';
			$i=0;
			if(count($nick_arr)>10){
				foreach($nick_arr as $v){
					$strnicks.=$v.',';
					if($i==9){
						$strnicks=preg_replace('/,$/','',$strnicks);
						$nicks_array[]=$strnicks;
						$i=-1;
						$strnicks='';
					}
					$i++;
				}
				$strnicks=preg_replace('/,$/','',$strnicks);
				if($strnicks!=''){
					$nicks_array[]=$strnicks;
				}
			}
			else{
				$nicks_array[]=$Tapparams['nick'];
			}
			foreach($nicks_array as $strnicks){
				$this->method = 'taobao.taobaoke.shops.convert';
	    		$this->fields = 'commission_rate,click_url,user_id,shop_title,seller_credit,seller_nick,shop_type,auction_count,shop_id,total_auction';
				$this->outer_code=$Tapparams['outer_code'];
				$this->seller_nicks = $strnicks;
				$data = $this->Send('get',$this->format)->getArrayData();
				$shopinfo1=$data['taobaoke_shops']['taobaoke_shop'];
				$shopinfo=array_merge($shopinfo,$shopinfo1);
			}
		}
		else{
			$this->sids = $Tapparams['sid'];
			$data = $this->Send('get',$this->format)->getArrayData();
			$shopinfo=$data['taobaoke_shops']['taobaoke_shop'];
		}
		return $shopinfo;
	}
	
	function taobao_taobaoke_shop($nick){
		$shop=$this->taobao_shop_get($nick);
		if($shop['nick']==''){ //昵称不存在
			return 104;
		}
        if($shop['type']=='B'){$shop['level']=21;}
		$a=$this->taobao_taobaoke_shops_convert(array('sid'=>$shop['sid'],'outer_code'=>$this->dduser['id']));
		$ShopComm=$a[0];//echo $ShopComm['commission_rate'];
		if($ShopComm['user_id']>0){
			$shop['uid']=$ShopComm['user_id'];
		}
		$shop['type']=$ShopComm['shop_type'];
		if($shop['type']=='B'){
			$shop['level']=21;
		}
		else{
			$shop['level']=$ShopComm['seller_credit'];
		}
		$shop['auction_count']=$ShopComm['auction_count'];
		$shop['total_auction']=$ShopComm['total_auction'];
		$shop['fanxianlv']=(float)$ShopComm['commission_rate'];
		if(in_array($shop['cid'],$this->virtual_cid['shop'])){ //虚拟商品返利强制为0
			$shop['shop_click_url']='http://shop'.$shop['sid'].'.taobao.com/';
			$shop['fanxianlv']=0;
			$shop['taoke']=0;
		}
	    elseif($shop['fanxianlv']>0){
	        $shop['shop_click_url']=$ShopComm['click_url'];
			$shop['taoke']=1;
	    }
		elseif($shop['level']==21){
		    $shop['shop_click_url']=$this->taobao_taobaoke_t9('http://shop'.$shop['sid'].'.taobao.com/',$this->dduser['id']);
			$shop['fanxianlv']=$this->ApiConfig->tmall_commission_rate*100;
			$shop['taoke']=0;
		}
	    else{
	        $shop['shop_click_url']='http://shop'.$shop['sid'].'.taobao.com/';
			$shop['fanxianlv']=0;
			$shop['taoke']=0;
	    }
		if(defined('INDEX')){
		    $shop['fxbl']=fenduan($shop['fanxianlv'],$this->ApiConfig->fxbl,$this->dduser['level']);
		}
		if(is_array($shop['pic_path'])){
		    if($shop['level']==21){
			    $shop['pic_path']='images/tbsc.gif';
			}
			else{
			    $shop['pic_path']='images/tbdp.gif';
			}
		}
		
		return $shop;
	}
	
	function taobao_items_search($Tapparams){
	    $this->method = 'taobao.items.search';
		$this->fields = 'iid,num_iid,title,pic_url,price,volume';
		$this->q = $Tapparams['q'];
		$this->nicks = $Tapparams['nick'];
		$this->start_score=$Tapparams['start_credit'];
		$this->end_score=$Tapparams['end_credit'];
		$this->start_price=$Tapparams['start_price'];
		$this->end_price=$Tapparams['end_price'];
		$this->order_by=$Tapparams['sort'];
		$this->post_free=$Tapparams['post_free'];
		$this->page_no=$Tapparams['page_no'];
		$this->page_size=$Tapparams['page_size'];
		$TaobaokeData_shop = $this->Send('get',$this->format)->getArrayData();
		$TaobaokeItem1 = $TaobaokeData_shop['item_search']['items']['item'];
		$TotalResults = $TaobaokeData_shop['total_results'];
		if(!is_array($TaobaokeItem1[0])){
	        $TaobaokeItem[0]=$TaobaokeItem1;
        }else{
	        $TaobaokeItem=$TaobaokeItem1;
        }
		if($Tapparams['total']){
		    $TaobaokeItem['total']=$TotalResults;
		}
		return $TaobaokeItem;
	}
	
	function taobao_taobaoke_report_get($sj='',$page_no=1){
		if($sj=='') $sj=date("Ymd");
	    $this->method = 'taobao.taobaoke.report.get';
		$this->fields = 'app_key,outer_code,trade_id,pay_time,pay_price,num_iid,item_title,item_num,category_id,category_name,shop_title,commission_rate,commission,iid,seller_nick,real_pay_fee';
		$this->session = $this->ApiConfig->taobao_session;
		//$this->app_key = $thiskey;
		$this->date = $sj;
		$this->page_no = $page_no;
		$this->page_size=40;
		$TaobaokeData = $this->Send('get',$this->format)->getArrayData();	
		if(isset($TaobaokeData['code'])){
			print_r($this->_errorInfo->getErrorInfo());
			print_r($TaobaokeData);
			exit;
		}
		$TaobaokeItem1 = $TaobaokeData['taobaoke_report']['taobaoke_report_members']['taobaoke_report_member'];
		$total_results=$TaobaokeData['taobaoke_report']['total_results'];
		if(!is_array($TaobaokeItem1[0])){
	        $TaobaokeItem[0]=$TaobaokeItem1;
        }else{
	        $TaobaokeItem=$TaobaokeItem1;
        }
		$TaobaokeItem['total']=$total_results;
		return $TaobaokeItem;
	}
	
	function shop_items_get($Tapparams) {
		$Tapparams['relate_type']=4; 
        $Tapparams['seller_id']=$Tapparams['uid'];
		$Tapparams['max_count']=$Tapparams['count']?$Tapparams['count']:40;
        $TaobaokeItem=$this->taobao_taobaoke_items_relate_get($Tapparams);
		
		if ($Tapparams['taoke'] == 1) {
			foreach ($TaobaokeItem as $k => $row) {
				$TaobaokeItem[$k]['fxje'] = fenduan($TaobaokeItem[$k]["commission"], $this->ApiConfig->fxbl, $this->dduser['level']);
				$TaobaokeItem[$k]["title"]=dd_replace($TaobaokeItem[$k]["title"],$this->nowords);
				$TaobaokeItem[$k]['name'] = strip_tags($TaobaokeItem[$k]['title']);
				$TaobaokeItem[$k]['name_url'] = urlencode($TaobaokeItem[$k]['name']);
				$TaobaokeItem[$k]['jump'] = "index.php?mod=jump&act=goods&url=" . urlencode(base64_encode($TaobaokeItem[$k]["click_url"])) . '&pic=' . urlencode(base64_encode($TaobaokeItem[$k]["pic_url"] . '_100x100.jpg')) . '&iid=' . $TaobaokeItem[$k]['num_iid'] . '&fan=' . $TaobaokeItem[$k]["fxje"] . '&price=' . $TaobaokeItem[$k]["price"] . '&name=' . $TaobaokeItem[$k]["name_url"];
				$TaobaokeItem[$k]['go_view'] = u('tao', 'view', array (
					'iid' => $TaobaokeItem[$k]["num_iid"]
				));
				$TaobaokeItem[$k]['go_shop'] = u('tao', 'shop', array (
					'nick' => $Tapparams["nick"]
				));
				$TaobaokeItem[$k]['nick']=$Tapparams['nick'];
				if (WEBTYPE == '0') {
					$TaobaokeItem[$k]['gourl'] = $TaobaokeItem[$k]['jump'];
				} else {
					$TaobaokeItem[$k]['gourl'] = $TaobaokeItem[$k]['go_view'];
				}
				$TaobaokeItem[$k]['nick'] = $Tapparams['nick'];
			}
		}
		elseif ($Tapparams['shoplevel'] == 21) { //商城商品，有补贴
			foreach ($TaobaokeItem as $k => $row) {
				$TaobaokeItem[$k]["commission"] = $TaobaokeItem[$k]["price"] * $this->ApiConfig->tmall_commission_rate;
				$TaobaokeItem[$k]['fxje'] = fenduan($TaobaokeItem[$k]["commission"], $this->ApiConfig->fxbl, $this->dduser['level']);
				$TaobaokeItem[$k]["click_url"] = $this->taobao_taobaoke_t9('http://detail.tmall.com/item.htm?id=' . $TaobaokeItem[$k]['num_iid'], $Tapparams['outer_code']);
				$TaobaokeItem[$k]["title"]=dd_replace($TaobaokeItem[$k]["title"],$this->nowords);
				$TaobaokeItem[$k]['name'] = strip_tags($TaobaokeItem[$k]['title']);
				$TaobaokeItem[$k]['name_url'] = urlencode($TaobaokeItem[$k]['name']);
				$TaobaokeItem[$k]['jump'] = "index.php?mod=jump&act=goods&url=" . urlencode(base64_encode($TaobaokeItem[$k]["click_url"])) . '&pic=' . urlencode(base64_encode($TaobaokeItem[$k]["pic_url"] . '_100x100.jpg')) . '&iid=' . $TaobaokeItem[$k]['num_iid'] . '&fan=' . $TaobaokeItem[$k]["fxje"] . '&price=' . $TaobaokeItem[$k]["price"] . '&name=' . $TaobaokeItem[$k]["name_url"];
				$TaobaokeItem[$k]['go_view'] = u('tao', 'view', array (
					'iid' => $TaobaokeItem[$k]["num_iid"]
				));
				$TaobaokeItem[$k]['go_shop'] = u('tao', 'shop', array (
					'nick' => $Tapparams["nick"]
				));
				if (WEBTYPE == '0') {
					$TaobaokeItem[$k]['gourl'] = $TaobaokeItem[$k]['jump'];
				} else {
					$TaobaokeItem[$k]['gourl'] = $TaobaokeItem[$k]['go_view'];
				}
				$TaobaokeItem[$k]['nick'] = $Tapparams['nick'];
			}
		}
		return $TaobaokeItem;
	}
	
	function items_get($Tapparams){
		//获取商品信息
		$TaobaokeItem=$this->taobao_taobaoke_items_get($Tapparams);
		if($Tapparams['total']==1){
			$total=$TaobaokeItem['total'];
			unset($TaobaokeItem['total']);
		}
		if($Tapparams['seller']==1){
			$nicks = "";
			$c=count($TaobaokeItem);
            for($i = 0; $i < $c; $i++){
	            if($i == 0){
		            $nicks = $TaobaokeItem[$i]["nick"]; 
	            }else{
		            $nicks = $nicks . "," . $TaobaokeItem[$i]["nick"]; 
	            }
            }
			if(str_replace(',','',$nicks)==''){
				return 103;
			}
			else{
			    //获取卖家信息
				$c=count($TaobaokeItem);
				$shopinfos=$this->taobao_taobaoke_shops_convert(array('nick'=>$nicks));
				
				foreach($shopinfos as $k=>$row){
					$nick=$row['seller_nick'];
					$shopinfo[$nick]=$row;
				}
				unset($shopinfos);
				
				foreach($TaobaokeItem as $k=>$row){
					$nick=$row["nick"];
					if($shopinfo[$nick]['shop_type']=='B'){
						$TaobaokeItem[$k]['level']=21;
					}
					else{
						$TaobaokeItem[$k]['level']=$shopinfo[$nick]['seller_credit'];
					}
					$TaobaokeItem[$k]["type"]=$shopinfo[$nick]["shop_type"]; 
					$TaobaokeItem[$k]["user_id"]=$shopinfo[$nick]["user_id"]; 
				}
			}
		}
		if($Tapparams['total']==1){
			$TaobaokeItem['total']=$total;
		}
		return $TaobaokeItem;
	}
	
	function items_detail_get($Tapparams,$url=''){
	    $goods=$this->taobao_taobaoke_items_detail_get($Tapparams);
		if($goods==102) return 102;
		
		if($Tapparams['promotion_price']==0){//促销价为0，获取商品是否参加促销
			if($this->ApiConfig->promotion==0){ //不获取实时价格
				$promotion['name']='';
				$promotion['end_time']='';
				$promotion['price']='';
			}
			else{
				$promotion=$this->taobao_ump_promotion_get($Tapparams['iid'],'array');
			}
		}
		else{
		    $promotion=array('price'=>$Tapparams['promotion_price'],'name'=>$Tapparams['promotion_name'],'endtime'=>$Tapparams['promotion_endtime']);
		}

		if($url!=''){
			if(strpos($url,'tmall.com')!==false && $goods['notaoke']==1){ //返现为0但是为天猫商品
				$url='http://detail.tmall.com/item.htm?id='.$goods['num_iid'];
				$goods['click_url']=$this->taobao_taobaoke_t9($url,$Tapparams['outer_code']);
				$goods['tmall_commission']=$goods['price']*$this->ApiConfig->tmall_commission_rate;  //天猫全站佣金
				$goods['tmall_fxje']=fenduan($goods['tmall_commission'],$this->ApiConfig->fxbl,$this->dduser['level']);
			}
			if(strpos($url,'ju.taobao.com')!==false){  //聚划算商品
				$url='http://ju.taobao.com/tg/home.htm?item_id='.$goods['num_iid'];
				//$goods['click_url']=$this->taobao_taobaoke_t9($url,$Tapparams['outer_code']);  不能采用t9转换，丢单
				$ju_html=dd_get($url);
				preg_match('/<strong class="J_juPrices"><b>&yen;<\/b>(.*)<\/strong>/',$ju_html,$a);
				$goods['price']=$a[1];
				$goods['ju_commission']=$goods['price']*$this->ApiConfig->ju_commission_rate;  //聚划算全站佣金
				$goods['ju_fxje']=fenduan($goods['ju_commission'],$this->ApiConfig->fxbl,$this->dduser['level']);
			}
		}
		$goods['jump']="index.php?mod=jump&act=goods&url=".urlencode(base64_encode($goods['click_url'])).'&pic='.urlencode(base64_encode($goods["pic_url"].'_100x100.jpg')).'&price='.$goods["price"].'&name='.urlencode($goods["title"]).'&iid='.$goods['num_iid'];
		
		if($promotion['price']>0){
			$goods['promotion_price']=$promotion['price'];
			$goods['promotion_name']=$promotion['name'];
		    $goods['promotion_endtime']=$promotion['endtime'];
			if($goods['commission']>0){
				$goods['promotion_commission']=round($goods['commission']*($goods['promotion_price']/$goods['price']),2);
			}
			$goods['jump'].='&promotion_price='.$goods['promotion_price'].'&promotion_endtime='.$goods['promotion_endtime'];
		}
		
		return $goods;
	}
	
	function get_commission($title,$nick,$p='commission'){
		$Tapparams['keyword']=$title;
		$Tapparams['page_no']=1;
		$Tapparams['page_size']=40;
		$Tapparams['sort']='commissionNum_desc';
		$Tapparams['fields']='title,click_url,commission,nick';
		$arr=$this->taobao_taobaoke_items_get($Tapparams);
	    if($arr[0]=='') $row[0]=$arr;
	    else $row=$arr;
		if(!is_array($row)){
		    return;
		}
		$c=count($row);
	    for($i=0;$i<$c;$i++){
	        if($row[$i]['nick']==$nick && strip_tags($row[$i]['title'])==strip_tags($title)){
		        $re=$row[$i];
			    $i=9999999;
		    }
	    }
	    if($p=='commission') return $re['commission'];
	    if($p=='click_url') return $re['click_url'];
    }
	
	function taobao_time_get(){
	    $this->method = 'taobao.time.get';
		$TaobaokeData = $this->Send('get',$this->format)->getArrayData();
		return $TaobaokeData['time'];
	}
	
	function taobao_ump_promotion_get($iid,$type='array'){
		$api=0;
        $dir=$this->ApiConfig->CachePath.'/cuxiao/'.substr($iid, 0, 3).'/'.substr($iid, 3, 3) . '/' . substr($iid, -5);
	    $file_arr=glob($dir.'_*.json');
	    if(!empty($file_arr)){
		    foreach($file_arr as $v){
				$a=explode('_',$v);
			    $end_time=$a[count($a)-1];
		        $end_time=str_replace('.json','',$end_time);
			    if($end_time>TIME){
				    if($type=='json'){
				        return file_get_contents($v);
				    }
				    elseif($type=='array'){  
				        return json_decode(file_get_contents($v),1);
				    }
			    }
			    else{
				    $api=1;
			    }
		    }
	    }
	    else{
		    $api=1;
	    }
		
		if($api==0) return;

	    $this->method = 'taobao.ump.promotion.get';
		$this->item_id = $iid;
		$TaobaokeData = $this->Send('get',$this->format)->getArrayData();
		$info=$TaobaokeData['promotions']['promotion_in_item']['promotion_in_item'];
		$data['name']='';
		$data['end_time']='';
		$data['price']='';
		if($info[0]['name']!=''){
			foreach($info as $k=>$row){
			    if($row['end_time']>date('Y-m-d H:i:s')){
				    $data['name']=$row['name'];
					$data['price']=$row['item_promo_price'];
					if($row['end_time']>'2038-01-01 00:00:00'){  //时间戳的最大值
			            $row['end_time']='2038-01-01 00:00:00';
			        }
		            $data['end_time']=strtotime($row['end_time']);
					break;
				}
			}
		}
		elseif($info['name']!=''){
		    $data['name']=$info['name'];
			if($info['end_time']>'2038-01-01 00:00:00'){  //时间戳的最大值
			    $info['end_time']='2038-01-01 00:00:00';
			}
		    $data['end_time']=strtotime($info['end_time']);
		    $data['price']=$info['item_promo_price'];
		}
		else{
			$url1='http://marketing.taobao.com/home/promotion/item_promotion_list.do?itemId='.$iid;
			$url2='http://tbskip.taobao.com/limit_promotion_item.htm?auctionId='.$iid;
			$a=dd_get($url1);
			if($a!=''){
				$a=iconv('gbk','utf-8',$a);
				$a=str_replace('var yx_promList=','',$a);
				$a=json_decode($a,1);
				$data['name']=$a['promList'][0]['iconTitle'];
				$data['price']=(float)$a['promList']['policyList'][0]['promPrice'];
				$data['end_time']=date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s')." +5 hour")); //默认5小时过期
			}
		}
		if($data['name']!='' && $data['price']>0){
			$data['iid']=$iid;
			$filename=$dir.'_'.$data['end_time'].'.json';
			$content=json_encode($data);
			create_file($filename,$content);
		}
	
		if($type=='json'){
		    return $content;
		}
		else{
		    return $data;
		}
	}
	
	function taobao_taobaoke_listurl_get($q,$outer_code){ //S8接口，可以自己拼装url
		$url='http://s8.taobao.com/search?q='.rawurlencode(iconv('utf-8','gbk//IGNORE',$q)).'&pid=mm_'.$this->ApiConfig->taobao_search_pid.'&commend=all&unid='.$outer_code.'&taoke_type=1';
	    return spm($url);
		$this->method = 'taobao.taobaoke.listurl.get';
		$this->q = $q;
        $this->outer_code=$outer_code;
		$TaobaokeData = $this->Send('get',$this->format)->getArrayData();
		return $TaobaokeData['taobaoke_item']['keyword_click_url'].'&taoke_type=1';
	}
	
	function taobao_taobaoke_t9($url,$u){
		$url=spm($url);
	    return 'http://s.click.taobao.com/t_9?p=mm_'.$this->ApiConfig->taobao_pid.'_0_0&l='.urlencode($url).'&unid='.$u;
	}
	
	function taobao_taobaoke_s8($type,$val=''){
		switch($type){
		    case 'cid':
			    $url='http://s8.taobao.com/search?pid=mm_'.$this->ApiConfig->taobao_search_pid.'&unid='.$this->dduser['id'].'&mode=63&refpos=&cat='.$val.'&commend=all&taoke_type=1';
			break;
			case 'index':
			    $url='http://s8.taobao.com/list.html?&pid=mm_'.$this->ApiConfig->taobao_search_pid.'&commend=all&unid='.$this->dduser['id'].'&taoke_type=1';
			break;
			case 'q':
			    $url='http://s8.taobao.com/search?q='.rawurlencode(iconv('utf-8','gbk//IGNORE',$val)).'&pid=mm_'.$this->ApiConfig->taobao_search_pid.'&commend=all&unid='.$this->dduser['id'].'&taoke_type=1';
			break;
		}
	    return spm($url);
	}
	
	function taobao_taobaoke_items_coupon_get($Tapparams){
		$this->method = 'taobao.taobaoke.items.coupon.get'; 
		if($Tapparams['keyword']=='' && $Tapparams['cid']==''){
		    return 'miss keyword or cid';
		}
		if(!isset($Tapparams['fields'])){
		    $Tapparams['fields']='num_iid,title,nick,pic_url,price,click_url,commission,commission_rate,commission_num,commission_volume,shop_click_url,seller_credit_score,item_location,volume,coupon_price,coupon_rate,coupon_start_time,coupon_end_time,shop_type';
		}
		$this->fields = $Tapparams['fields'];
		if(isset($Tapparams['keyword'])){
            $this->keyword = $Tapparams['keyword'];
		}
		if(isset($Tapparams['cid'])){
		    $this->cid = $Tapparams['cid'];
		}
		if(isset($Tapparams['outer_code'])){
		    $this->outer_code=$Tapparams['outer_code'];
		}
		if(isset($Tapparams['coupon_type'])){ //默认为1，暂时只有1分类
		    $this->coupon_type=$Tapparams['coupon_type'];
		}
		if(isset($Tapparams['shop_type'])){  //可选值 b（商城） c（集市） 默认all
		    $this->shop_type=$Tapparams['shop_type'];
		}
		if(isset($Tapparams['sort'])){ //可选值 default(默认排序), price_desc(折扣价格从高到低), price_asc(折扣价格从低到高), credit_desc(信用等级从高到低), credit_asc(信用等级从低到高), commissionRate_desc(佣金比率从高到低), commissionRate_asc(佣金比率从低到高), commissionVome_desc(成交量成高到低), commissionVome_asc(成交量从低到高) 
		    $this->sort =$Tapparams['sort'];
		}
		if(isset($Tapparams['start_coupon_rate'])){  //折扣比例范围,如：7000表示70.00% 
		    $this->start_coupon_rate=$Tapparams['start_coupon_rate'];
		}
		if(isset($Tapparams['end_coupon_rate'])){  //折扣比例范围,如：8000表示80.00%.注：要起始折扣比率和最高折扣比率一起设置才有效
		    $this->end_coupon_rate=$Tapparams['end_coupon_rate'];
		}
		if(isset($Tapparams['start_credit'])){  //卖家信用: 1heart(一心) 2heart (两心) 3heart(三心) 4heart(四心) 5heart(五心) 1diamond(一钻) 2diamond(两钻) 3diamond(三钻) 4diamond(四钻) 5diamond(五钻) 1crown(一冠) 2crown(两冠) 3crown(三冠) 4crown(四冠) 5crown(五冠) 1goldencrown(一黄冠) 2goldencrown(二黄冠) 3goldencrown(三黄冠) 4goldencrown(四黄冠) 5goldencrown(五黄冠) 
		    $this->start_credit=$Tapparams['start_credit'];
		}
		if(isset($Tapparams['end_credit'])){  //可选值和start_credit一样.start_credit的值一定要小于或等于end_credit的值。注：end_credit与start_credit一起使用才生效  
		    $this->end_credit=$Tapparams['end_credit'];
		}
		if(isset($Tapparams['start_commission_rate'])){  //起始佣金比率选项，如：1234表示12.34% 
		    $this->start_commission_rate=$Tapparams['start_commission_rate'];
		}
		if(isset($Tapparams['end_commission_rate'])){  //最高佣金比率选项，如：2345表示23.45%。注：要起始佣金比率和最高佣金比率一起设置才有效。 
		    $this->end_commission_rate=$Tapparams['end_commission_rate'];
		}
		if(isset($Tapparams['start_commission_volume'])){  //起始累计推广量佣金.注：返回的数据是30天内累计推广佣金，该字段要与最高累计推广佣金一起使用才生效  
		    $this->start_commission_volume=$Tapparams['start_commission_volume'];
		}
		if(isset($Tapparams['end_commission_volume'])){  //最高累计推广佣金选项
		    $this->end_commission_volume=$Tapparams['end_commission_volume'];
		}
		if(isset($Tapparams['start_commission_num'])){  //累计推广量范围开始 
		    $this->start_commission_num=$Tapparams['start_commission_num'];
		}
		if(isset($Tapparams['end_commission_num'])){  //累计推广量范围结束  
		    $this->end_commission_num=$Tapparams['end_commission_num'];
		}
		if(isset($Tapparams['start_volume'])){  //交易量范围开始  
		    $this->start_volume=$Tapparams['start_volume'];
		}
		if(isset($Tapparams['end_volume'])){  //交易量范围结束  
		    $this->end_volume=$Tapparams['end_volume'];
		}
		if(isset($Tapparams['area'])){    
		    $this->area=$Tapparams['area'];
		}
		if(isset($Tapparams['page_no'])){    
		    $this->page_no=$Tapparams['page_no'];
		}
		if(isset($Tapparams['page_size'])){     //最大100 
		    $this->page_size=$Tapparams['page_size'];
		}
		$TaobaokeData = $this->Send('get',$this->format)->getArrayData();
        $TaobaokeItem1 = $TaobaokeData["taobaoke_items"]["taobaoke_item"]; 
        $TotalResults = $TaobaokeData["total_results"]; 
		if(!is_array($TaobaokeItem1[0])){
	        $TaobaokeItem[0]=$TaobaokeItem1;
        }else{
	        $TaobaokeItem=$TaobaokeItem1;
        }
		if($TotalResults>0){
		    $TaobaokeItem=$this->do_TaobaokeItem($TaobaokeItem); //促销价格缓存
			
			if(isset($Tapparams['total'])){
		        $TaobaokeItem['total']=$TotalResults?$TotalResults:0;
		    }
			return $TaobaokeItem;
		}
		else{
		    return 102; 
		}
	}
	
	function taobao_shopcats_list_get(){
		$this->method = 'taobao.shopcats.list.get'; 
		$TaobaokeData = $this->Send('get',$this->format)->getArrayData();
		return $TaobaokeData['shop_cats']['shop_cat'];
	}
	
	function taobao_taobaoke_shops_get($Tapparams){
		$this->method = 'taobao.taobaoke.shops.get'; 
		if($Tapparams['keyword']=='' && $Tapparams['cid']==''){
		    return 'miss keyword or cid';
		}
		if(!isset($Tapparams['fields'])){
		    $Tapparams['fields']='user_id,click_url,shop_title,commission_rate,seller_credit,shop_type,auction_count,total_auction';
		}
		$this->fields = $Tapparams['fields'];
		if(isset($Tapparams['cid'])){
		    $this->cid = $Tapparams['cid'];
		}
		if(isset($Tapparams['keyword'])){
            $this->keyword = $Tapparams['keyword'];
		}
		if(isset($Tapparams['start_credit'])){  //店铺掌柜信用等级起始店铺的信用等级总共为20级 1-5:1heart-5heart;6-10:1diamond-5diamond;11-15:1crown-5crown;16-20:1goldencrown-5goldencrown 
		    $this->start_credit = $Tapparams['start_credit'];
		}
		if(isset($Tapparams['end_credit'])){ 
		    $this->end_credit = $Tapparams['end_credit'];
		}
		if(isset($Tapparams['start_commissionrate'])){  //店铺佣金比例查询开始值，注意佣金比例是x10000的整数.50表示0.5%  
		    $this->start_commissionrate = $Tapparams['start_commissionrate'];
		}
		if(isset($Tapparams['end_commissionrate'])){  
		    $this->end_commissionrate = $Tapparams['end_commissionrate'];
		}
		if(isset($Tapparams['start_auctioncount'])){    //店铺宝贝数查询开始值 
		    $this->start_auctioncount = $Tapparams['start_auctioncount'];
		}
		if(isset($Tapparams['end_auctioncount'])){  
		    $this->end_auctioncount = $Tapparams['end_auctioncount'];
		}
		if(isset($Tapparams['start_totalaction'])){   //店铺累计推广量开始值 
		    $this->start_totalaction = $Tapparams['start_totalaction'];
		}
		if(isset($Tapparams['end_totalaction'])){
		    $this->end_totalaction = $Tapparams['end_totalaction'];
		}
		if(isset($Tapparams['only_mall'])){  //是否只显示商城店铺 默认false
		    $this->only_mall = $Tapparams['only_mall'];
		}
		if(isset($Tapparams['page_no'])){
		    $this->page_no = $Tapparams['page_no'];
		}
		if(isset($Tapparams['page_size'])){
		    $this->page_size = $Tapparams['page_size'];
		}
		$TaobaokeData = $this->Send('get',$this->format)->getArrayData();
        $TaobaokeItem1 = $TaobaokeData["taobaoke_shops"]["taobaoke_shop"]; 
        $TotalResults = $TaobaokeData["total_results"]; 
		if(!is_array($TaobaokeItem1[0])){
	        $TaobaokeItem[0]=$TaobaokeItem1;
        }else{
	        $TaobaokeItem=$TaobaokeItem1;
        }
		if(isset($Tapparams['total'])){
		    $TaobaokeItem['total']=$TotalResults?$TotalResults:0;
		}
		if($TotalResults>0){
		    return $TaobaokeItem;
		}
	}
	
	function taobao_taobaoke_items_relate_get($Tapparams){  //推荐接口
		$this->method = 'taobao.taobaoke.items.relate.get'; 
	    $this->fields = 'num_iid,title,nick,pic_url,price,click_url,commission,ommission_rate,commission_num,commission_volume,shop_click_url,seller_credit_score,item_location,volume';
		$this->relate_type = $Tapparams['relate_type']; //推荐类型.1:同类商品推荐;2:异类商品推荐;3:同店商品推荐;4:店铺热门推荐;5:类目热门推荐 
        $this->num_iid = $Tapparams['num_iid'];  //淘宝客商品数字id.推荐类型为1,2,3时num_iid不能为空
		$this->seller_id = $Tapparams['seller_id'];  //卖家id.推荐类型为4时seller_id不能为空
		$this->cid = $Tapparams['cid'];  //分类id.推荐类型为5时cid不能为空。仅支持叶子类目ID，即通过taobao.itemcats.get获取到is_parent=false的cid
		$this->shop_type = $Tapparams['shop_type']?$Tapparams['shop_type']:'all';  //店铺类型.默认all,商城:b,集市:c
        $this->sort =$Tapparams['sort']?$Tapparams['sort']:'default';  //default(默认排序,关联推荐相关度),price_desc(价格从高到低), price_asc(价格从低到高),commissionRate_desc(佣金比率从高到低), commissionRate_asc(佣金比率从低到高), commissionNum_desc(成交量成高到低), commissionNum_asc(成交量从低到高)
        $this->max_count = $Tapparams['max_count']?$Tapparams['max_count']:40;
		$TaobaokeData = $this->Send('get',$this->format)->getArrayData();
		return $TaobaokeData['taobaoke_items']['taobaoke_item'];
	}
	
	function taobao_shoprecommend_items_get($Tapparams){
	    $this->method = 'taobao.shoprecommend.items.get';
		$this->seller_id=$Tapparams['seller_id'];
		$this->recommend_type=1;
		$this->count =$Tapparams['count']?$Tapparams['count']:10;
		$this->ext=$Tapparams['ext'];
		$TaobaokeData = $this->Send('get',$this->format)->getArrayData();
		return $TaobaokeData['favorite_items']['favorite_item'];
	} 
	
	function tmall_temai_items_search($Tapparams=array()){
		$start=(int)$Tapparams['page']*48;
		$this->method = 'tmall.temai.items.search';
		$this->cat=$Tapparams['cid']?$Tapparams['cid']:50100982;
		$this->start=$start;
		$this->sort=$Tapparams['sort']?$Tapparams['sort']:'s'; //s: 人气排序 p: 价格从低到高; pd: 价格从高到低; d: 月销量从高到低; pt: 按发布时间排序.
		$TaobaokeData = $this->Send('get',$this->format)->getArrayData();
		$total=$TaobaokeData['total_results'];
		$TaobaokeItem=$TaobaokeData['item_list']['tmall_search_tm_item'];
		
		$num_iids='';
		foreach($TaobaokeItem as $k=>$row){
			preg_match('/(\d+)_track_\d+/',$row['track_iid'],$a);
			$num_iid=$a[1];
			$num_iids.=$num_iid.',';
			$num_iid_arr[$num_iid]=$k;
		}
		$num_iids=preg_replace('/,$/','',$num_iids);

		$a=$this->taobao_taobaoke_items_convert($num_iids,$Tapparams['outer_code']);
		unset($a['total']);

		foreach($a as $i=>$v){
			$k=$num_iid_arr[(string)$v['num_iid']];
			$TaobaokeItem[$k]['num_iid']=$v['num_iid'];
			$TaobaokeItem[$k]['pic_url']=str_replace('_b.jpg','',$TaobaokeItem[$k]['pic_url']);
			$TaobaokeItem[$k]['click_url']=$v['click_url'];
			$TaobaokeItem[$k]['commission']=$v['commission'];
			$TaobaokeItem[$k]['commission_num']=$v['commission_num'];
			//$TaobaokeItem[$k]['fxje']=round($TaobaokeItem[$k]['promotion_price']*$TaobaokeItem[$k]['commission']/$TaobaokeItem[$k]['price'],2);
		}
		
		foreach($TaobaokeItem as $k=>$row){
			if(isset($row['num_iid'])){
				$goods[]=$row;
			}
		}
		unset($TaobaokeItem);
		if(isset($Tapparams['total']) && $Tapparams['total']>0){
			$goods['total']=$total;
		}
		return $goods;
	}
	
	function tmall_temai_subcats_search($cid=''){
		$this->method = 'tmall.temai.subcats.search';
		$this->cat =  $cid?$cid:50100982;
		$TaobaokeData = $this->Send('get',$this->format)->getArrayData();
		return $TaobaokeData['cat_list']['tmall_tm_cat'];
	}
	
	function taobao_spmeffect_get($sdate='',$edate=''){
		if($sdate==''){
			$sdate=date("Y-m-d",strtotime("-1 day"));
		}
		if($edate==''){
			$edate=date("Y-m-d",strtotime("-1 day"));
		}
		
		$chaday=date('Ymd',strtotime($edate))-date('Ymd',strtotime($sdate));
		
		for($i=0;$i<=$chaday;$i++){
			$this->method = 'taobao.spmeffect.get';
			$day=date("Y-m-d",strtotime($sdate." +".$i." day"));
			$this->date=$day;
			$TaobaokeData = $this->Send('get',$this->format)->getArrayData();
			$a[$day]=$TaobaokeData['spm_result']['spm_site'];
		}
		return $a;
	}
	
	function tmall_items_discount_search($Tapparams){
		$page=(int)$Tapparams['page']*10;
		$this->method='tmall.items.discount.search';
		$this->q=$Tapparams['q'];
		$this->cat=$Tapparams['cid'];
		$this->start=$page; //start最大是110
		$this->sort=$Tapparams['sort']?$Tapparams['sort']:'s';  // s: 人气排序 p: 价格从低到高; pd: 价格从高到低; d: 月销量从高到低; td: 总销量从高到低; pt: 按发布时间排序
		$this->post_fee=$Tapparams['post_fee'];  //-1为包邮
		$this->post_fee=$Tapparams['post_fee'];
		$this->start_price=$Tapparams['start_price'];
		$this->auction_tag=$Tapparams['auction_tag'];  //天猫精品库：8578；品牌特卖商品库：3458；天猫原创商品库：4801 
		$TaobaokeData = $this->Send('get',$this->format)->getArrayData();
		$total=$TaobaokeData['total_results'];
		$TaobaokeItem=$TaobaokeData['item_list']['tmall_search_item'];

		$num_iids='';
		foreach($TaobaokeItem as $k=>$row){
			$num_iid=$row['item_id'];
			$num_iids.=$num_iid.',';
			$num_iid_arr[(string)$num_iid]=$k;
		}
		$num_iids=preg_replace('/,$/','',$num_iids);

		$a=$this->taobao_taobaoke_items_convert($num_iids,$Tapparams['outer_code']);

		foreach($a as $i=>$v){
			$k=$num_iid_arr[(string)$v['num_iid']];
			$TaobaokeItem[$k]['num_iid']=$v['num_iid'];
			$TaobaokeItem[$k]['pic_path']=str_replace('_160x160.jpg','',$TaobaokeItem[$k]['pic_path']);
			$TaobaokeItem[$k]['url']=str_replace('&amp;','&',$TaobaokeItem[$k]['url']);
			$TaobaokeItem[$k]['click_url']=$v['click_url'];
			$TaobaokeItem[$k]['commission']=$v['commission'];
			$TaobaokeItem[$k]['commission_num']=$v['commission_num'];
			$TaobaokeItem[$k]['commission_rate']=$v['commission_rate'];
			//$TaobaokeItem[$k]['fxje']=round($TaobaokeItem[$k]['promotion_price']*$TaobaokeItem[$k]['commission']/$TaobaokeItem[$k]['price'],2);
		}
		
		foreach($TaobaokeItem as $k=>$row){
			if(isset($row['num_iid'])){
				$goods[]=$row;
			}
		}
		unset($TaobaokeItem);
		if(isset($Tapparams['total']) && $Tapparams['total']>0){
			$goods['total']=$total;
		}
		return $goods;
	}
}
?>