<?php include(ADMINTPL.'/header.tpl.php');?>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115px" align="right">key：</td>
    <td>&nbsp;<input name="key" type="text" id="key" value="<?=$row['key']?>" style="width:300px" /></td>
  </tr>
  <tr>
    <td align="right">secret ：</td>
    <td>&nbsp;<input name="secret" type="text" id="secret" value="<?=$row['secret']?>" style="width:300px" /></td>
  </tr>
  <tr>
    <td align="right">调用量：</td>
    <td>&nbsp;<input name="sort" type="text" id="sort" value="<?=$row['sort']?>" style="width:300px" /> (多少)次/每分钟</td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="id" value="<?=$row['id']?>" /><input type="submit" class="sub" name="sub" value=" 保 存 " /></td>
  </tr>
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>