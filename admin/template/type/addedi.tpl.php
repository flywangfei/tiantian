<?php include(ADMINTPL.'/header.tpl.php');?>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115px" align="right">父栏目：</td>
    <td>&nbsp;<select name="pid" style="font-size:12px"><option value="0">--顶层栏目--</option><?php getCategorySelect($pid);?></select></td>
  </tr>
  <tr>
    <td align="right">栏目名称：</td>
    <td>&nbsp;<input name="title" type="text" id="title" value="<?=$row['title']?>"/></td>
  </tr>
  <tr>
    <td align="right">排序：</td>
    <td>&nbsp;<input name="sort" type="text" id="sort" value="<?=$row['sort']?>"/></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="id" value="<?=$row['id']?>" /><input type="hidden" name="tag" value="<?=$mod_tag?>" /><input type="submit" class="sub" name="sub" value=" 保 存 " /></td>
  </tr>
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>