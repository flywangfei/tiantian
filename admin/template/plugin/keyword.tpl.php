<?php 
include(ADMINTPL.'/header.tpl.php');
?>
<div class="explain-col"> 温馨提示：如果您开启了伪静态，会输出静态地址，如果没有，会输出动态地址！
  </div>
<br />
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115px" align="right">关键词：</td>
    <td>&nbsp;<input type="text" name="keyword" value="<?=$keyword?>" /></td>
  </tr>
  <tr>
    <td align="right"></td>
    <td>&nbsp;<input type="submit" name="sub" class="sub" value=" 提 交 " /></td>
  </tr>
  <?php foreach($page_url_arr as $row){?>
  <tr>
    <td align="right"><?=$row['name']?>：</td>
    <td>&nbsp;<input type="text" style="width:500px" value="<?=$keyword?$row['url']:''?>" /> <button onClick="copy($(this).prev('input').val())">复制</button></td>
  </tr>
  <?php }?>
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>