<?php 
include(ADMINTPL.'/header.tpl.php');
?>
<div class="explain-col"> 温馨提示：返现宝（右键浏览器插件版）已被淘宝认定是非法插件，一经发现，封冻阿里妈妈账号，请慎重使用！
  </div>
<br />
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115px" align="right">状态：</td>
    <td>&nbsp;<?=html_radio($open_arr,$webset['fxb']['open'],'fxb[open]')?> （右键浏览器插件版是否开启）</td>
  </tr>
  <tr>
    <td align="right">返现宝名称：</td>
    <td>&nbsp;<input type="text" name="fxb[name]" value="<?=$webset['fxb']['name']?>" /></td>
  </tr>
  <tr>
    <td align="right"></td>
    <td>&nbsp;<input type="submit" name="sub" class="sub" value=" 提 交 " /></td>
  </tr>
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>