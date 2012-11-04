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

$data = dd_get_cache('basedata');
$repaire=$_GET['repaire']?1:0;
$miss_table_msg=array();
$creat_table_msg=array();
$miss_field_msg=array();
$creat_field_msg=array();

$sql = "Show Tables";
$pre=BIAOTOU;
$query = $duoduo->query($sql);
while ($row = $duoduo->fetch_array($query,MYSQL_NUM)) {
	if (preg_match('/^'.$pre.'/', $row[0])) {
		$duoduoSysTables[] = str_replace($pre,'',$row[0]);
	}
}

foreach($data as $table=>$field){
	
	if(!in_array($table,$duoduoSysTables)){ //没有表
		if($repaire==0){
		    $miss_table_msg[]=BIAOTOU.$table;
		}
	    else{
			$duoduo->creat_table($table,$field);
		    $creat_table_msg[]=BIAOTOU.$table;
		}
	}
	else{ //检测字段
		$field_arr=$duoduo->show_fields($table);
		foreach($field as $k=>$v){
			if($k!='duoduo_table_index'){
			    if(!in_array($k,$field_arr)){
			        if($repaire==0){
				        $miss_field_msg[]=BIAOTOU.$table.'：'.$k;
				    }
				    else{
				        $duoduo->reapaire_field($table,$k,$v);
					    $creat_field_msg[]=BIAOTOU.$table.' '.$k;
				    }
			    }
			}
		}
	}
}

//数据结构
/*foreach ($duoduoSysTables as $tablename) {
	$query = $duoduo->query('show fields from `' . BIAOTOU . $tablename.'`;');
	while ($arr = $duoduo->fetch_array($query)) {
		$info = $arr['Type'];
		if ($arr['Null'] == 'NO') {
			$info .= ' NOT NULL';
		}
		$type = strtolower(preg_replace('/\((.*)\)/', '', $arr['Type']));
		if ($type == 'int' or $type == 'tinyint' or $type == 'bigint' or $type == 'double') { //数字类型<br>
			if ($arr['Default'] != '') {
				$info .= ' default "' . $arr['Default'] . '"';
			}
		} else {
			if ($arr['Null'] == 'YES') {
				if ($arr['Default'] != '') {
					$info .= ' default "' . $arr['Default'] . '"';
				} else {
					$info .= ' default NULL';
				}
			}
		}

		if ($arr['Extra'] != '') {
			$info .= ' ' . $arr['Extra'];
		}

		$table_data[$tablename][$arr['Field']] = $info;

		if ($arr['Key'] != '') {
			if ($arr['Key'] == 'PRI') {
				$duoduo_table_index = 'PRIMARY KEY  (`' . $arr['Field'] . '`)';
			}
			elseif ($arr['Key'] == 'UNI') {
				$duoduo_table_index .= ',UNIQUE KEY `' . $arr['Field'] . '` (`' . $arr['Field'] . '`)';
			}
			elseif($arr['Key'] == 'MUL'){
				$duoduo_table_index .= ',KEY `' . $arr['Field'] . '` (`' . $arr['Field'] . '`)';
			}
		}
	}
	$table_data[$tablename]['duoduo_table_index'] = $duoduo_table_index;
}
dd_set_cache('basedata',$table_data);*/