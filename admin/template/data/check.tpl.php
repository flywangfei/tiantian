<?php include(ADMINTPL.'/header.tpl.php');?>
<div style="padding-left:10px; margin-top:10px">
<table width="700" border="0">
<tr>
<td style="padding-left:10px; font-size:20px; color:#990000; font-weight:bold">多多返利系统8.0专用数据库检测修复工具</td>
</tr>
<tr><td height="10"></td></tr>
<tr>
<td style="padding-left:20px; line-height:20px">
<?php
$need_repaire=0;
if ($repaire == 0) {
	echo '<span style="font-weight:bold; color:#ff6600; font-size:12px;">开始检测多多表结构</span><br/>';
	if (!empty ($miss_table_msg)) {
		foreach ($miss_table_msg as $v) {
			echo '缺少表：' . $v . '<br/>';
			$need_repaire = 1;
		}
	}
	if (!empty ($miss_field_msg)) {
		foreach ($miss_field_msg as $v) {
			echo '缺少字段：' . $v . '<br/>';
			$need_repaire = 1;
		}
	}
	if(empty ($miss_table_msg) && empty ($miss_field_msg)){
	    echo '数据检测无问题！';
	}
}
else{
    if (!empty ($creat_table_msg)) {
		foreach ($creat_table_msg as $v) {
			echo '修复表：' . $v . '<br/>';
		}
	}
	if (!empty ($creat_field_msg)) {
		foreach ($creat_field_msg as $v) {
			echo '修复字段：' . $v . '<br/>';
		}
	}
}
?>
</td>
</tr>
<tr><td style="padding-left:20px">
<?php if($need_repaire==1){?>
<form action="">
<input type="hidden" name="mod" value="data" />
<input type="hidden" name="act" value="check" />
<input type="hidden" name="repaire" value="1" />
<input type="submit" name="sub" value="一键修复" />
</form>
<?php }?>
</td></tr>
<tr>
<td style="padding-left:10px; color:#999999; line-height:25px;"><br><br>如果您的数据库缺少字段，可能是你的数据库被破坏或没有运行升级文件。<br>
1、如果你是升级后出现：说明你没有运行升级文件。<br>
2、如果是平时出现：可能数据库被破坏。<br>
3、如果是恢复数据后出现，可能你的数据库被还原到老版本了。<br>
4、如果无法确定提交论坛寻求帮助。
</td>
</tr>
</table>
</div>
<?php include(ADMINTPL.'/footer.tpl.php');?>