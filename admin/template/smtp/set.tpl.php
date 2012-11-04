<?php include(ADMINTPL.'/header.tpl.php');$type=array(1=>'smtp',2=>'mail');$xingshi=array(0=>'后台形式',1=>'直接形式');$msgset_title=$duoduo->select_2_field('msgset','id,title','1=1');?>
<script>
$(function(){
	$('#testEmail').click(function(){
		var smtphost=$('#smtphost').val(); 
		var smtpuser=$('#smtpuser').val(); 
		var smtppwd=$('#smtppwd').val(); 
		var test_email=$('#test_email').val();
		var test_title=$('#test_title').val();
		var test_content=$('#test_content').val();
		var type=$('input[name="smtp[type]"]:checked').val();
		$sub=$(this);
		$sub.attr({'disabled':true});
		if(smtphost=='' || smtpuser=='' || smtppwd=='' || test_email==''){
			alert('缺少信息');
			$sub.attr({'disabled':false});
		}
		else{
			$.post('<?=u('smtp','set')?>',{'smtphost':smtphost,'smtpuser':smtpuser,'smtppwd':smtppwd,'test_email':test_email,'type':type,'title':test_title,'html':test_content},function(data){
			    data=parseInt(data);
				if(data==0){
				    alert('邮件发送失败！');
				}
				else if(data==1){
				    alert('邮件发送成功！');
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
<div class="explain-col">某些邮箱用接口发送邮件会屏蔽某些词语造成发送失败。
  </div>
<br />
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115px" align="right">模式：</td>
    <td>&nbsp;<?=html_radio($type,$webset['smtp']['type'],'smtp[type]')?> <span style="color:#FF6600">一般选择smtp方式，个别linux可选择mail方式。</span></td>
  </tr>
  <tr>
    <td width="115px" align="right">发送形式：</td>
    <td>&nbsp;<?=html_radio($xingshi,$webset['smtp']['xingshi'],'smtp[xingshi]')?> <span style="color:#FF6600">一般选择后台形式，如果发现服务器反映过慢，选择直接形式。</span></td>
  </tr>
  <tr>
    <td width="115px" align="right">地址：</td>
    <td>&nbsp;<input id="smtphost" name="smtp[host]" value="<?=$webset['smtp']['host']?>" /> <span style="color:#FF6600">如：smtp.126.com。建议使用126邮箱，QQ邮箱需要自行在QQ邮箱设置</span></td>
  </tr>
  <tr>
    <td align="right">用户名：</td>
    <td>&nbsp;<input id="smtpuser" name="smtp[name]" value="<?=$webset['smtp']['name']?>" />&nbsp;<span style="color:#FF6600">您的邮箱用户名，如service@duoduo123.com。</span></td>
  </tr>
  <tr>
    <td align="right">密码：</td>
    <td>&nbsp;<?=limit_input("smtp[pwd]")?>&nbsp;<span style="color:#FF6600">您的邮箱密码，点击激活修改。</span></td>
  </tr>
  <tr>
    <td align="right">邮件通知：</td>
    <td>
      <?php foreach($msgset_title as $k=>$v){?>
      &nbsp;<label><input <?php if($webset['email_notice'][$k.'_send']==1){?> checked="checked"<?php }?> name="email_notice[<?=$k.'_send'?>]" type="checkbox" value="1"/> <?=$v?></label>
      <?php }?>
      <input type="hidden" value="1" name="email_notice[dd]" /></td>
  </tr>
  <tr>
    <td align="right">测试邮箱：</td>
    <td>&nbsp;<input id="test_email" value="" /></td>
  </tr>
  <tr>
    <td align="right">测试标题：</td>
    <td>&nbsp;<input id="test_title" value="测试标题" /></td>
  </tr>
  <tr>
    <td align="right">测试内容：</td>
    <td>&nbsp;<input id="test_content" value="测试内容" style="width:300px" />&nbsp;<input type="button" value="测试邮件发送"  id="testEmail" /></td>
  </tr>
  <tr>
     <td align="right">&nbsp;</td>
     <td>&nbsp;<input type="submit" name="sub" value=" 保 存 设 置 " /></td>
  </tr>
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>