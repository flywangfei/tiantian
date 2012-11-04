<?php include(ADMINTPL.'/header.tpl.php');?>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115px" align="right">商城名：</td>
    <td>&nbsp;<?=select($malls,$row['mall_id'],'mall_id')?></td>
  </tr>
  <tr>
    <td width="115px" align="right">会员：</td>
    <td>&nbsp;<input name="uname" type="text" id="uname" value="<?=$duoduo->select('user','ddusername','id="'.$row['uid'].'"')?>"/></td>
  </tr>
  <tr>
    <td width="115px" align="right">评论：</td>
    <td>&nbsp;<textarea name="content" style="width:400px; height:200px"><?=$row['content']?></textarea></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="id" value="<?=$row['id']?>" /><input type="submit" class="sub" name="sub" value=" 保 存 " /></td>
  </tr>
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>