<?php include(ADMINTPL.'/header.tpl.php');?>
<div class="explain-col">
提示：请选择获取交易的时间段。时间只能选择最近3个月内。已经获取过的交易不会覆盖原有的数据，获取过程将自动忽略。<br />
时间必须为8位，并且开始时间小于结束时间，否则将无法获取成功！<br />
</div>
<br />
<form method="get" action="../index.php">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115px" align="right">时间范围：</td>
    <td>&nbsp;<input name="sday" type="text" id="sday" size="10" maxlength="8" value="<?=date('Ymd')?>" /> 到 <input name="eday" type="text" id="eday" size="10" maxlength="8" value="<?=date('Ymd')?>" /></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="submit" class="sub" value="获取交易记录" /></td>
  </tr>
</table>
<input type="hidden" name="mod" value="paipai" />
<input type="hidden" name="act" value="<?=ACT?>" />
<input type="hidden" name="show" value="<?=authcode(1,'ENCODE')?>" />
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>