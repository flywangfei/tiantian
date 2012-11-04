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

if($_POST['sub']!=''){
    include DDROOT.'/comm/readxls.php'; 
	$uptypes=array('application/vnd.ms-excel'); 
    $max_file_size=5000000;   //上传文件大小限制, 单位BYTE
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	    if (!is_uploaded_file($_FILES["upfile"]['tmp_name'])){  //是否存在文件
		    echo "<font color='red'>文件不存在！</font>";
		    exit;
	    }

	    $file = $_FILES["upfile"];
	    if ($max_file_size < $file["size"]){
		    echo "<font color='red'>文件太大！</font>";
		    exit;
	    }

	    /*if (!in_array($file["type"], $uptypes)){
		    echo "<font color='red'>只能上传xls！</font>";
		    exit;
	    }*/

	    $data = new Spreadsheet_Excel_Reader();
	    $data->setOutputEncoding('utf-8');
	    $data->read($_FILES["upfile"]['tmp_name']);
	    unset($data->sheets[0]['cells'][1]);
		$update_num=0;
		$insert_num=0;
	    foreach($data->sheets[0]['cells'] as $row){
			unset($arr);
		    $arr['item_title']=str_replace("'","",$row[2]);
		    $arr['shop_title']=str_replace("'","",$row[4]);
			$arr['commission']=$row[11];
			if($row[7]!='0.00%'){
				$commission_rate=$row[7];
			}
			elseif($row[9]!='0.00%'){
				$commission_rate=$row[9];
			}
			$arr['commission_rate']=sprintf("%01.3f", str_replace('%','',$commission_rate)/100);

		    $arr['fxje']=fenduan($arr['commission'],$webset['fxbl'],0);
			$arr['jifen']=round($arr['fxje']*$webset['jifenbl'],2);
			$arr['pay_time']=$row[1];
			$arr['pay_price']=$row[5];
			$arr['real_pay_fee']=$arr['pay_price'];
			$arr['num_iid']=$row[3];
			$arr['item_num']=$row[6];
			$arr['trade_id']=$row[12];
			$arr['outer_code']='';
			$arr['uid']=0;
			$arr['tgyj']=0;
			$id=$duoduo->select('tradelist','id','trade_id="'.$arr['trade_id'].'"');
			if($id>0){
			    $duoduo->update('tradelist',$arr,'id="'.$id.'"');
				$update_num++;
			}
			else{
			    $duoduo->insert('tradelist',$arr);
				$insert_num++;
			}
		}
	}
	jump(-1,'导入订单'.$insert_num.'条，更新订单'.$update_num.'条！');
}
else{

}