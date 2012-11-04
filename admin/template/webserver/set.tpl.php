<?php include(ADMINTPL.'/header.tpl.php');
$collect_sort_arr=array(1=>1,2,3);

$num_iid=16021599283;
$json_obj='{"num_iid":'.$num_iid.'}';
$json_arr=json_decode($json_obj,1);

if(DDJSON==0){
	if($json_arr['num_iid']!=$num_iid){
		$json_error_word='<b style="color:red">json解析异常，建议使用多多内部json函数</b><input onclick="location.href=\'index.php?mod='.MOD.'&act='.ACT.'&ddjson=1\'" type="button" value="确定" />';
	}
	else{
		$json_error_word='解析正常';
	}
}

if(DDJSON==1){
	if($json_arr['num_iid']==$num_iid){
		$json_error_word='<b style="color:red">json解析正常，建议使用php内部json函数</b><input onclick="location.href=\'index.php?mod='.MOD.'&act='.ACT.'&ddjson=0\'" type="button" value="确定" />';
	}
	else{
		$json_arr=dd_json_decode($json_obj,1);
		if($json_arr['num_iid']!=$num_iid){
			$json_error_word='解析异常，联系多多官方';
		}
		else{
			$json_error_word='解析正常';
		}
	}
}

?>
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
  <tr>
    <td width="115px" align="right">curl：</td>
    <td>&nbsp;<?=$curl_status?>，<?php if($curl_status=='存在'){?><a style="text-decoration:underline" href="<?=u('webserver','set',array('fun'=>'test_curl'))?>">测试是否可用</a><?php }?> 优先级：<?=select($collect_sort_arr,$webset['collect']['curl'],'collect[curl]')?> <?php if(isset($_GET['fun']) && $_GET['fun']=='test_curl'){echo '<b style="color:red">'.test_curl($url).'</b>';}?> 如果curl方式可用，优先使用此方法</td>
  </tr>
  <tr>
    <td width="115px" align="right">file_get_contents：</td>
    <td>&nbsp;<?=$file_get_contents_status?>，<?php if($curl_status=='存在'){?><a style="text-decoration:underline" href="<?=u('webserver','set',array('fun'=>'test_file_get_contents'))?>">测试是否可用</a><?php }?> 优先级：<?=select($collect_sort_arr,$webset['collect']['file_get_contents'],'collect[file_get_contents]')?> <?php if(isset($_GET['fun']) && $_GET['fun']=='test_file_get_contents'){echo '<b style="color:red">'.test_file_get_contents($url).'</b>';}?></td>
  </tr>
  <tr>
    <td width="115px" align="right">(p)fsockopen：</td>
    <td>&nbsp;<?=$fsockopen_status?>，<?php if($curl_status=='存在'){?><a style="text-decoration:underline" href="<?=u('webserver','set',array('fun'=>'test_fsockopen'))?>">测试是否可用</a><?php }?> 优先级：<?=select($collect_sort_arr,$webset['collect']['fsockopen'],'collect[fsockopen]')?> <?php if(isset($_GET['fun']) && $_GET['fun']=='test_fsockopen'){echo '<b style="color:red">'.test_fsockopen($url).'</b>';}?></td>
  </tr>
  <tr>
    <td align="right"></td>
    <td>&nbsp;<input type="submit" name="sub" class="sub" value="保存" /> 数字越大使用优先级越高</td>
  </tr>
  </form>
  <tr>
    <td align="right">json：</td>
    <td>&nbsp;<?=$json_encode_status?> <?=$json_error_word?></td>
  </tr>
  <tr>
    <td align="right">openssl：</td>
    <td>&nbsp;<?=$ssl_status?> （应用于QQ登陆等需要https验证的行为。）</td>
  </tr>
  <tr>
    <td align="right">zlib：</td>
    <td>&nbsp;<?=extension_loaded("zlib")?'支持':'不支持'?> （应用于网页gzip输出。）</td>
  </tr>
  <tr>
    <td align="right">realpath：</td>
    <td>&nbsp;<?php echo realpath('../');?></td>
  </tr>
  <tr>
    <td align="right">目录权限：</td>
    <td style="padding:5px; line-height:20px">
    <table width="200" border="0">
  
  <?php foreach($file as $v){if(iswriteable(DDROOT.'/'.$v)==0){?>
  <tr>
	<td><?=$v?></td><td> <span style=" color:red">不可写！</span></div></td>
	<?php }else{?>
	<td><?=$v?></td><td><span style=" color:#090">可写！</span></div></td>
	<?php }?>
    </tr>
    <?php }?>
  
</table>

	
    </td>
  </tr>
</table>
<?php include(ADMINTPL.'/footer.tpl.php');?>