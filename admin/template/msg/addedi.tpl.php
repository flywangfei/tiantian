<?php include(ADMINTPL.'/header.tpl.php');?>
<?php 
if($id>0){
	if($row['senduser']>0){
	    $senduser=$duoduo->select('user','ddusername','id="'.$row['senduser'].'"');
	}
    else{
	    $senduser='网站客服';
	}
	if($row['uid']>0){
	    $receiveuser=$duoduo->select('user','ddusername','id="'.$row['uid'].'"');
	}
    else{
	    $receiveuser='网站客服';
	}
?>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="get" name="form2">
<input type="hidden" name="mod" value="<?=MOD?>" />
<input type="hidden" name="act" value="<?=ACT?>" />
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115px" align="right">收件人：</td>
    <td>&nbsp;<?=$receiveuser?> </td>
  </tr>
  <tr>
    <td align="right">发件人：</td>
    <td>&nbsp;<?=$senduser?> </td>
  </tr>
  <tr>
    <td align="right">发送时间：</td>
    <td>&nbsp;<?=$row['addtime']?> </td>
  </tr>
  <tr>
    <td align="right">内容：</td>
    <td>&nbsp;<?=$row['content']?></td>
  </tr>
  <?php if($row['uid']==0){?>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="name" value="<?=$senduser?>" /><input type="hidden" name="sid" value="<?=$id?>" /><input type="submit" class="sub"  value=" 回 复 " /></td>
  </tr>
  <?php }?>
  <?php if(!empty($msg_re)){?>
  <?php foreach($msg_re as $arr){?>
  <tr>
    <td align="right">网站回复：</td>
    <td>&nbsp;<?=$arr['content']?></td>
  </tr>
  <tr>
    <td align="right">回复时间：</td>
    <td>&nbsp;<?=$arr['addtime']?></td>
  </tr>
  <?php }?>
  <?php }?>
</table>
</form>
<?php }else{?>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115px" align="right">会员：</td>
    <td>&nbsp;<input name="username" type="text" style="width:400px" value="<?=$name?>" /> 用“|”隔开会员名可群发。不填写将发送全站会员</td>
  </tr>
  <tr>
    <td align="right">内容：</td>
    <td>&nbsp;<textarea style="width:400px; height:200px" name="content"></textarea></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="id" value="" /><input type="hidden" name="sid" value="<?=$sid?>" /><input type="submit" class="sub" name="sub" value=" 发 送 " /></td>
  </tr>
</table>
</form>
<?php }?>
<?php include(ADMINTPL.'/footer.tpl.php');?>