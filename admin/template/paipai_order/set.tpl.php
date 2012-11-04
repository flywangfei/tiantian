<?php include(ADMINTPL.'/header.tpl.php');$sort_arr=include(DDROOT.'/data/paipai_sort.php');?>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115" align="right">状态：</td>
    <td>&nbsp;<?=html_radio(array(0=>'关闭',1=>'开启'),$webset['paipai']['open'],'paipai[open]')?>&nbsp; <a href="http://pop.paipai.com" style="text-decoration:underline" target="_blank">注册拍拍开放平台</a> <a href="http://faq.duoduo123.com/v8/scr/16-1.html" target="_blank">在线教程</a></td>
  </tr>
  <tr>
    <td align="right">userId：</td>
    <td>&nbsp;<input name="paipai[userId]" value="<?=$webset['paipai']['userId']?>" />&nbsp;拍拍联盟用户id</td>
  </tr>
  <tr>
    <td align="right">qq：</td>
    <td>&nbsp;<input name="paipai[qq]" value="<?=$webset['paipai']['qq']?>" />&nbsp;注册qq</td>
  </tr>
  <tr>
    <td align="right">appOAuthID：</td>
    <td>&nbsp;<input name="paipai[appOAuthID]" value="<?=$webset['paipai']['appOAuthID']?>" />&nbsp;拍拍开放平台appOAuthID</td>
  </tr>
  <tr>
    <td align="right">secretOAuthKey：</td>
    <td>&nbsp;<input name="paipai[secretOAuthKey]" value="<?=$webset['paipai']['secretOAuthKey']?>" />&nbsp;拍拍开放平台secretOAuthKey</td>
  </tr>
  <tr>
    <td align="right">accessToken：</td>
    <td>&nbsp;<input name="paipai[accessToken]" value="<?=$webset['paipai']['accessToken']?>" />&nbsp;拍拍开放平台accessToken</td>
  </tr>
  <tr>
    <td align="right">默认关键词：</td>
    <td>&nbsp;<input name="paipai[keyWord]" value="<?=$webset['paipai']['keyWord']?>" />&nbsp;必须填写，否则没有默认数据</td>
  </tr>
  <tr>
    <td align="right">显示商品数量：</td>
    <td>&nbsp;<input name="paipai[pageSize]" value="<?=$webset['paipai']['pageSize']?>" />&nbsp;最多40个</td>
  </tr>
  <tr>
    <td align="right">排序：</td>
    <td>&nbsp;<?=select($sort_arr,$webset['paipai']['sort'],'paipai[sort]')?>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">缓存时间：</td>
    <td>&nbsp;<input style="width:30px" name="paipai[cache_time]" value="<?=$webset['paipai']['cache_time']?>" />&nbsp;单位(小时)，设为为0即为不缓存，目录为data/temp/paipai。 <input type="button" value="删除缓存" onclick="javascript:openpic('../<?=u('cache','del',array('admin'=>'1','do'=>'paipai'))?>','upload','450','350')" /></td>
  </tr>
  <tr>
    <td align="right">错误日志：</td>
    <td>&nbsp;<?=html_radio(array(0=>'关闭',1=>'开启'),$webset['paipai']['errorlog'],'paipai[errorlog]')?>&nbsp;存储路径data/temp/paipai_error_log</td>
  </tr>
  <tr>
     <td align="right">&nbsp;</td>
     <td>&nbsp;<input type="submit" name="sub" value=" 保 存 设 置 " /></td>
  </tr>
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>