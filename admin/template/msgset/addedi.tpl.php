<?php 
include(ADMINTPL.'/header.tpl.php');
$have_msg=array(0,1,2,3,4,5,6,7);
$have_email=array(0,1,2,3,4,5,6,7,8);
$have_sms=array(0,2,3,4,5,6,7);
?>
<div class="explain-col">说明：网站注册无短信，有效订单无站内信和邮件
  </div>
<br />
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115px" align="right">标题：</td>
    <td>&nbsp;<input name="title" type="text" id="title" value="<?=$row['title']?>" style="width:300px" /></td>
  </tr>
  <?php if(in_array($id,$have_msg) || $id>8){?>
  <tr>
    <td align="right">站内信：</td>
    <td>&nbsp;<textarea name="web" style="width:400px; height:100px"><?=$row['web']?></textarea></td>
  </tr>
  <?php }?>
  <?php if(in_array($id,$have_email) || $id>8){?>
  <tr>
    <td align="right">邮件：</td>
    <td>&nbsp;<textarea name="email" style="width:400px; height:100px"><?=$row['email']?></textarea></td>
  </tr>
  <?php }?>
  <?php if((1==0 && in_array($id,$have_sms)) || $id>8){?>
  <tr>
    <td align="right">短信：</td>
    <td>&nbsp;<textarea name="sms" style="width:400px; height:100px"><?=$row['sms']?></textarea></td>
  </tr>
  <?php }?>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="id" value="<?=$row['id']?>" /><input type="submit" class="sub" name="sub" value=" 保 存 " /></td>
  </tr>
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>