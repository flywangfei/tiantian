<script>
$(function(){
    $('#tixian').jumpBox({  
	    title: '您申请的提现我们会打入您的支付宝账户，请仔细填写您的支付宝和对应姓名，以免出错！',
		titlebg:1,
		height:420,
		width:580,
		defaultContain:1
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
            money : {
                required : true,
				<?php if($webset['txxz']>0){?>
				multiple : <?=$webset['txxz']?>,
				<?php }?>
				range    : [<?=$webset['tixian_limit']?>,<?=$dduser['live_money']?>]
            },
            alipay : {
                required : true,
                alipay   : true,
				remote   : {
                    url :'index.php?mod=ajax&act=check_my_alipay',
                    type:'post',
                    data:{
                        alipay : function(){ return $('#alipay').val();},dduserid:<?=$dduser['id']?>
                    },
                    beforeSend:function(){
                        var _checking = $('#checking_my_alipay');
                        _checking.prev('.field_notice').hide();
                        _checking.next('label').hide();
                        $(_checking).show();
                    },
                    complete :function(){
                        $('#checking_my_alipay').hide();
                    }
                }
            },
            alipay2 : {
                required : true,
                equalTo  : '#alipay'
            },
            realname : {
                required : true
            },
			mobile : {
				mobile   : true
            },
			ddpassword : {
                required : true,
                minlength: 6
            }
        },
        messages : {
            money : {
                required : '提现金额必填',
				range    : '提现金额应大于<?=$webset['tixian_limit']?>且小于<?=$dduser['live_money']?>',
                multiple : '提现金额不是<?=$webset['txxz']?>的整数倍'
            },
            alipay  : {
                required : '支付宝必填',
                alipay:'支付宝格式错误',
				remote:'支付宝已被注册'
            },
            alipay2 : {
                required : '支付宝必填',
                equalTo    : '两次支付宝不相同'
            },
			realname : {
                required : '姓名必填'
            },
			mobile : {
                mobile : '手机号码格式错误'
            },
			ddpassword : {
                required : '登陆密码必填',
				minlength: '密码位数错误'
            }
        },
		submitHandler: function(form) {   
			ajaxPostForm(form,'','提现成功，等待审核');
        } 
    });
});
</script>
<?php
if($dduser['alipay']!=''){$alipay_dis='disabled="disabled"';}
if($dduser['realname']!=''){$realname_dis='disabled="disabled"';}
$mobile=$dduser['mobile']?$dduser['mobile']:'';
?>
<div class="LightBox" id="LightBox"></div><div id="jumpbox" show="0" class="jumpbox"><div class="top_left"></div><div class="top_center"></div><div class="top_right"></div><div class="middle_left"></div><div class="middle_center"><div class="close"><a></a></div><p class="title"></p><div class="contain">
<form id="form1" name="form1" autocomplete="off" method="post" action="<?=u('ajax','tixian')?>">
                        <table width="505" border="0" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="116" height="35" align="right">可提现金额：</td>
                            <td width="" height="35" align="left"><b class="bignum"><?=$dduser['live_money']?></b>元</td>
                            <td width="270" align="right"></td>
                          </tr>
						  <tr>
                            <td width="" height="35" align="right">申请提现：</td>
                            <td align="left"><input name="money" type="text" class="ddinput" value="<?=$dduser['live_money']?>" id="money" style="width:120px;" /></td>
                            <td width="" align="left"><label class="field_notice">请填写<b class="bignum"><?=$webset['txxz']?></b>元的整数倍，小于<b class="bignum"><?=$dduser['live_money']?></b>元</label></td>
                          </tr>
						  <tr>
                            <td width="" height="35" align="right">支付宝账号：</td>
                            <td align="left"><input name="alipay" <?=$alipay_dis?> type="text" class="ddinput" value="<?=$dduser['alipay']?>" id="alipay" style="width:120px;" /></td>
                            <td width="" align="left"><label class="field_notice">请正确填写支付宝账号，保存后不可修改</label><label id="checking_my_alipay" class="checking">检查中...</label></td>
                          </tr>
						  <tr>
                            <td width="" height="35" align="right">确认支付宝账号：</td>
                            <td align="left"><input name="alipay2" <?=$alipay_dis?> type="text" class="ddinput" value="<?=$dduser['alipay']?>" id="alipay2" style="width:120px;" /></td>
                            <td width="" align="left"><label class="field_notice">请再次确认支付宝账号，保存后不可修改</label></td>
                          </tr>
						  <tr>
                            <td width="" height="35" align="right">收款人姓名：</td>
                            <td align="left"><input name="realname" <?=$realname_dis?> type="text" class="ddinput" value="<?=$dduser['realname']?>" id="realname" style="width:120px;" /></td>
                            <td width="" align="left"><label class="field_notice">转账核对时用，填写后不可修改(与支付宝对应)</label></td>
                          </tr>
						  <tr>
                            <td width="" height="35" align="right">手机号：</td>
                            <td align="left"><input name="mobile" type="text" class="ddinput" value="<?=$mobile?>" id="mobile" style="width:120px;" /></td>
                            <td width="" align="left"><label class="field_notice">填写后，提现成功，会免费短信通知您</label></td>
                          </tr>
						  <tr>
                            <td width="" height="35" align="right">登陆密码：</td>
                            <td align="left"><input name="ddpassword" type="password" class="ddinput" value="" id="ddpassword" style="width:120px;" /></td>
                            <td width="" align="left"><label class="field_notice">必须填写，网站登陆密码</label> </td>
                          </tr>
                          <tr>
                            <td width="" height="35" align="right">特别说明：</td>
                            <td align="left" colspan="2"><textarea name="remark" id="remark" class="ddinput" style="width:180px; height:50px; line-height:15px; padding-top:5px"></textarea><div style="float:left;color:#9C9C9C; line-height:50px; margin-left:5px">没有特别说明请留空</div></td>
                          </tr>
						  <tr>
                            <td width="" height="35" align="right"></td>
                            <td align="left" colspan="2"><div class="img-button "><p><input type="submit" value="提 交" class="ShiftClass" /></p></div></td>
                          </tr>
      </table>
        </form>
</div></div><div class="middle_right"></div><div class="end_left"></div><div class="end_center"></div><div class="end_right"></div></div>