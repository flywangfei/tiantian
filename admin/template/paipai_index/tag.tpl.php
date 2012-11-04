<?php include(ADMINTPL.'/header.tpl.php');?>
<style type="text/css">
ul{ list-style:none; width:950px;margin:0px; padding:0px; margin-top:5px}
li{ list-style:none; margin:0px; padding:0px; margin-bottom:5px; height:20px; text-align:left}
li input.tag{font-family:宋体; width:250px}
</style>
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
  <tr>
    <td colspan="2" align="left" style="padding-left:10px; padding-top:5px">
	  <ul>
        <?php foreach($tag as $k=>$row){?>
        <li>标题：<input class="tag" type="text" name="<?=$k?>[title]" value="<?=$row['title']?>" /> 链接：<input class="tag" type="text" name="<?=$k?>[url]" value="<?=$row['url']?>" /></li>
        <?php }?>
      </ul>
      <div style="clear:both"></div>
    </td>  
  </tr>
  <tr>
     <td align="right" width="15px">&nbsp;</td>
     <td>&nbsp;<input type="submit" name="sub" value=" 保 存 设 置 " /></td>
  </tr>
  </form>
</table>

<?php include(ADMINTPL.'/footer.tpl.php');?>