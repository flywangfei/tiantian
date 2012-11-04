<?php include(ADMINTPL.'/header.tpl.php');?>
<div class="explain-col">
提示：导入的淘宝订单没有购买会员的信息，站长谨慎使用！
</div>
<br />
<form method="post" action="" enctype="multipart/form-data">
<input type="hidden" name="mod" value="<?=MOD?>" />
      <input type="hidden" name="act" value="<?=ACT?>" />
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115px" align="right">导入文件：</td>
    <td>&nbsp; <input name="upfile" type="file" size="17" /></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="submit" class="sub" name="sub" value="导入" /></td>
  </tr>
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>