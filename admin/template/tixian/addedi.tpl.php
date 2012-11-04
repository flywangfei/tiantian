<?php include(ADMINTPL.'/header.tpl.php');?>

<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115px" align="right">会员：</td>
    <td>&nbsp;<?=$duoduo->select('user','ddusername','id="'.$row['uid'].'"')?></td>
  </tr>
  <tr>
    <td align="right">提现金额：</td>
    <td>&nbsp;<?=$row['money']?></td>
  </tr>
  <tr>
    <td align="right">支付宝：</td>
    <td>&nbsp;<?=$row['alipay']?></td>
  </tr>
  <tr>
    <td align="right">真实姓名：</td>
    <td>&nbsp;<?=$row['realname']?></td>
  </tr>
  <tr>
    <td align="right">提现时间：</td>
    <td>&nbsp;<?=date('Y-m-d H:i:s',$row['addtime'])?></td>
  </tr>
  <tr>
    <td align="right">提现IP：</td>
    <td>&nbsp;<?=$row['ip']?></td>
  </tr>
  <tr>
    <td align="right">手机：</td>
    <td>&nbsp;<?=$row['mobile']?></td>
  </tr>
  <tr>
    <td align="right">备注：</td>
    <td>&nbsp;<?=$row['remark']?></td>
  </tr>
  <?php if($do=='no'){?>
  <tr>
    <td align="right">退回原因：</td>
    <td>&nbsp;<input type="text" name="why" style="width:400px" value="<?=$row['why']?>" /></td>
  </tr>
  <?php }?>
  <tr>
    <td align="right">状态：</td>
    <td>&nbsp;<?=$status_arr[$row['status']]?></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="id" value="<?=$row['id']?>" /><input type="submit" id="sub" class="sub" name="sub" value=" <?php if($do=='yes'){?>确 认 提 现<?php }else{?>退 回 提 现<?php }?> " /></td>
  </tr>
</table>
<input type="hidden" name="do" value="<?=$do?>" />
</form>
<?php
if($row['status']!=0){echo script('$("#sub").attr("disabled","true");');}
?>
<?php include(ADMINTPL.'/footer.tpl.php');?>