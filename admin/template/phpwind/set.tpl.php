<?php include(ADMINTPL.'/header.tpl.php');$status=array(0=>'关闭',1=>'开启');?>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
<div class="explain-col">提醒：如果多多是全新而phpwind有会员，需要将phpwind会员导入到duoduo中。导入先请先将多多提供的phpwind整合文件上传到phpwind根目录下 <a style="color:#F00" href="<?=u(MOD,'import')?>">马上导入</a>
  </div>
<br />
  <tr>
    <td width="115px" align="right">状态：</td>
    <td>&nbsp;<?=html_radio($status,$webset['phpwind']['open'],'phpwind[open]')?></td>
  </tr>
  <tr>
    <td align="right">phpwind 通信密钥：</td>
    <td>&nbsp;<input name="phpwind[key]" type="text" value="<?=$webset['phpwind']['key']?>" style="width:200px" /> 注意：要与phpwind内的设置一致</td>
  </tr>
  <tr>
    <td align="right">phpwind 访问地址：</td>
    <td>&nbsp;<input name="phpwind[url]" type="text" value="<?=$webset['phpwind']['url']?>"  style="width:200px"/> </td>
  </tr>
  <tr>
    <td align="right">数据库字符集：</td>
    <td>&nbsp;<input name="phpwind[charset]" type="text" value="<?=$webset['phpwind']['charset']?>" /> 默认：utf-8</td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="submit" class="sub" name="sub" value=" 保 存 " /> <?php if($webset['phpwind']['url']!=''){?><a href="<?=$webset['phpwind']['url']?>/admin.php" target="_blank">phpwind后台</a><?php }?></td>
  </tr>
  <tr>
    <td align="right">&nbsp;整合说明：</td>
    <td><ul>
    <li>1、下载整合程序上传。<a href="http://bbs.duoduo123.com/read-htm-tid-109559-ds-1.html" target="_blank">立刻下载</a></li>
    <li>2、进入phpwind后台，“应用”->“插件中心”->“通行证”->“设置”，显示界面如下：<br/>
        <img src="images/phpwindport.jpg" /></li>
    <li>3、信息填写如下表：<br/><table border="1" cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <th scope="col">&nbsp;通行证</th>
    <th scope="col">&nbsp;密钥</th>
    <th scope="col">&nbsp;系统作为</th>
    <th scope="col">&nbsp;服务器地址</th>
    <th scope="col">&nbsp;登录地址</th>
    <th scope="col">&nbsp;退出地址</th>
    <th scope="col">&nbsp;注册地址</th>
  </tr>
  <tr>
    <td>&nbsp;开启</td>
    <td>&nbsp;与phpwin相同</td>
    <td>&nbsp;客户端</td>
    <td>&nbsp;<?=SITEURL?></td>
    <td>&nbsp;index.php?mod=user&act=login</td>
    <td>&nbsp;index.php?mod=user&act=exit</td>
    <td>&nbsp;index.php?mod=user&act=register</td>
  </tr>
</table>
</li>
    </ul></td>
  </tr>
</table>
</form>
<script>
ucOpen=<?=$webset['ucenter']['open']?>;
$(function(){
    $('input[name=phpwind[open]]').click(function(){
	    if($(this).val()==1 && ucOpen==1){
			$('input[name=phpwind[open]]').eq(0).attr("checked", "checked");
		    alert('您已经开启了UC整合，请关闭UC整合后再开启phpwind整合');
			return false;
		}
	});		  
})
</script>
<?php include(ADMINTPL.'/footer.tpl.php');?>