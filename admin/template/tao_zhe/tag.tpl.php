<?php include(ADMINTPL.'/header.tpl.php');?>
<style type="text/css">
ul{ list-style:none; width:950px;margin:0px; padding:0px; height:60px; margin-top:5px}
li{ list-style:none; float:left; margin:0px; padding:0px; margin-bottom:5px; height:20px; width:100px; text-align:left}
li input.tag{ width:60px; font-family:宋体;}
</style>
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
  <tr>
    <td colspan="2" align="left" style="padding-left:10px; padding-top:5px">
    <?php foreach($tag['info'] as $k=>$arr){?>
                        <div><input name="category[]" type="text" style="width:80px" value="<?=$tag['category'][$k]?>" /> 栏目名</div>
                        <ul>
                          <?php foreach($arr as $i=>$row){?>
                          <li><input class="tag" type="text" name="info[<?=$k?>][<?=$i?>][word]" value="<?=$row['word']?>" /><input title="加粗" <?php if($row['b']==1){?> checked="checked"<?php }?> value="1" name="info[<?=$k?>][<?=$i?>][b]" type="checkbox" /></li>
                          <?php }?>
                        </ul>
                        <div style="clear:both"></div>
                      <?php }?>
    </td>  
  </tr>
  <tr>
     <td width="15px">&nbsp;</td>
     <td align="left">&nbsp;<input type="submit" name="sub" value=" 保 存 设 置 " /></td>
  </tr>
  </form>
</table>

<?php include(ADMINTPL.'/footer.tpl.php');?>