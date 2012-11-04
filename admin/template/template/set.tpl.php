<?php include(ADMINTPL.'/header.tpl.php');$yeworno=array(0=>'否',1=>'是');?>
<div class="explain-col">生成静态页面后，需要调整服务器，把index.html优先级设为最高。更新缓存后，打开<a href="<?=SITEURL?>/index.php" target="_blank"><?=SITEURL?>/index.php</a>便可更新首页。
  </div>
<br />
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
  <tr>
    <td width="150px" align="right">生成静态页：</td>
    <td>&nbsp;<label><input <?php if($webset['static']['index']['index']==1){?> checked="checked"<?php }?> name="static[index][index]" type="checkbox" value="1"/> 首页</label>&nbsp;（暂时只支持首页）</td>
  </tr>
  <tr>
    <td width="150px" align="right">首页数据随机：</td>
    <td>&nbsp;<?=html_radio($yeworno,$webset['static']['index']['random'],'static[index][random]')?>（首页淘宝热卖，团购，淘宝打折的商品随机显示，注意：静态页无此功能）</td>
  </tr>
  <tr>
     <td align="right">&nbsp;</td>
     <td>&nbsp;<input type="submit" name="sub" value=" 保 存 设 置 " /></td>
  </tr>
  </form>
</table>
<?php include(ADMINTPL.'/footer.tpl.php');?>