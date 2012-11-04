<?php //59秒api
class wujiumiao{
	public $base_url='http://gw.api.59miao.com/Router/Rest?';
	public $charset='utf-8'; //59秒的网址参数只接受gbk编码的中文
	public $format='json';
	public $v='1.0';
	public $sign_method='md5';
	public $appkey='';
	public $appSecret='';
	public $cache_time=0;
	public $errorlog=0;
	
	function items_search($param){
		$method='59miao.items.search';
		$fields='iid,click_url,cid,sid,seller_url,title,seller_name,desc,pic_url,price,cashback_scope';//iid,click_url,cid,sid,seller_url,title,seller_name,desc,pic_url,price,cash_ondelivery,freeshipment,installment,has_invoice,modified,price_reduction,price_decreases,original_price
		if(isset($param['total'])){
			$total=$param['total'];
			unset($param['total']);
		}
		$arrdata=$this->get($param,$method,$fields);
		if(empty($arrdata)){
			return 102;
		}
		else{
			if(isset($total)){
				$total=$arrdata['items_search_response']['total_results'];
				$arrdata['items_search_response']['items_search']['items']['item']['total']=$total;
			}
			$arrdata=$arrdata['items_search_response']['items_search']['items']['item'];
			return $arrdata;
		}
	}
	
	function items_get($param){
		$method='59miao.items.get';
		$fields='iid,click_url,cid,sid,seller_url,title,seller_name,desc,pic_url,price,cash_ondelivery,freeshipment,installment,has_invoice,modified,price_reduction,price_decreases,original_price';
		$arrdata=$this->get($param,$method,$fields);
		if(empty($arrdata)){
			return 102;
		}
		else{
			$arrdata=$arrdata['items_get_response']['items']['item'];
			return $arrdata;
		}
	}
	
	function promos_list_get($param){
		$method='59miao.promos.list.get';
		$fields='click_url,sid,seller_url,title,seller_name,start_time,end_time,pid,seller_logo,pic_url_1,pic_url_2,pic_url_3';
		if(isset($param['total'])){
			$total=$param['total'];
			unset($param['total']);
		}
		$arrdata=$this->get($param,$method,$fields);
		if(empty($arrdata)){
			return 102;
		}
		else{
			if(isset($total)){
				$total=$arrdata['promos_get_response']['total_results'];
				$arrdata['promos_get_response']['promos']['promo']['total']=$total;
			}
			$arrdata=$arrdata['promos_get_response']['promos']['promo'];
			return $arrdata;
		}
	}
	
	function shops_list_get($param){
		$method='59miao.shops.list.get';
		$fields='click_url,status,name,sid,desc,logo,cashback';
		if(isset($param['total'])){
			$total=$param['total'];
			unset($param['total']);
		}
		$arrdata=$this->get($param,$method,$fields);
		if(empty($arrdata)){
			return 102;
		}
		else{
			if(isset($total)){
				$total=$arrdata['shops_get_response']['total_results'];
				$arrdata['shops_get_response']['shops']['shop']['total']=$total;
			}
			$arrdata=$arrdata['shops_get_response']['shops']['shop'];
			return $arrdata;
		}
	}
	
	function create_sign ($param) { 
		$sign = $this->appSecret; 
		foreach ($param as $key => $val) { 
			if ($key !='' && $val !=''){
				if($key=='keyword'){
					$val=iconv('utf-8','gbk',$val);
				}
				$sign .= $key . $val;
			} 
		}
		$sign = strtoupper(md5($sign));
		return $sign; 
	}
	
	function create_str_param ($param) { 
		return http_build_query($param);
	}
	
	function cache_dir($param){
		unset($param['timestamp']); //删除不定数据
		unset($param['outer_code']);
		$str=md5(http_build_query($param));
		return DDROOT.'/data/temp/59miao/'.substr($str,0,2).'/'.$str.'.'.$this->format;
	}
	
	function do_content($content){
		if($this->format=='json'){
			$arrdata=dd_json_decode($content);
		}
		elseif($this->format=='xml'){
			$xmlCode = simplexml_load_string($content, 'SimpleXMLElement', LIBXML_NOCDATA);
			$arrdata = $this->get_object_vars_final($xmlCode);
		}
		return $arrdata;
	}
	
	function get_object_vars_final($obj) {
		if (is_object($obj)) {
			$obj = get_object_vars($obj);
		}

		if (is_array($obj)) {
			foreach ($obj as $key => $value) {
				$obj[$key] = $this->get_object_vars_final($value);
			}
		}
		return $obj;
	}
	
	function get($param,$method,$fields){
		$arrdata=array();
		
		$param['method']=$method;
		if(!isset($param['fields'])){
			$param['fields']=$fields;
		}
		$param['app_key']=$this->appkey;
		$param['format']=$this->format;
		$param['sign_method']=$this->sign_method;
		$param['timestamp']=date('Y-m-d H:i:s',TIME);
		$param['v']=$this->v;
		ksort($param);
		$cache_dir=$this->cache_dir($param);
		if(file_exists($cache_dir)){
			$content=file_get_contents($cache_dir);
			$arrdata=$this->do_content($content);
		}
		else{
			$url=$this->base_url.http_build_query($param).'&sign='.$this->create_sign($param);
			$content=dd_get($url);
			$arrdata=$this->do_content($content);
			if(isset($arrdata['errorslogs'])){
				if($this->errorlog==1){
					$error=$arrdata['errorslogs']['errorslog']['code'].' '.$arrdata['errorslogs']['errorslog']['discription'];
					$errdir=DDROOT.'/data/temp/59miao_error_log/'.date('Ymd').'.txt';
					create_file($errdir,$error,1,1);
				}
			}
			elseif($this->cache_time>0){
				create_file($cache_dir,$content,0,1,1);
			}
		}
		return $arrdata;
	}
}