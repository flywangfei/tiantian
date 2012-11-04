<?php  //一起发接口多多程序扩展
class ddyiqifa extends yiqifa{
    function category(){  //商品分类
	    $data=$this->get('category');
		return $data['categorys'];
	}
	
	function category_subcategory($parame){  //获取二级分类
	    $data=$this->get('category/subcategory',$parame);
		return  $data['categorys'];
	}
	
	function product_search($parame,$total=0){  //搜索商品
	    $data=$this->get('product/search',$parame);
		if(empty($data)){
		    return array('total'=>0);
		}
		$row=$data['results'];
		foreach($row as $k=>$arr){
		    $row[$k]['url']=$this->do_ad_url($arr['url']);
			$row[$k]['discounturl']=$this->do_ad_url($arr['discounturl']);
			$row[$k]['merchantTopurl']=$this->do_ad_url($arr['merchantTopurl']);
			$row[$k]['productName']=str_replace(array('"',"'"),'',$arr['productName']);
			$row[$k]['name_url']=urlencode($arr['productName']);
	        $row[$k]['base64_pic']=base64_encode($arr['picurl']);
		}
		if($total==1 && isset($data['total'])){
		    $row['total']=$data['total'];
		}
		
		return $row;
	}
	
	function product_singleproduct($parame){
	    $data=$this->get('product/singleproduct',$parame);
		$data['unionCode']=$this->do_ad_url($data['unionCode']);
		return $data;
	}
	
	function merchant_merchantcategory(){  //商家分类
	    $data=$this->get('merchant/merchantcategory');
		return $data['merchantCats'];
	}
	
	function merchant($parame=array('page'=>1,'pageRowCount'=>250)){
        $data=$this->get('merchant',$parame);
		return $data['merchants'];
	}
	
	function pdtmerchant($parame){
	    $data=$this->get('pdtmerchant',$parame);
		$data['unionCode']=$this->do_ad_url($data['unionCode']);
		return $data;
	}
	
	function tuanwebsite(){
	    $data=$this->get('tuanwebsite');
		foreach ($data['websites'] as $row){
		    $row['unionUrl']=$this->do_ad_url($row['unionUrl']);
			$arr[]=$row;
		}
		return $arr;
	}
	
	function tuancity(){
	    $data=$this->get('tuancity');
		return $dara['citys'];
	}
	
	function tuanproduct($parame,$total=0){
	    $data=$this->get('tuanproduct',$parame);
		foreach($data['results'] as $k=>$row){
			$row['allianceCode']=$this->do_ad_url($row['allianceCode']);
			$row['website']['allianceCode']=$this->do_ad_url($row['website']['allianceCode']).$row['website']['href'];
		    $arr[]=$row;
		}
		if($total==1 && isset($data['total'])){
		    $arr['total']=$data['total'];
		}
		return $arr;
	}
	
	function tuancategory(){
	    $data=$this->get('tuancategory');
		return $data['categorys'];
	}
	
	function category_tuansubcategory($parame){
	    $data=$this->get('category/tuansubcategory',$parame);
		return $data;
	}
	
	function limitactivity($parame,$total=0){
		$data=$this->get('limitactivity',$parame);
		foreach($data['limitActivitys'] as $k=>$row){
			$row['unicode']=$this->do_ad_url($row['unicode']);
		    $arr[]=$row;
		}
		if($next==1 && $data['totalRowCount']>0){
		    $arr['next']=$data['totalRowCount'];
		}
		return $arr;
	}
	
	function discount($parame,$total=0){
	    $data=$this->get('discount',$parame);
		if(empty($data)) return '';
		foreach($data['gwkdiscounts'] as $k=>$row){
			$row['unicode']=$this->do_ad_url($row['unicode']);
		    $arr[]=$row;
		}
		if($total==1 && $data['totalRowCount']>0){
		    $arr['total']=$data['totalRowCount'];
		}
		return $arr;
	}
	
	function do_ad_url($url){
	    $arr=explode('?',$url);
		parse_str($arr[1],$param);
		$param['w']=$this->wid;
		$param['u']=$this->uid;
		$param['e']=$this->e;
		$p=param2str($param);
		$url=$arr[0].'?'.$p;
		if(isset($arr[2])){
		    $url.='?'.$arr[2];
		}
		return $url;
	}
}
?>