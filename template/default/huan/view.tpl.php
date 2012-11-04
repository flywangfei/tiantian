<?php
$css[]=TPLURL.'/css/duihuan.css';
include(TPLPATH."/header.tpl.php");
?>
<script type="text/javascript" src="js/jquery.validate.js"></script>
<div style="width:1000px; background:#FFF; border:#D0210C 1px solid; margin:auto; margin-top:10px; padding-bottom:10px">
<div id="main">
<?=AD(10)?>
  <div id="apDiv6">
    <?php include(TPLPATH."/huan/left.tpl.php");?>
  </div>
  <div id="apDiv7"><div id="apDiv8">
  <?php include(TPLPATH."/huan/top.tpl.php");?>
  </div>
  <div id="apDiv14">
  <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" style=" margin:auto">
    <tr>
      <td height="60" colspan="2" nowrap="nowrap"><font color="#888888" size="5"><?=$good['title']?></font></td>
  </tr>
  <tr>
    <td width="30%">
    <div style="width:160px;height:160px;background-color:#FFFFFF;border:1px solid #CCCCCC;padding:15px;">
	<?php 
	if($good['num']<1){
		$fs="<div class=swts>&nbsp;</div>";
	}
	elseif($good['num']>0){
		if($good["sdate"]>TIME){
	    	$fs="<div class=wks></div>";
		}
		elseif($good["edate"]<TIME && $good["edate"]>0){
			$fs="<div class=sgq></div>";
		}else{
			$fs="<div class=syts></div>";
		}
	}
	echo $fs;
	?><img  src="<?=$good['img']?>" width="160" height="160" alt="<?=$good['title']?>" /></div></td>
  <td width="57%" valign="top">
    
    <div style="line-height:35px;margin-top:0px;font-size: 14px;color: #999999;">
    <?php if($good['money']>0){?>
    余额兑换 ：<b style=" color:#FF6600; font-size:16px"><?php echo $good['money'];?></b>&nbsp;元
    <?php }else{?>
    余额兑换 ：不参与
    <?php }?>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <?php if($good['jifen']>0){?>
    积分兑换 ：<b style=" color:#FF6600; font-size:16px"><?php echo $good['jifen'];?></b>&nbsp;点
    <?php }else{?>
    积分兑换 ：不参与
    <?php }?>
    </div>
    <div style="line-height:35px;margin-top:3px;font-size: 14px;color: #999999;">剩余库存 ：<b style=" color:#FF6600; font-size:16px"><?php echo $good['num'];?></b>&nbsp;件</div>
    <?php if($good['sdate']>0){?>
    <div style="line-height:35px;margin-top:3px;font-size: 14px;color: #999999;">开始时间 ：<b style=" color:#FF6600; font-size:16px"><?php echo date('Y-m-d',$good['sdate']);?></b></div>
    <?php }?>
    <?php if($good['edate']>0){?>
    <div style="line-height:35px;margin-top:3px;font-size: 14px;color: #999999;">结束时间 ：<b style=" color:#FF6600; font-size:16px"><?php echo date('Y-m-d',$good['edate']);?></b></div>
    <?php }?>

<div class="dhbutton">
<?php if($dduser['name']!=''){?>
	<?php if($good['money']>0){?>
	<button class="money"  id="money" title="<?=$money_dh_msg?>" <?php if($money_dh_status==0){?> disabled="disabled"<?php }?>>余额兑换</button>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<?php }?>
	<?php if($good['jifen']>0){?>
	<button class="jifen"  id="jifen" title="<?=$jifen_dh_msg?>" <?php if($jifen_dh_status==0){?> disabled="disabled"<?php }?>>积分兑换</button>
	<?php }?>
<?php }else{?>
	<?php if($good['money']>0){?>
	<button class="money" onclick="alert('登陆后才可兑换商品！');window.location='<?=SITEURL.'/'.u('user','login')?>&url='+encodeURIComponent(window.location.href)">余额兑换</button>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<?php }?>
	<?php if($good['jifen']>0){?>
	<button class="jifen" onclick="alert('登陆后才可兑换商品！');window.location='<?=SITEURL.'/'.u('user','login')?>&url='+encodeURIComponent(window.location.href)">积分兑换</button>
	<?php }?>
<?php }?>
</div></td></tr></table></div>
<div id="apDiv19"><div id="apDiv20">商品详情</div>
<div id="apDiv21"><?php echo $good['content'];?></div></div>
</div>
</div>
<div style="clear:both"></div>
</div>
<script>
$(function(){
	<?php if($money_dh_status==0){?>
	$('#money').attr('disable','true');
	<?php }?>
	<?php if($jifen_dh_status==0){?>
	$('#jifen').attr('disable','true');
	<?php }?>
	
    $('.dhbutton button').jumpBox({  
	    title: '<?=$good['title']?>',
		LightBox:'show',
		height:350,
		width:450,
		defaultContain:1,
		jsCode:'if($(this).attr("id")=="money"){$("#form1 #mode").val(1)}if($(this).attr("id")=="jifen"){$("#form1 #mode").val(2)}'
    });
	$('#form1').validate({
        errorPlacement: function(error, element){
            var error_td = element.parent('td').next('td');
            error_td.find('.field_notice').hide();
            error_td.append(error);
        },
        success       : function(label){
            label.addClass('validate_right').text('OK!');
        },
        onkeyup: false,
        rules : {
            realname : {
                required : true
            },
            mobile : {
                required : true,
                mobile   : true
            },
            email : {
                required : true,
                email    : true
            },
            qq : {
                required : true,
                range:[1000,999999999999]
            }
        },
        messages : {
            realname : {
                required : '填写姓名'
            },
            mobile  : {
                required : '填写手机号码',
                mobile: '手机号码格式错误'
            },
            email : {
                required : '填写电子邮箱',
                email    : '这不是一个有效的电子邮箱'
            },
			qq : {
                required : '填写您的QQ号码',
                range:'QQ号码位数错误'
            }
        },
		submitHandler: function(form) {
            $form=$('#form1');
            var query=$form.serialize();//document.write(query);
	        var url=$form.attr('action');
	        $.ajax({
		        url: url,
		        type: "POST",
		        data:query,
		        dataType: "json",
		        success: function(data){
			        if(data.s==0){
			            alert(errorArr[data.id]);
			        }
			        else if(data.s==1){
			            alert('兑换成功,等待管理员审核');
						location.replace(location.href);
			        }
					else if(data.s==2){
			            alert('兑换成功,请查收站内信领取<?=SITEURL?>');
						window.location.href='<?=SITEURL.'/'.u('user','msg')?>';
			        }
		        }
	        });
        } 
    });
});
</script>
<div id="dhFormHtml">
<div class="LightBox" id="LightBox"></div><div id="jumpbox" show="0" class="jumpbox"><div class="top_left"></div><div class="top_center"></div><div class="top_right"></div><div class="middle_left"></div><div class="middle_center"><div class="close"><a></a></div><p class="title"></p><div class="contain">
<form id="form1" name="form1" method="post" action="<?=u('ajax','huan')?>">
                        <table width="350" border="0" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="50" height="35" align="right">姓名：</td>
                            <td width="150" align="left"><input name="realname" type="text" class="ddinput" value="<?=$dduser['realname']?>" id="realname" style="width:120px;" /></td>
                            <td width="150" align="right"><label class="field_notice">请填写收货人姓名</label></td>
                          </tr>
						  <tr>
                            <td width="" height="35" align="right">手机：</td>
                            <td align="left"><input name="mobile" type="text" class="ddinput" value="<?=$dduser['mobile']?>" id="mobile" style="width:120px;" /></td>
                            <td width="" align="right"><label class="field_notice">请填写常用手机号码</label></td>
                          </tr>
						  <tr>
                            <td width="" height="35" align="right">地址：</td>
                            <td align="left"><input name="address" type="text" class="ddinput" value="" id="address" style="width:120px;" /></td>
                            <td width="" align="right"><label class="field_notice">请填写收货地址</label></td>
                          </tr>
						  <tr>
                            <td width="" height="35" align="right">邮箱：</td>
                            <td align="left"><input name="email" type="text" class="ddinput" value="<?=$dduser['email']?>" id="email" style="width:120px;" /></td>
                            <td width="" align="right"><label class="field_notice">请填写您的邮箱</label></td>
                          </tr>
						  <tr>
                            <td width="" height="35" align="right">QQ：</td>
                            <td align="left"><input name="qq" type="text" class="ddinput" value="<?=$dduser['qq']?>" id="qq" style="width:120px;" /></td>
                            <td width="" align="right"><label class="field_notice">请填写您的QQ</label></td>
                          </tr>
						  <tr>
                            <td width="" height="35" align="right">备注：</td>
                            <td align="left"><textarea name="content" class="ddinput" id="content" style="width:140px;height:44px;line-height:22px;"></textarea></td>
                            <td width="" align="right"><label class="field_notice">请填写附加备注</label></td>
                          </tr>
						  <tr>
                            <td width="" height="35" align="right"></td>
                            <td align="left"><div class="img-button "><p><input type="hidden" id="mode" name="mode" value="1" /><input type="hidden" id="id" name="id" value="<?=$id?>" /><input type="submit" value="提 交" class="ShiftClass" /></p></div></td>
                            <td width="" align="left"><label class="field_notice"></label></td>
                          </tr>
      </table>
        </form>
</div></div><div class="middle_right"></div><div class="end_left"></div><div class="end_center"></div><div class="end_right"></div></div>
</div>
<?php include(TPLPATH."/footer.tpl.php");?>