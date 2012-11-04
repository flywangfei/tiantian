<?php
class duoduo {

	public $link;
	public $webset;
	
	public $dbserver;
	public $dbuser;
	public $dbpass;
	public $dbname;
	public $BIAOTOU;
	
	function connect(){
	    $this->link = mysql_connect($this->dbserver, $this->dbuser, $this->dbpass);
		if(!$this->link){echo '数据库连接失败！';exit;}
		$query=$this->select_db($this->dbname);
		if($query!=1){
			$sql = "CREATE DATABASE IF NOT EXISTS `".$this->dbname."` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";
			$query=$this->query($sql);
			if($query==''){
				dd_exit('没有创建数据库的权限');
			}
			$this->select_db($this->dbname);
		}
		$this->query("set names utf8");
		return $this->link;
	}
	
	function select_db($dbname){
	    return mysql_select_db($dbname,$this->link);
	}
	
	function ping(){
	    if(mysql_ping()==''){
		    $this->close();
			$this->connect();
		}
	}
	
	function close(){
	    mysql_close($this->link);
	}

	function query($sql,$alert=0) {
		if($alert==1){
			echo $sql;
		}
		if($this->webset['sql_log']==1){
			$str=$sql.'-----'.get_client_ip().'-----'.date('H:i:s')."\r\n";
			$filename=DDROOT.'/data/temp/sql/'.date('Ym').'/'.date('d').'_'.md5(DDKEY).'.php';
			create_file($filename,$str,1,1);
		}
		$query=mysql_query($sql,$this->link);
		if($query==''){
			if($this->webset['sql_debug']==1){
				$filename=DDROOT.'/data/temp/error_sql/'.date('Ym').'/'.date('d').'_'.md5(DDKEY).'.php';
				create_file($filename,$this->error().'---'.$sql."\r\n",1,1);
				//echo $this->error().'<br/>'.$sql;exit;
			}
		}
		else{
			return $query;
		}
	}

	function fetch_array($query, $result_type = MYSQL_ASSOC) {
		return mysql_fetch_array($query, $result_type);
	}
	
	function num_rows($query){
	    return mysql_num_rows($query);
	}
	
	function insert_id(){
	    return mysql_insert_id($this->link);
	}
	
	function free_result(&$query){
		$re=mysql_free_result($query);
		/*if($re!=1){
		    print_r(debug_backtrace());
			exit;
		}*/
	}
	
	function real_escape_string($var){
		return $var=mysql_real_escape_string($var);
	}

	function error() {
		return mysql_error();
	}
	
	function get_version($isformat = true) {
	    $rs = $this->query("SELECT VERSION();");
	    $row = $this->fetch_array($rs,MYSQL_NUM);
	    $mysql_version = $row[0];
	    $this->free_result($rs);
	    if ($isformat) {
		    $mysql_versions = explode(".", trim($mysql_version));
		    $mysql_version = number_format($mysql_versions[0] . "." . $mysql_versions[1], 2);
	    }
	    return $mysql_version;
    }
	
	public function con($a) {
		if(!is_array($a)) return $a;
		$where = '';
		$temp=array();
		$i = 0;
		if(!is_array($a[0])){
		    foreach($a as $k=>$v){
    	        $temp[]=$k."='".$v."'";
            }
			$where='where '.implode(' and ',$temp);
		}
		else{
		    foreach ($a as $row) {
			    if ($i == 0) {
				    $where .= ' where ';
			    } else {
				    if ($row['c'] == '') {
					    $where .= ' and ';
				    } else {
					    $where .= ' ' . $row['c'] . ' ';
				    }

			    }
			    if ($row['e'] == '') {
				    $row['e'] = '=';
			    }
			    $where .= $row['f'] . ' ' . $row['e'] . ' "' . $row['v'] . '"';
			    $i++;
		    }
		}
		return $where;
	}
	
	function get_query_conditions($query_item){
        foreach($query_item as $row){
			if($row['f']!=''){
			    if($row['v']!=='' && $row['v']!=='%%'){
					if(isset($row['equal']) && $row['equal']=='in'){
					    $str1[] = $row['f']." ".$row['e']." ".$row['v'];
					}
					else{
					    $str1[] = $row['f']." ".$row['e']." '".$row['v']."'";
					}
			    }
			}
			else{
			    foreach($row as $arr){
				    if($arr['v']!=='' && $arr['v']!=='%%'){
						if($arr['e']=='in'){
						    $str2[] = $arr['f']." ".$arr['e']." ".$arr['v'];
						}
						else{
						    $str2[] = $arr['f']." ".$arr['e']." '".$arr['v']."'";
						}
			        }
				}
				if($str2[1]!=''){
					$str3='('.implode(' or ',$str2).')';
				}
				elseif($str2[1]=='' && $str2[0]!=''){
				    $str3=$str2[0];
				}
				else{
				    $str3='';
				}
			}
			
        }
		if(isset($str3) && $str3!='') $str1[]=$str3;
		if($str1[1]!=''){
			return implode(' and ',$str1);
		}
		elseif($str1[1]=='' && $str1[0]!=''){
			return $str1[0];
		}
		else{
			 return '1=1';
		}
    }
	
	function sql_to_array($sql){
		$query=$this->query($sql);
		while ($row = $this->fetch_array($query)) {
			$arr[]=$row;
		}
		//if(!isset($arr[1])){$arr=$arr[0];}
		$this->free_result($query);
		return $arr;
	}
	
	function select2arr($sql,$x=0) {
		$query = $this->query($sql);
		while ($row = $this->fetch_array($query)) {
			$arr[] = $row;
		}
		if($x==0){
		    $re = $arr;
		}
		else{
		    $re = $arr[0];
		}
		$this->free_result($query);
		if(!is_array($re)){$re=array();}
		return $re;
	}

	function select($table, $sel_field, $where='1', $alert = 0) {
		$arr='';

		if(strstr($table,',')!=''){
		    $table=str_replace(',',','.$this->BIAOTOU,$table);
		}
		$sql = "select $sel_field from " . $this->BIAOTOU . $table . " where $where limit 1";
		if ($alert == 1) {
			echo $sql;
		}
		$query = $this->query($sql);
		if ($query!='') {
			while ($row = $this->fetch_array($query)) {
				if(strpos($sel_field, ",")!==false or strpos($sel_field, "*")!==false) {
					$arr = $row;
				} 
				else{
					$arr = array_pop($row);
				}
			}
			$this->free_result($query);
		}
		return $arr;
	}
	
	function select_all($table, $sel_field, $where='1=1', $alert = 0) {
		$arr = array ();
		if(strstr($table,',')!=''){
		    $table=str_replace(',',','.$this->BIAOTOU,$table);
		}
		$sql = "select $sel_field from ".$this->BIAOTOU.$table." where $where ";
		if ($alert == 1) {
			echo $sql;
		}
		$query = $this->query($sql);
		if ($query!='') {
			while ($row = $this->fetch_array($query)) {
				$arr[] = $row;
			}
			$this->free_result($query);
		}
		return $arr;
	}
	
	function select_all_key($table, $sel_field, $where='1=1', $key='id', $alert = 0) {
		$arr = array ();
		if(strstr($table,',')!=''){
		    $table=str_replace(',',','.$this->BIAOTOU,$table);
		}
		$sql = "select $sel_field from ".$this->BIAOTOU.$table." where $where ";
		if ($alert == 1) {
			echo $sql;
		}
		$query = $this->query($sql);
		if ($query!='') {
			while ($row = $this->fetch_array($query)) {
				$arr[$row[$key]] = $row;
			}
			$this->free_result($query);
		}
		return $arr;
	}
	
	function select_1_field($table, $sel_field='title', $where='1=1', $alert = 0) { //1个字段，输出一维数组
		$sql = "select $sel_field from ".$this->BIAOTOU.$table." where $where ";
		if ($alert == 1) {
			echo $sql;
		}
		$query = $this->query($sql);
		if ($query!='') {
			while ($row = $this->fetch_array($query,MYSQL_NUM)) {
				$arr[] = $row[0];
			}
			$this->free_result($query);
		}
		return $arr;
	}
	
	function select_2_field($table, $sel_field='id,title', $where='1=1', $alert = 0) { //2个字段，输出一维数组，第一个字段是键名，第二个字段是键值
		$sql = "select $sel_field from ".$this->BIAOTOU.$table." where $where ";
		if ($alert == 1) {
			echo $sql;
		}
		$query = $this->query($sql);
		if ($query!='') {
			while ($row = $this->fetch_array($query,MYSQL_NUM)) {
				$arr[$row[0]] = $row[1];
			}
			$this->free_result($query);
		}
		return $arr;
	}
	
	function select_3_field($table, $sel_field='id,title,content', $where='1=1', $alert = 0) { //3个字段，输出二维数组，第一个字段是键名，第二，三组成数字作为子数组
		$field_arr=explode(',',$sel_field);
		$sql = "select $sel_field from ".$this->BIAOTOU.$table." where $where ";
		if ($alert == 1) {
			echo $sql;
		}
		$query = $this->query($sql);
		if ($query!='') {
			while ($row = $this->fetch_array($query)) {
				$arr[$row[$field_arr[0]]] = array($field_arr[1]=>$row[$field_arr[1]],$field_arr[2]=>$row[$field_arr[2]]);
			}
			$this->free_result($query);
		}
		return $arr;
	}
	
    function update($table, $set_con_arr, $where,$limit=1,$alert = 0) {
		$set = '';
	    if (!array_key_exists(0,$set_con_arr)) {
		    $set_arr[0] = $set_con_arr;
	    } else {
		    $set_arr = $set_con_arr;
	    }

	    if(!array_key_exists('f',$set_arr[0])){
            foreach ($set_arr[0] as $k => $v) {

            	$set = "`$k`='$v'," . $set;
            }
			$set = substr($set, 0, strlen($set) - 1);
	    }
        else{
        	foreach ($set_arr as $k => $v) {
		        if (!isset($v['e']) || $v['e'] == '' || $v['e']=='=') {
			        $temp[] = "`" . $v['f'] . "`='" . $v['v'] . "'";
		        } else {
			        $temp[] = "`" . $v['f'] . "`=`" . $v['f'] . "`" . $v['e'] . "'" . $v['v'] . "'";
		        }
	        }
	        $set = implode(',', $temp);
        }
	    if($limit==0){
			$limit='';
		}
		elseif($limit>0){
			$limit=' limit '.$limit;
		}
	    $sql = "update " . $this->BIAOTOU . $table . " set " . $set . " where " . $where . $limit;
		if ($alert == 0) {
			$this->query($sql);
			return $set_arr;
		}
		elseif ($alert == 1) {
			$this->query($sql);
			echo $sql;
		}
	}
	
	function update_serialize($field,$key,$value,$alert=0){
	    $str=$this->select('webset','val','var="'.$field.'"');
		$row=unserialize($str);
		$row[$key]=$value;
		$data=array('val'=>serialize($row));
		$this->update('webset',$data,'var="'.$field.'"');
	}
	
	function insert($table, $field_arr, $alert = 0) {
		$field = "";
		$values = "";
		foreach ($field_arr as $k => $v) {
			$field = "`" . $k . "`," . $field;
			$values = "'" . $v . "'," . $values;
		}
		$field = substr($field, 0, strlen($field) - 1);
		$values = substr($values, 0, strlen($values) - 1);
		$sql = 'insert into '.$this->BIAOTOU.$table.'('.$field.') values ('.$values.');';
		$query = $this->query($sql);
		if ($query!=''){
			$re = $this->insert_id();
		}
	    else{
			$re = $this->error();
		}
		if ($alert == 1) {
			echo $sql . "<br/>";
		}
		return $re;
	}
	
	function admin_log($do){
		$data=array('mod'=>MOD,'admin_name'=>$_SESSION['ddadmin']['name'],'addtime'=>TIME,'ip'=>get_client_ip(),'do'=>$do);
		$this->insert('adminlog',$data);
		if(rand(1,10)==1){  //十分之一的概率删除7天前的日志
			$this->delete('adminlog','addtime<"'.(TIME-3600*24*7).'"'); 
		}
	}
	
	function mingxi_insert($field_arr, $alert = 0) {
		$money=$this->select('user','money','id="'.$field_arr['uid'].'"');
		$field_arr['leave_money']=$money;
		if(!array_key_exists('addtime',$field_arr)){
			$field_arr['addtime']=date('Y-m-d H:i:s');
	    }
		return $this->insert('mingxi',$field_arr,$alert);
	}
	
	function msg_insert($data, $msgset_id=0, $msgset = ''){ //带有站内信id，启用站内信模板，否则需要data带有title和content
		$send_web=0;
		$send_email=0;
		$send_sms=0;
        if($msgset_id>0 || !empty($msgset)){
			if($msgset_id>0){
				$m=dd_get_cache('msgset');
				$msgset=$m[$msgset_id];
			}
		    
			$title= $msgset['title'];
			$web_content=$msgset['web'];
			$sms_content=$msgset['sms'];
			$email_content=$msgset['email'];

			if($web_content!='' && $data['uid']>0){
				preg_match_all('/\{(.*?)\}/',$web_content,$arr);
        		foreach($arr[0] as $k=>$v){
	        		$web_content=str_replace($v,$data[$arr[1][$k]],$web_content);
        		}
				$send_web=1;
			}
			
			if($this->webset['sms'][$msgset_id.'_send']==1 && $data['mobile']!='' && $sms_content!=''){
				preg_match_all('/\{(.*?)\}/',$email_content,$arr);
        		foreach($arr[0] as $k=>$v){
	        		$sms_content=str_replace($v,$data[$arr[1][$k]],$sms_content);
        		}
				$send_sms=1;
			}
			
			if($this->webset['email_notice'][$msgset_id.'_send']==1 && $data['email']!='' && $email_content!=''){
				preg_match_all('/\{(.*?)\}/',$email_content,$arr);
        		foreach($arr[0] as $k=>$v){
	        		$email_content=str_replace($v,$data[$arr[1][$k]],$email_content);
        		}
				$send_email=1;
			}
		}
		else{
		    $title=$data['title'];
			$content=$data['content'];
		}
		
		$re_status=array(0,0,0);
		
		if($send_web==1){
			$field_arr['addtime']=date('Y-m-d H:i:s');
			$field_arr['see']=0;
			$field_arr['senduser']=0;
			$field_arr['uid']=$data['uid'];
			$field_arr['title']=$title;
			$field_arr['content']=$web_content;
			$id=$this->insert('msg',$field_arr);
			if($id>0){
				$re_status[0]=1;
			}
		}
		
		if($send_sms==1){
			$re=sms_send($this->webset['sms']['name'],$this->webset['sms']['pwd'],$date['mobile'],$sms_content);
			if($re['Code']==0){
				$re_status[1]=1;
			}
		}
		
		if($send_email==1){
			if($this->webset['smtp']['xingshi']==0){
				$url=SITEURL.'/'.u('ajax','send_mail',array('email'=>$data['email'],'title'=>$title,'content'=>$email_content,'token'=>authcode(TIME,'ENCODE')));
				only_send($url,'post');
			}
			else{
				mail_send($data['email'], $title, $email_content);
			}
			$re_status[2]=1;
			/*$re=mail_send($data['email'], $title, $email_content);
			if($re>0){
				$re_status[2]=1;
			}*/
		}
		
		return $web_content;
	}
	
	function replace($table, $field_arr, $alert = 0) {
		$field = "";
		$values = "";
		foreach ($field_arr as $k => $v) {
			$field = "`" . $k . "`," . $field;
			$values = "'" . $v . "'," . $values;
		}
		$field = substr($field, 0, strlen($field) - 1);
		$values = substr($values, 0, strlen($values) - 1);
		$sql = "replace into $this->BIAOTOU$table($field) values ($values);";
		$query = $this->query($sql);
		if ($alert == 0) {
			if ($query)
				return mysql_insert_id();
			else
				return $this->error();
		}
		elseif ($alert == 1) {
			echo $sql . "<br/>";
		}
		elseif ($alert == 2) {
			echo $sql;
			if ($query)
				return mysql_insert_id();
			else
				return $this->error();
		}
	}
	
	function left_join($table, $join, $sel_field, $where='1=1', $alert = 0) {
		$arr = array ();
		$sql = "select $sel_field from ".$this->BIAOTOU.$table." LEFT JOIN ".$this->BIAOTOU.$join." where $where ";
		if ($alert == 1) {
			echo $sql;
		}
		$query = $this->query($sql);
		if ($query!='') {
			while ($row = $this->fetch_array($query)) {
				$arr[] = $row;
			}
			$this->free_result($query);
		}
		return $arr;
	}
	
	function sel_one_arr_sql($table, $sel_field, $where, $alert = 0) {
		$arr = array ();
		if(strstr($table,',')!=''){
		    $table=str_replace(',',','.$this->BIAOTOU,$table);
		}
		$sql = "select $sel_field from ".$this->BIAOTOU.$table." where $where ";
		if ($alert == 1) {
			echo $sql;
		}
		$query = $this->query($sql);
		if ($query!='') {
			while ($row = $this->fetch_array($query)) {
				$arr[] = $row[$sel_field];
			}
			$this->free_result($query);
		}
		return $arr;
	}
	
	function sel_page_sql($table, $sel_field, $where, $frmnum ,$pagesize) {
		$arr = array ();
		if($frmnum>=1000){ //自己估算的临界点
		    $sql="select $sel_field From ".$this->BIAOTOU.$table." Where id >=(Select id From ".$this->BIAOTOU.$table." Order By id limit $frmnum,1) and ".$where." limit $pagesize";
		}
		else{
		    $sql = "select $sel_field from ".$this->BIAOTOU.$table." where $where limit $frmnum ,$pagesize";
		}
		$query = $this->query($sql);
		if ($query!='') {
			while ($row = $this->fetch_array($query)) {
				$arr[] = $row;
			}
			$this->free_result($query);
		}
		return $arr;
	}

	function count($table,$where='',$alert=0){
		if($where!=''){$where ='where '.$where;}
		if(strpos($table,',')!==false){
		    $table=str_replace(',',','.$this->BIAOTOU,$table);
		}
	    $sql='select count(1) as num from '.$this->BIAOTOU.$table." ".$where;
		if($alert==1){
		    echo $sql;
		}
	    $query = $this->query($sql);
	    $row=$this->fetch_array($query);
		$this->free_result($query);
	    return $row['num']?$row['num']:0;
    }
	
	function count_orther($table,$where='',$alert=0){
		if($where!=''){$where ='where '.$where;}
		if(strpos($table,',')!==false){
		    $table=str_replace(',',',',$table);
		}
	    $sql='select count(1) as num from '.$table." ".$where;
		if($alert==1){
		    echo $sql;
		}
	    $query = $this->query($sql);
	    $row=$this->fetch_array($query);
		$this->free_result($query);
	    return $row['num']?$row['num']:0;
    }
	
	function sum($table,$count_field,$where='1=1'){
		if($where!=''){$where ='where '.$where;}
		if(strpos($table,',')!==false){
		    $table=str_replace(',',','.$this->BIAOTOU,$table);
		}
		$select_field='';
		if(strpos($count_field,',')!==false){
			$field_arr=explode(',',$count_field);
			foreach($field_arr as $k=>$v){
				$select_field.='sum(`'.$v.'`) as `'.$v.'`,';
			}
			$select_field=preg_replace('/,$/','',$select_field);
		}
		else{
			$select_field='sum('.$count_field.') as sum';
		}
	    $sql="select ".$select_field." from ".$this->BIAOTOU.$table." ".$where;
	    $query = $this->query($sql);
	    $row=$this->fetch_array($query);
		$this->free_result($query);
		if(count($row)==1){
			return $row['sum']?round($row['sum'],2):0;
		}
	    else{
			foreach($row as $k=>$v){
				$row[$k]=(float)$v;
			}
			return $row;
		}
    }
	
	function delete($table,$where,$alert=0){
	    $sql="delete from ".$this->BIAOTOU.$table." where $where";
		$query = $this->query($sql);
		if($alert==1){
		    echo $sql;
		}
		if($query!=''){return 1;}
		else{return mysql_error();}
	}
	
	function delete_id_in($ids,$table=MOD,$alert=0){
	    $where="id IN(".$ids.")";
		$re=$this->delete($table,$where,$alert=0);
		return $re;
	}
	
	function creat_table($name, $field) {
		if (!array_key_exists('duoduo_table_index', $field)) { //如果没有标明索引key，默认一个空
			$field['duoduo_table_index'] = '';
		}

		$sql = 'DROP TABLE IF EXISTS `' . $this->BIAOTOU . $name . '`;';
		$this->query($sql);
		$sql = 'CREATE TABLE `' . $this->BIAOTOU . $name . '` (';
		foreach ($field as $k => $v) {
			if ($k != 'duoduo_table_index') {
				$sql .= '`' . $k . '` ' . $v . ',';
			} else {
				if($v!=''){
				    $sql .= $v;
				}
			}
		}
		$sql .= ') ENGINE=MyISAM DEFAULT CHARSET=utf8;';
		$query=$this->query($sql);
		return $query;
	}
	
	function delete_table($table){
		$query=$this->query("show tables like '".$this->BIAOTOU.$table."'"); 
		$row=$this->fetch_array($query);
		if(!empty($row)){
		    $sql="DROP TABLE `".$this->BIAOTOU.$table."` ";
		    $query=$this->query($sql);
		}
		else{
		    return $this->error();
		}
	}
	
	function show_fields($table,$field=''){
		$query=$this->query('show fields from `'.$this->BIAOTOU.$table.'`;');
		$field_arr=array();
        while($arr=$this->fetch_array($query)){
		    $field_arr[]=$arr['Field'];
		}
		$this->free_result($query);
		if($field==''){
			return $field_arr;
		}
		else{
			if(in_array($field,$field_arr)){
				return 1;
			}
			else{
				return 0;
			}
		}
	}

	function reapaire_field($table, $field_name, $field_info) {
		$sql = "ALTER TABLE `" . $this->BIAOTOU . $table . "` add `" . $field_name . '` ' . $field_info . ";";
		$this->query($sql);
	}
	
function set_constants($table) {
	$data = array ();
	$sql = "show fields from " . $this->BIAOTOU . $table; //得到全表信息
	$query = $this->query($sql);
	while ($row = $this->fetch_array($query)) {
		$data[] = str_replace('_', '', strtoupper($row['Field']));
	}

	$data = array_diff($data, array ('ID'));

	$sql = "select * from " . $this->BIAOTOU .$table." where id=1";
	$query = $this->query($sql);
	$i = 1;
	$set = $this->fetch_array($query, MYSQL_NUM);

	for ($i = 1; $i < count($set); $i++) {
		define($data[$i], $set[$i]);
	}
	define('SITEURL', 'http://'.URL);
}

	//////////////////////////////////////////////////////////////////////////////////////////
	
	public function do_report($row){ //淘宝获取订单处理办法
	    if($row['outer_code']=='null'){$row['outer_code']='';}
		$row['trade_id']=number_format($row['trade_id'],0,'',''); //处理json将数字变成科学计数法的错误
		$id=$this->select('tradelist', 'id', 'trade_id="'.$row['trade_id'].'"');
		if($id>0){ return false;} //订单存在，处理结束
		$i=0; //插入订单
		$j=0; //返利订单

		$row['uid']=$row['outer_code']?$row['outer_code']:0;
		if($row['uid']>0){
		    $user=$this->select('user','id,ddusername,level,tjr','id="'.$row['uid'].'"');
			
			$row['fxje']=fenduan($row['commission'],$this->webset['fxbl'],$user['level']);
			$row['jifen']=round($row['fxje']*$this->webset['jifenbl']);
			
			if($user['id']>0){   //会员存在，添加确认时间
			    $row['qrsj']=TIME;
				$row['checked']=2;
		    }
			if($user['tjr']>0){
			    $tjr_user=$this->select('user','id,ddusername','id="'.$user['tjr'].'"');
		        if($tjr_user['id']>0){
			        $user['tjr_name']=$tjr_user['ddusername'];
				    $row['tgyj']=round($row['fxje']*$this->webset['tgbl'],2);;
		        }
		    }
		} 
		else{
			$row['fxje']=fenduan($row['commission'],$this->webset['fxbl'],0);
			$row['jifen']=round($row['fxje']*$this->webset['jifenbl']);
		}
		
		$row['item_title']=addslashes($row['item_title']);
		$row['shop_title']=addslashes($row['shop_title']);
		$row['outer_code']=$row['outer_code']?$row['outer_code']:'';
		$row['app_key']=(int)$row['app_key'];
		$row['relate_id']=$this->insert('tradelist',$row);
		if($user['id']>0 && $row['relate_id']>0){
		    $this->rebate($user,$row,2);
	    }
	}
	
	public function do_paipai_report($row){ //拍拍获取订单处理办法
		$id=$this->select('paipai_order', 'id', 'dealId="'.$row['dealId'].'"');
		if($id>0){ return false;} //订单存在，处理结束
		$i=0; //插入订单
		$j=0; //返利订单
		
		$row['discount']=round($row['discount']/10000,2); //佣金比率
		$row['careAmount']=round($row['careAmount']/100,2); //实际付款
		$row['commission']=round($row['brokeragePrice']/100,2); //佣金
		unset($row['brokeragePrice']);
		
		$row['uid']=$row['outInfo']?$row['outInfo']:0;
		if($row['uid']>0){
		    $user=$this->select('user','id,ddusername,level,tjr','id="'.$row['uid'].'"');
			
			$row['fxje']=fenduan($row['commission'],$this->webset['paipaifxbl'],$user['level']);
			$row['jifen']=round($row['fxje']*$this->webset['jifenbl']);
			
			if($user['id']>0){   //会员存在，添加确认时间
			    $row['addtime']=TIME;
				$row['checked']=2;
		    }
		} 
		else{
			$row['fxje']=fenduan($row['commission'],$this->webset['paipaifxbl'],0);
			$row['jifen']=round($row['fxje']*$this->webset['jifenbl']);
		}
		
		$row['commName']=addslashes($row['commName']);
		$row['shopName']=addslashes($row['shopName']);
		$row['outInfo']=$row['outInfo']?$row['outInfo']:'';
		$row['relate_id']=$this->insert('paipai_order',$row);
		if($user['id']>0 && $row['relate_id']>0){
		    $this->rebate($user,$row,17);
	    }
	}
	
	public function rebate($user,$trade,$shijian=0){ //user数组包含会员名，会员id，会员等级，推荐人  trade数组包含订单全部信息，带有id号说明是找回订单
	    if($shijian==0){
		    exit('缺少指定事件');
		}
		
		//判断订单来源
		if(isset($trade['trade_id'])){
		    $dingdan='taobao';
			$fxbl=$this->webset['fxbl'];
			$trade_id=$trade['trade_id'];
		}
		elseif(isset($trade['order_code'])){
		    $dingdan='mall';
			$fxbl=$this->webset['mallfxbl'];
			$trade_id=$trade['mall_name'].'返利，订单号'.$trade['order_code'];
		}
		elseif(isset($trade['dealId'])){
		    $dingdan='paipai';
			$fxbl=$this->webset['paipaifxbl'];
			$trade_id=$trade['dealId'];
		}
		
		$tgyj=0;
		$user['name']=$user['ddusername']?$user['ddusername']:$user['name'];
		if($user['tjr']>0){
			$tjr_user=$this->select('user','id,ddusername','id="'.$user['tjr'].'"');
		    if($tjr_user['id']>0 && $trade['fxje']>0){
			    $user['tjr_name']=$tjr_user['ddusername'];
				$have_tgyj=1;
		    }
		}

		if($trade['id']>0){  //如果是找回订单（前台和后台），带有订单id，从新计算返利值
			$trade['relate_id']=$trade['id'];
		    $fxje=fenduan($trade['commission'],$fxbl,$user['level']);
		    $jifen=round($fxje*$this->webset['jifenbl']);
			if($trade['fxje']==0){
				$fxje=0;
			}
			if($have_tgyj==1){
			    $tgyj=round($fxje*$this->webset['tgbl'],2);
			}
			
			//判断是淘宝订单还是商城订单
		    if($dingdan=='taobao'){
		        $data=array('fxje'=>$fxje,'jifen'=>$jifen,'tgyj'=>$tgyj,'qrsj'=>TIME,'outer_code'=>$user['id'],'uid'=>$user['id'],'checked'=>2);
				if(array_key_exists('ddjt',$trade)){
				    $data['ddjt']=$trade['ddjt'];
				}
			    $this->update('tradelist',$data,'id="'.$trade['id'].'"');
		    }
			elseif($dingdan=='paipai'){
		        $data=array('fxje'=>$fxje,'jifen'=>$jifen,'tgyj'=>$tgyj,'addtime'=>TIME,'outInfo'=>$user['id'],'uid'=>$user['id'],'checked'=>2);
			    $this->update('paipai_order',$data,'id="'.$trade['id'].'"');
		    }
		    elseif($dingdan=='mall'){
		        $data=array('fxje'=>$fxje,'jifen'=>$jifen,'tgyj'=>$tgyj,'qrsj'=>TIME,'uid'=>$user['id'],'status'=>1);
			    $this->update('mall_order',$data,'id="'.$trade['id'].'"');
		    }
		}
		else{
		    $fxje=$trade['fxje'];
		    $jifen=$trade['jifen'];
			if($have_tgyj==1){
			    $tgyj=round($fxje*$this->webset['tgbl'],2);
			}
		}
	
		//给会员加返利，等级，积分
		$set_con_arr=array(array('f'=>'money','v'=>$fxje,'e'=>'+'),array('f'=>'level','v'=>1,'e'=>'+'),array('f'=>'jifen','v'=>$jifen,'e'=>'+'));
		if($fxje>=$this->webset['taoapi']['freeze_limit'] && $this->webset['taoapi']['freeze']==1 && $dingdan=='taobao'){ //淘宝订单有冻结返利
			$freeze=1;
		}
		else{
			$freeze=0;
		}
		$this->update_user_mingxi($set_con_arr, $user['id'],$shijian,$trade_id,0,$freeze,$trade['pay_time'],$trade['relate_id']); //冻结佣金，带有下单时间
		//推广佣金
		if($tgyj>0){
			$set_con_arr=array('f'=>'money','v'=>$tgyj,'e'=>'+');
			if($tgyj>=$this->webset['taoapi']['freeze_limit'] && $this->webset['taoapi']['freeze']==1 && $dingdan=='taobao'){
				$freeze=1;
			}
			else{
				$freeze=0;
			}
		    $this->update_user_mingxi($set_con_arr, $user['tjr'],6,$user['name'],0,$freeze,$trade['pay_time'],$trade['relate_id']); //冻结佣金，带有下单时间
		}
	}
	
	function refund($id,$do=1){
	    $trade=$this->select('tradelist','id,outer_code,checked,fxje,jifen,tgyj,trade_id,commission,uid,pay_time','id="'.$id.'" and checked<>-1');
		$trade_id=$trade['trade_id'];
		
		if($trade['id']>0 && $trade['uid']>0){
		    $user=$this->select('user','ddusername,tjr,txstatus,money,dhstate,email,mobile,mobile_test','id="'.$trade['uid'].'"');
			if($user['ddusername']!=''){ //会员存在，剪掉金额，积分，等级
				$data=array(array('f'=>'money','e'=>'+','v'=>-$trade['fxje']),array('f'=>'jifen','e'=>'+','v'=>-$trade['jifen']),array('f'=>'level','e'=>'-','v'=>1));
				if($user['txstatus']==1 && $user['money']-$trade['fxje']<0){ //如果会员处在提现中并且现有金额小于退款金额，取消提现状态
					$why='您的淘宝订单'.$trade_id.'发生退款，所以取消本次提现';
					$tixian=$this->select('tixian','id,money','uid="'.$trade['uid'].'" order by id desc');
					$user_data[]=array('f'=>'money','e'=>'+','v'=>$tixian['money']);
					$user_data[]=array('f'=>'txstatus','e'=>'=','v'=>0);
					$msg_data=array('uid'=>$trade['uid'],'money'=>$tixian['money'],'why'=>$why,'email'=>$user['email']);
					if($user['mobile_test']==1){
						$msg_data['mobile']=$user['mobile'];
					}
		            $msg=$this->msg_insert($msg_data,3); //提现失败3号站内信
		            $tixian_data=array('f'=>'status','e'=>'=','v'=>'2');
					$this->update('tixian',$tixian_data,'id="'.$tixian['id'].'"');
					$this->update('user',$user_data,'id="'.$trade['uid'].'"');
				}
				if($user['dhstate']==1){ //如果会员处在兑换中
					$why='您的淘宝订单'.$trade_id.'发生退款，所以取消本次兑换';
					$msg_data=array('uid'=>$trade['uid'],$why,'goods_title'=>$duihuan['goods_title'],'email'=>$user['email']);
					if($user['mobile_test']==1){
						$msg_data['mobile']=$user['mobile'];
					}
					
					$duihuan=$this->select('duihuan as a,huan_goods as b','a.id,a.spend,a.mode a.title as goods_title','a.uid="'.$trade['uid'].'" and a.huan_goods_id=b.id order by a.id desc');
					if($mode==1 && $user['money']-$duihuan['spend']){  //金额兑换，现有金额小于退款金额，取消本次兑换
                        $user_data[]=array('f'=>'money','e'=>'+','v'=>$duihuan['spend']);
						$user_data[]=array('f'=>'dhstate','e'=>'=','v'=>0);
		                $this->msg_insert($msg_data,5); //兑换失败5号站内信
		                $duihuan_data=array('f'=>'status','e'=>'=','v'=>'2');
						$this->update('duihuan',$duihuan_data,'id="'.$duihuan['id'].'"');
						$this->update('user',$user_data,'id="'.$trade['uid'].'"');
					}
					elseif($mode==2 && $user['jifen']-$duihuan['spend']){  //积分兑换，现有积分小于退款积分，取消本次兑换
					    $user_data[]=array('f'=>'jifen','e'=>'+','v'=>$duihuan['spend']);
						$user_data[]=array('f'=>'dhstate','e'=>'=','v'=>0);
		                $this->msg_insert($msg_data,5); //兑换失败5号站内信
		                $duihuan_data=array('f'=>'status','e'=>'=','v'=>'2');
						$this->update('duihuan',$duihuan_data,'id="'.$duihuan['id'].'"');
						$this->update('user',$user_data,'id="'.$trade['uid'].'"');
					}
				}
				$mingxi_id=12+$do; //明细id，do为1是退款，明细id是13，do为2是删除，明细id是14
				if($this->webset['taoapi']['freeze']==1){ //冻结类型1，减去冻结佣金
					$d=date('Ym',strtotime($trade['pay_time']));
					$income_id=$this->select('income','id','uid="'.$trade['uid'].'" and date="'.$d.'"');
					if($income_id>0){
						$data=array(array('f'=>'money','e'=>'-','v'=>$trade['fxje']),array('f'=>'jifen','e'=>'-','v'=>$trade['jifen']));
						$this->update('income',$data,'id="'.$income_id.'"');
						$mingxi_data=array('uid'=>$trade['uid'],'money'=>-$trade['fxje'],'jifen'=>-$trade['jifen'],'shijian'=>$mingxi_id,'source'=>$trade_id);
						$this->mingxi_insert($data);
					}
				}
				else{
					$this->update_user_mingxi($data,$trade['uid'],$mingxi_id,$trade_id);
				}
			}
			else{
			    return '没有确认用户！';
			}
			if($trade['tgyj']>0 && $user['tjr']>0){
				if($this->webset['taoapi']['freeze']==1){ //冻结类型1，减去冻结佣金
					$income_id=$this->select('income','id','uid="'.$user['tjr'].'" and date="'.$d.'"');
					if($income_id>0){
						$data=array(array('f'=>'money','e'=>'-','v'=>$trade['tgyj']));
						$this->update('income',$data,'id="'.$income_id.'"');
						$mingxi_data=array('uid'=>$user['tjr'],'money'=>-$trade['tgyj'],'shijian'=>15,'source'=>$user['ddusername']);
						$this->mingxi_insert($data);
					}
				}
				else{
					$data=array(array('f'=>'money','e'=>'+','v'=>-$trade['tgyj']));
					$this->update_user_mingxi($data,$user['tjr'],15,$user['ddusername']);
				}
			}
		}
		if($do==1){  //退款订单
			$data=array('checked'=>-1);
			$this->update('tradelist',$data,'id="'.$trade['id'].'"');
			$word='完成退款';
		}
		elseif($do==2){  //删除订单
			$this->delete('tradelist','id="'.$trade['id'].'"');
			$word='完成删除';
		}
		$msg_data=array('uid'=>$trade['uid'],'trade_id'=>$trade_id,'email'=>$user['mobile']);
		if($user['mobile_test']==1){
			$msg_data['mobile']=$user['mobile'];
		}
		$msg=$this->msg_insert($msg_data,7); //退款7号站内信
		return $word;
	}
	
	function update_user_mingxi($set_con_arr, $uid, $shijian, $source = '', $alert = 0, $freeze = 0,$date='',$relate_id=0) { //在update会员数据中，如果金额和积分发生了变化，自动插入一条明细，带有时间编号和数据来源，$freeze表示此金额是否为冻结返利
		$money=0;
		$jifen=0;
		if ($freeze == 1) { //冻结返利
		    $date=date('Ym',strtotime($date));  //下单的月份
		    $set = array ();
			if (!array_key_exists(0, $set_con_arr)) {
				$set_arr[0] = $set_con_arr;
			} else {
				$set_arr = $set_con_arr;
			}

			if (!array_key_exists('f', $set_arr[0])) {
				foreach ($set_arr[0] as $k => $v) {
					$arr['f'] = $k;
					$arr['e'] = '+';
					$arr['v'] = $v;
					$set[] = $arr;
				}
			} else {
				foreach ($set_arr as $k => $v) {
					if ($v['e'] == '' || $v['e'] == '=') {
						$arr['e'] = '=';
					} else {
						$arr['e'] = $v['e'];
					}
					$arr['f'] = $v['f'];
					$arr['e'] = '+';
					$arr['v'] = $v['v'];
					$set[] = $arr;
				}
			}
			
			foreach($set as $k=>$v){
			    if($v['f']=='money' && $v['v']>0){
				    $money=$v['v'];
					unset($set[$k]);
				}
				if($v['f']=='jifen' && $v['v']>0){
				    $jifen=$v['v'];
					unset($set[$k]);
				}
			}

			$income_id=$this->select('income','id','uid="'.$uid.'" and date="'.$date.'"');
			if(!$income_id){
				$data=array('money'=>$money,'jifen'=>$jifen,'uid'=>$uid,'date'=>$date);
			    $this->insert('income',$data);
			}
			else{
			    $data=array(array('f'=>'money','e'=>'+','v'=>$money),array('f'=>'jifen','e'=>'+','v'=>$jifen));
				$this->update('income',$data,'id="'.$income_id.'"');
			}

			if(!empty($set)){
				foreach($set as $k=>$v){ //重置数组，使数组第一个元素的键名为0
			        $set1[]=$v;
			    }
			   $this->update('user', $set1, 'id="' . $uid . '"',1, $alert);
			}
		}
		else{
		    $set_arr = $this->update('user', $set_con_arr, 'id="' . $uid . '"',1, $alert);
		    foreach ($set_arr as $row) {
			    if (($row['f'] == 'money' && abs($row['v']) > 0)) {
				    $money = $row['v'];
			    }
			    if (($row['f'] == 'jifen' && abs($row['v']) > 0)) {
				    $jifen = $row['v'];
			    }
		    }
		}

		$data = array (
			'money' => $money,
			'jifen' => $jifen,
			'uid' => $uid,
			'shijian' => $shijian,
			'source' => $source,
			'relate_id' => $relate_id
		);
		$this->mingxi_insert($data, $alert);
	}
	
	function check_user($username){
		if($this->webset['ucenter']['open']==1){
			include DDROOT.'/comm/uc_define.php';
            include_once DDROOT.'/uc_client/client.php';
			$uc_name=iconv("utf-8","utf-8",$username);
			$ucresult = uc_user_checkname($uc_name);
			if($ucresult!=1){
			    return 'false';
			}
			else{
			    return 'true';
			}
		}
		else{
		    $id=$this->select('user','id',"ddusername='$username'");
		    if($id>0) return 'false';
		    else return 'true';
		}
	}
	
	function check_oldpass($oldpass,$uid){
		if($this->webset['ucenter']['open']==1){
			include DDROOT.'/comm/uc_define.php';
            include_once DDROOT.'/uc_client/client.php';
			$username=$this->select('user','ddusername','id="'.$uid.'"');
			$uc_name=iconv("utf-8","utf-8",$username);
			list ($ucid, $uc_name, $pwd, $email) = uc_user_login($uc_name, $oldpass); 
			if($ucid<=0){
			    return 'false';
			}
			else{
			    return 'true';
			}
		}
		else{
			$id=$this->select('user','id',"id='$uid' and ddpassword='".md5($oldpass)."'");
			if($id>0) return 'true';
			else return 'false';
		}
	}
	
	function check_email($email){
		if($this->webset['ucenter']['open']==1){
			include DDROOT.'/comm/uc_define.php';
            include_once DDROOT.'/uc_client/client.php';
			$ucresult = uc_user_checkemail($email);
			if($ucresult!=1){
			    return 'false';
			}
			else{
			    return 'true';
			}
		}
		else{
		    $id=$this->select('user','id',"email='$email'");
		    if($id>0) return 'false';
		    else return 'true';
		}
	}
	
	function check_alipay($alipay){
	    $id=$this->select('user','id',"alipay='$alipay'");
		if($id>0) return 'false';
		else return 'true';
	}
	
	function check_my_email($email,$dduserid){
	    $id=$this->select('user','id',"id<>'$dduserid' and email='".$email."'");
		if($id>0){
		    return $id;
		}
		else{
		    return 0;
		}
	}
	function check_my_alipay($alipay,$dduserid){
	    $id=$this->select('user','id',"id<>'$dduserid' and alipay='".$alipay."'");
		if($id>0){
		    return $id;
		}
		else{
		    return 0;
		}
	}
	
	function webset($l=0) {
		$arr = $this->select_all('webset', '*', 'type=1 or type=0');
		if(empty($arr)){
			return false;
		}
		$webset = array ();
		foreach ($arr as $row) {
			if ($row['type'] == 1) {
				$row['val'] = unserialize($row['val']);
			} else {
				$row['val'] = $row['val'];
			}
			$webset[$row['var']] = $row['val'];
		}

		$arr = $this->select_all('webset', '*', 'type=2');
		if(empty($arr)){
			return false;
		}
		foreach ($arr as $row) {
			$name = str_replace('_', '', strtoupper($row['var']));
			$constant[$name]=$row['val'];
			if($l==101){
				define($name,$row['val']);
			}
		}

		dd_float($constant);
		dd_set_cache('constant',$constant);

		$appkey = $this->select_all('appkey', '`key`,`secret`,`sort` as num', 'sort>0');
		$webset['appkey'] = $appkey;
        
		dd_float($webset);
		$webset['duomai']['wzbh']=sprintf("%03s", $webset['duomai']['wzbh']);
		
		if($l==101){
			return $webset;
		}
		dd_set_cache('webset',$webset);
		
		$jssdk_set['fxbl']=$webset['fxbl'];
		$jssdk_set['cache_time']=$webset['taoapi']['cache_time'];
		$jssdk_set['errorlog']=$webset['taoapi']['errorlog'];
		$jssdk_set['key']=$webset['taoapi']['jssdk_key'];
		$jssdk_set['secret']=$webset['taoapi']['jssdk_secret'];
		$jssdk_set['shop_open']=$webset['shop']['open'];
		$jssdk_set['shop_slevel']=$webset['shop']['slevel'];
		$jssdk_set['shop_elevel']=$webset['shop']['elevel'];
		$jssdk_set['corrent_time']=$webset['corrent_time'];
		dd_set_cache('jssdk_set',$jssdk_set);

		if($l==1){return;} //只更新webset就结束
		
		if(file_exists(DDROOT.'/index.html')){
			unlink(DDROOT.'/index.html');
		}
		
		/*$sql="select id,title,tag from ".BIAOTOU."type order by sort desc";
	    $query=$this->query($sql);
	    while($row=$this->fetch_array($query)){
	        $type[$row['tag']][$row['id']]=$row['title'];
	    }
	    $this->free_result($query);
		make_arr_cache($type, 'data/type');
		
		$tuan_cat=$this->select_3_field('tuan_type','id,title,content','1=1');
		foreach($tuan_cat as $k=>$row){
		    $tuan_cat[$k]['content']=explode(',',$tuan_cat[$k]['content']);
		}
		make_arr_cache($tuan_cat, 'data/tuan_cat');
		
		$city_sort=$this->select_2_field('city','id,title','hide=0 order by sort desc');
		make_arr_cache($city_sort, 'data/city/city_sort');
		
		$city=$this->select_all('city','id,first_word','hide=0 order by first_word asc');
		$n=0;
		foreach($city as $row){
		    $n++;
			$first_word=$row['first_word'];
			$city_word[$first_word][$n] = $row['id'];
		}
		make_arr_cache($city_word, 'data/city/city_word');
		
		$a=$this->select_2_field('noword','`title`,`replace`','1=1');
        make_arr_cache($a, 'data/no_words');
		$js = "noWordArr=new Array();";
		$i=0;
		foreach($a as $k=>$v){
	   		$js.= "\r\n";
        	$js.= "noWordArr[".$i."]='".$k."';";
			$i++;
    	}
        create_file(DDROOT.'/data/noWordArr.js',$js);
		
		$a=$this->select_all('api','*','open="1" order by sort desc');
        make_arr_cache($a, 'data/apps');
		
		$a=$this->select_all('nav','*','hide="0" order by sort desc');
        make_arr_cache($a, 'data/nav');
		
		$a=$this->select_all('service','code,title,type','1=1 order by sort desc');
        make_arr_cache($a, 'data/kefu');*/
	}
	
	function phpwind($user,$forward){ //$user包含uid,username,password(原始密码),email,money,credit,time,cktime
	    if($this->webset['phpwind']['open']==0){
		    return $forward;
		}
		//$forward=htmlspecialchars($forward);
		$passport_key = $this->webset['phpwind']['key'];
        $userdb = array();
		$jumpurl = $this->webset['phpwind']['url'];
		
		$userdb['uid']		= $user['id'];
        $userdb['username']	= $user['name'];
        $userdb['password']	= $user['password'];
        $userdb['email']	= $user['email'];
        $userdb['money']	= 0;
        $userdb['credit']	= 0;
        $userdb['time']		= TIME;
        $userdb['cktime']	= $user['cookietime'] > 0 ? (TIME + $user['cookietime']) : 1200;
		
		$userdb_encode = '';
        foreach($userdb as $key=>$val){
	        $userdb_encode .= $userdb_encode ? "&$key=$val" : "$key=$val";
        }
		
        $userdb_encode = str_replace('=', '', StrCode($userdb_encode,$passport_key));

        if(substr($jumpurl, -1, 1) != '/') $jumpurl .= '/';
		
		if(MOD=='user' && (ACT=='login' || ACT=='register' || ACT=='info')){
			$action='login';
		}
		elseif(MOD=='user' && ACT=='exit'){
			$action='quit';
		}

		$verify = md5($action.$userdb_encode.$forward.$passport_key);
	    $url = $jumpurl."passport_client.php?action=".$action."&userdb=".rawurlencode($userdb_encode)."&forward=".rawurlencode($forward)."&verify=".rawurlencode($verify);
		return $url;
	}
	
	function duihuan($row,$admin=1){
		$goods_id=$row['goods_id'];
		$uid=$row['uid'];
		$email=$row['email'];
		$mobile=$row['mobile'];
		$user_mobile=$row['user_mobile'];
		$mobile_test=$row['mobile_test'];
		$money=$row['money'];
		$jifen=$row['jifen'];
		$title=$row['title'];
		$array=$row['array'];
		$auto=$row['auto'];
		$re=1;
		if($admin==0){ //前台申请兑换，数量就减一
			$huan_goods_arr[]=array('f'=>'num','e'=>'-','v'=>1);
		}
	    if($array!='' && $auto+$admin>=1){
			$code_arr=unserialize($array);	
			if(!empty($code_arr)){
				foreach($code_arr as $k=>$v){
			    	$code=$v;
					unset($code_arr[$k]);
					$array=serialize($code_arr);
					break;
				}
				$code='认领代码'.$code;
				$huan_goods_arr[]=array('f'=>'array','e'=>'=','v'=>$array);
			}
			else{
			    $code='认领代码已售空，请与管理员联系！';
			}
			$re=2;
		}
		else{
		    $code='';
			$array='';
		}
		
		if($auto+$admin>=1){ //如果是自动兑换或者后台审核
			$data=array('uid'=>$uid,'money'=>-$money,'jifen'=>-$jifen,'shijian'=>10,'source'=>$title);
		    $this->mingxi_insert($data);
			$msg_data=array('uid'=>$uid,'goods_title'=>$title,'code'=>$code);
			
			if($row['mobile']!=$row['user_mobile']){
				$msg_data['mobile']=$row['mobile'];
			}
			elseif($row['mobile_test']==1){
				$msg_data['mobile']=$row['user_mobile'];
			}
			else{
				$msg_data['mobile']='';
			}
			
		    $this->msg_insert($msg_data,4); //兑换成功4号站内信
			if(!empty($huan_goods_arr)){
				$this->update('huan_goods',$huan_goods_arr,'id="'.$goods_id.'"');
			}
		}
		if($admin==0 && $auto==0){ //前台兑换，不是自动发货，商品数量减1
			$this->update('huan_goods',$huan_goods_arr,'id="'.$goods_id.'"');
		}
		
		return $re;
	}
	
	function no_pay_trade($pay_time,$fxje){
		$pay_time=strtotime($pay_time);
		$freeze=$this->webset['taoapi']['freeze'];
		$freeze_limit=$this->webset['taoapi']['freeze_limit'];
		$auto_jiesuan=$this->webset['taoapi']['auto_jiesuan'];
		if($freeze==2 && TIME-$pay_time<3600*24*16 && $fxje>=$freeze_limit){
			return 1;
		}
		if($freeze==1 && $fxje>=$freeze_limit){
			if(date("d")>=$auto_jiesuan){
				if(date('m',$pay_time)==date("m")){
					return 1;
				}
			}
			else{
				if(date('m',$pay_time)==date("m") || date('m',$pay_time)==date("m",strtotime("-1 month"))){
					return 1;
				}
			}
		}
		return 0;
	}
	
	function user_money_from_buy($uid){
		$num=(float)$this->sum('mingxi','money','uid="'.$uid.'" and shijian in (2,3,8,12,17,18)');
		return round($num,2);
	}
	
	function tixian($id,$do='yes'){
		
		$row=$this->select('tixian as a,user as b','a.*,b.txstatus as user_status,b.ddusername,b.email,b.mobile as user_mobile,b.mobile_test','a.id="'.$id.'" and a.uid=b.id');
	
		if($row['status']!=0 || $row['user_status']!=1){
	    	return 0; //数据错误
		}
	
		$user_data=array(array('f'=>'txstatus','e'=>'=','v'=>0));
	
		$msg_data=array('uid'=>$row['uid'],'money'=>$row['money'],'alipay'=>$row['alipay'],'email'=>$row['email']);
		if($row['mobile']!=$row['user_mobile']){
			$msg_data['mobile']=$row['mobile'];
		}
		elseif($row['mobile_test']==1){
			$msg_data['mobile']=$row['user_mobile'];
		}
		else{
			$msg_data['mobile']='';
		}
	
		if($do=='yes'){
			$data=array('uid'=>$row['uid'],'money'=>-$row['money'],'shijian'=>9,'source'=>$row['alipay']);
			$this->mingxi_insert($data);
			$txstatus=0;
			$msg=$this->msg_insert($msg_data,2); //提现成功2号站内信
			$data=array('f'=>'status','e'=>'=','v'=>'1');
			$user_data[]=array('f'=>'yitixian','e'=>'+','v'=>$row['money']);
			$user_data[]=array('f'=>'lasttixian','e'=>'=','v'=>TIME);
		
			if($this->webset['hytxjl']>0){
		    	$user=$this->select('user','ddusername,tjr,hytx','id="'.$row['uid'].'"');
		    	if($user['tjr']>0 && $user['hytx']==0){
		        	$tjr_data=array('f'=>'money','e'=>'+','v'=>$this->webset['hytxjl']);
					$this->update_user_mingxi($tjr_data, (int)$user['tjr'],11,$user['ddusername']); //好友提现奖励，11号明细
					$duoduo->update('user',array('hytx'=>1),'id="'.$row['uid'].'"');
		    	}
			}
		}
		elseif($do=='no'){
			$user_data[]=array('f'=>'money','e'=>'+','v'=>$row['money']);
			$msg_data['why']=$_POST['why'];
			$msg=$this->msg_insert($msg_data,3); //提现失败3号站内信
			$data=array('f'=>'status','e'=>'=','v'=>'2');
		}
		$this->update('tixian',$data,'id="'.$id.'"');
		$this->update('user',$user_data,'id="'.$row['uid'].'"');
		return 1;
	}
	
	function set_webset($var,$val){
		$id=$this->select('webset','id','var="'.$var.'"');
		if($id>0){
			$data=array('val'=>$val);
			$this->update('webset',$data,'var="'.$var.'"');
		}
		else{
			$data=array('val'=>$val,'var'=>$var);
			$this->insert('webset',$data);
		}
	}
}
?>