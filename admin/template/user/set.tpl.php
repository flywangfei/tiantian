<?php include(ADMINTPL.'/header.tpl.php');?>
<script>
$(function(){
    $('input[name=yinxiangma[open]]').click(function(){
        if($(this).val()==1){
		    $('#yinxiangmakey').show();
		}
		else if($(this).val()==0){
		    $('#yinxiangmakey').hide();
		}
	});
})
</script>
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
  <tr>
    <td width="150px" align="right">邮件激活：</td>
    <td>&nbsp;<label><input <?php if($webset['user']['jihuo']==1){?> checked="checked"<?php }?> name="user[jihuo]" type="radio" value="1"/> 开启</label>&nbsp;<label><input <?php if($webset['user']['jihuo']==0){?> checked="checked"<?php }?> name="user[jihuo]" type="radio" value="0"/> 关闭</label></td>
  </tr>
  <tr>
    <td align="right">第三方登陆：</td>
    <td height="30" style="padding:5px;"><label><input <?php if($webset['user']['autoreg']==1){?> checked="checked"<?php }?> name="user[autoreg]" type="radio" value="1"/> 会员使用第三方登陆返回网站后，点击注册，网站自动给会员配置一个初始密码。 </label><br/><label><input <?php if($webset['user']['autoreg']==0){?> checked="checked"<?php }?> name="user[autoreg]" type="radio" value="0"/>会员使用第三方登陆返回网站后，点击注册，需要填写密码邮箱等有效信息。 </label></td>
  </tr>
  <tr>
    <td align="right">签到开关：</td>
    <td>&nbsp;<label><input <?php if($webset['sign']['open']==1){?> checked="checked"<?php }?> name="sign[open]" type="radio" value="1"/> 开启</label>&nbsp;<label><input <?php if($webset['sign']['open']==0){?> checked="checked"<?php }?> name="sign[open]" type="radio" value="0"/> 关闭</label></td>
  </tr>
  <tr>
    <td align="right">签到送金额：</td>
    <td>&nbsp;<input name="sign[money]" value="<?=$webset['sign']['money']?>"/> </td>
  </tr>
  <tr>
    <td align="right">签到送积分：</td>
    <td>&nbsp;<input name="sign[jifen]" value="<?=$webset['sign']['jifen']?>"/> </td>
  </tr>
  <tr>
    <td align="right">注册可选字段：</td>
    <td>&nbsp;<label><input value="1" <?php if($webset['user']['need_alipay']==1){?> checked="checked"<?php }?> type="checkbox" name="user[need_alipay]" />支付宝</label> <label><input value="1" <?php if($webset['user']['need_qq']==1){?> checked="checked"<?php }?> type="checkbox" name="user[need_qq]" />QQ</label></td>
  </tr>
  <tr>
    <td align="right">注册限制：</td>
    <td>&nbsp;<input name="user[reg_between]" value="<?=$webset['user']['reg_between']?>"/>小时内可注册1个。（以IP作为判断依据，0为不限制）</td>
  </tr>
  <tr>
    <td align="right">注册送金额：</td>
    <td>&nbsp;<input name="user[reg_money]" value="<?=$webset['user']['reg_money']?>"/> </td>
  </tr>
  <tr>
    <td align="right">注册送积分：</td>
    <td>&nbsp;<input name="user[reg_jifen]" value="<?=$webset['user']['reg_jifen']?>"/> </td>
  </tr>
  <tr>
    <td align="right">头像上传：</td>
    <td>&nbsp;<?=html_radio(array(1=>'基本模式（兼容性强）',2=>'高级模式（可实现在线裁剪图片的功能）'),$webset['user']['up_avatar'],'user[up_avatar]')?></td>
  </tr>
  <tr>
    <td align="right">印象码验证：</td>
    <td>&nbsp;<?=html_radio(array(0=>'关闭',1=>'开启'),$webset['yinxiangma']['open'],'yinxiangma[open]')?> （注册验证码的另一种表现形式） <a href="http://www.yinxiangma.com/server/register.php?refer=m43rcw" style="text-decoration:underline" target="_blank">官网</a> （请使用本链接注册，作为多多会员可享受更多的优惠）</td>
  </tr>
  <tr id="yinxiangmakey" <?php if($webset['yinxiangma']['open']==0){?> style="display:none"<?php }?>>
    <td align="right">印象码密钥：</td>
    <td>&nbsp;<input name="yinxiangma[key]" value="<?=$webset['yinxiangma']['key']?>"/> </td>
  </tr>
  <tr>
    <td align="right">起始id：</td>
    <td>&nbsp;<?=limit_input('user[auto_increment]',$auto_increment,150,0)?> 会员注册的id以此数值为起点</td>
  </tr>
  <tr>
    <td align="right">会员禁用IP：</td>
    <td>
      <table border="0">
        <tr>
          <td><textarea style="width:400px; height:150px" name="user[limit_ip]"><?=$webset['user']['limit_ip']?></textarea></td>
          <td>禁止登录注册，多个IP可用空格，回车或者逗号隔开。<br/><br/>支持IP段格式，如127.0.*.*</td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
     <td align="right">&nbsp;</td>
     <td>&nbsp;<input type="submit" name="sub" value=" 保 存 设 置 " /></td>
  </tr>
  </form>
</table>
<?php include(ADMINTPL.'/footer.tpl.php');?>