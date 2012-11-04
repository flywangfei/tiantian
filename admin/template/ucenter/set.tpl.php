<?php include(ADMINTPL.'/header.tpl.php');$status=array(0=>'关闭',1=>'开启');if($_GET['ucmyset']==1){$webset['ucenter']['open']==1;}?>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
<?php if(isset($_GET['ucapiset']) || ((!isset($_GET['ucapiset']) && !isset($_GET['ucmyset'])) && $webset['ucenter']['open']==0)){?>
<div class="explain-col">不需要在UC内设置，只要在多多后台填写相关信息，UC会同步添加整合应用。设置完成后，登陆UC查看是否整合成功。
  </div>
<br />
  <tr>
    <td width="115px" align="right">UCenter地址：</td>
    <td>&nbsp;<input name="url" type="text" id="url" value="" style="width:300px" /> 举例：http://bbs.duoduo123.com/uc_server</td>
  </tr>
  <tr>
    <td align="right">初始管理员密码：</td>
    <td>&nbsp;<input name="pwd" type="text" id="pwd" value="" /></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="step" value="1" /><input type="submit" class="sub" name="sub" value=" 设 置 " /> <a href="<?=u(MOD,ACT,array('ucmyset'=>1))?>">人工设置</a></td>
  </tr>
<?php }elseif(isset($_GET['ucmyset']) || $webset['ucenter']['open']==1){?>
<div class="explain-col">提醒：如果UCenter是全新而多多有会员，需要将多多会员导入到UCenter中。<a style="color:#F00" href="<?=u(MOD,'import')?>">马上导入</a>
  </div>
<br />
  <tr>
    <td width="150px" align="right">状态：</td>
    <td>&nbsp;<?=html_radio($status,$webset['ucenter']['open'],'ucenter[open]')?> <a href="<?=u(MOD,ACT,array('ucapiset'=>1))?>">自动设置</a></td>
  </tr>
  <tr>
    <td align="right">UCenter 应用 ID：</td>
    <td>&nbsp;<input name="ucenter[UC_APPID]" type="text" value="<?=$webset['ucenter']['UC_APPID']?>" /> </td>
  </tr>
  <tr>
    <td align="right">UCenter 通信密钥：</td>
    <td>&nbsp;<input name="ucenter[UC_KEY]" type="text" value="<?=$webset['ucenter']['UC_KEY']?>" style="width:300px" /> 注意：要与UC内的设置一致</td>
  </tr>
  <tr>
    <td align="right">UCenter 访问地址：</td>
    <td>&nbsp;<input name="ucenter[UC_API]" type="text" value="<?=$webset['ucenter']['UC_API']?>"  style="width:300px"/> </td>
  </tr>
  <tr>
    <td align="right">数据库字符集：</td>
    <td>&nbsp;<input name="ucenter[UC_DBCHARSET]" type="text" value="<?=$webset['ucenter']['UC_DBCHARSET']?>" /> </td>
  </tr>
  <tr>
    <td align="right">UCenter 字符集：</td>
    <td>&nbsp;<input name="ucenter[UC_CHARSET]" type="text" value="<?=$webset['ucenter']['UC_CHARSET']?>" /> </td>
  </tr>
  <tr>
    <td align="right">UCenter 数据库服务器：</td>
    <td>&nbsp;<input name="ucenter[UC_DBHOST]" type="text" value="<?=$webset['ucenter']['UC_DBHOST']?>" /> </td>
  </tr>
  <tr>
    <td align="right">UCenter 数据库用户名：</td>
    <td>&nbsp;<input name="ucenter[UC_DBUSER]" type="text" value="<?=$webset['ucenter']['UC_DBUSER']?>" /> </td>
  </tr>
  <tr>
    <td align="right">UCenter 数据库密码：</td>
    <td>&nbsp;<input name="ucenter[UC_DBPW]" type="password" style="width:150px" value="<?=$webset['ucenter']['UC_DBPW']?>" /> </td>
  </tr>
  <tr>
    <td align="right">UCenter 数据库名：</td>
    <td>&nbsp;<input name="ucenter[UC_DBNAME]" type="text" value="<?=$webset['ucenter']['UC_DBNAME']?>" /> </td>
  </tr>
  <tr>
    <td align="right">UCenter 表前缀：</td>
    <td>&nbsp;<input name="ucenter[UC_DBTABLEPRE]" type="text" value="<?=$webset['ucenter']['UC_DBTABLEPRE']?>" /> </td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="step" value="2" /><input type="submit" class="sub" name="sub" value=" 保 存 " /></td>
  </tr>
<?php }?>
</table>
</form>
<script>
phpwindOpen=<?=$webset['phpwind']['open']?>;
$(function(){
    $('input[name=ucenter[open]]').click(function(){
	    if($(this).val()==1 && phpwindOpen==1){
			if(phpwindOpen==1){
			    var word='phpwind整合';
			}
			$('input[name=ucenter[open]]').eq(0).attr("checked", "checked");
		    alert('您已经开启了'+word+'，请关闭后再开启UC整合');
			return false;
		}
	});		  
})
</script>
<?php include(ADMINTPL.'/footer.tpl.php');?>