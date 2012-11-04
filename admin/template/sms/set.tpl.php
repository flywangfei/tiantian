<?php include(ADMINTPL.'/header.tpl.php');?>
<script>
$(function(){
	$('#testMobile').click(function(){
		var sms={};
		sms.name=$('#smsname').val(); 
		sms.pwd=$('#smspwd').val(); 
		sms.mobile=$('#test_mobile').val();
		sms.test=1;
		$sub=$(this);
		$sub.attr({'disabled':true});
		if(sms.name=='' || sms.pwd=='' || sms.mobile==''){
			alert('缺少信息');
			$sub.attr({'disabled':false});
		}
		else{
			$.post('<?=u(MOD,ACT)?>',sms,function(data){
			    //data=parseInt(data);
				if(data==1){
				    alert('短信发送成功！');
					var t=parseInt($('#smsname').next('b').html())-1;
					$('#smsname').next('b').html(t);
				}
				else{
				    alert(data);
				}
			    $sub.attr({'disabled':false});
		    });
	    }
    });
});
</script>
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
  <tr>
    <td width="150px" align="right">账号：</td>
    <td>&nbsp;<input type="text" name="sms[name]" id="smsname" value="<?=$webset['sms']['name']?>" /> <?=$re?></td>
  </tr>
  <tr>
    <td align="right">原密码：</td>
    <td>&nbsp;<?=limit_input('sms[pwd]')?> 点击激活修改</td>
  </tr>
  <tr>
    <td align="right">新密码：</td>
    <td>&nbsp;<?=limit_input('sms[newpwd]')?> 点击激活修改</td>
  </tr>
  <tr>
    <td width="150px" align="right">手机号：</td>
    <td>&nbsp;<input type="text" name="sms[mobile]" id="smspwd" value="<?=$webset['sms']['mobile']?>" /> 填写您常用的手机号码</td>
  </tr>
  <tr>
    <td align="right">短信通知：</td>
    <td>
      <?php foreach($msgset_title as $k=>$v){?>
      &nbsp;<label><input <?php if($webset['sms'][$k.'_send']==1){?> checked="checked"<?php }?> name="sms[<?=$k.'_send'?>]" type="checkbox" value="1"/> <?=$v?></label>
      <?php }?>
    </td>
  </tr>
  <tr>
    <td width="150px" align="right">手机号码验证：</td>
    <td>&nbsp;<label><input <?php if($webset['sms']['check']==1){?> checked="checked"<?php }?> name="sms[check]" type="radio" value="1"/> 开启</label>&nbsp;<label><input <?php if($webset['sms']['check']==0){?> checked="checked"<?php }?> name="sms[check]" type="radio" value="0"/> 关闭</label> 验证会员手机号码是否可用</td>
  </tr>
  <tr>
    <td align="right">测试手机号：</td>
    <td>&nbsp;<input id="test_mobile" value="" />&nbsp;<input type="button" value="测试短信发送"  id="testMobile" /></td>
  </tr>
  <tr>
     <td align="right">&nbsp;</td>
     <td>&nbsp;<input type="submit" name="sub" value=" 保 存 设 置 " /></td>
  </tr>
  </form>
</table>
<?php include(ADMINTPL.'/footer.tpl.php');?>