<?php
$css[]=TPLURL."/css/usercss.css";
include(TPLPATH."/header.tpl.php");
?>
<script charset="utf-8" type="text/javascript" src="js/jquery.validate.js" ></script>
<script>

$(function(){
    $('#infoset').validate({
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
            old_password : {
                required : true,
                byteRange: [6,20],
				remote   : {
                    url :'index.php?mod=ajax&act=check_oldpass',
                    type:'post',
                    data:{
                        oldpass : function(){ return $('#old_password').val();},dduserid:<?=$dduser['id']?>
                    },
                    beforeSend:function(){
                        var _checking = $('#checking_oldpass');
                        _checking.prev('.field_notice').hide();
                        _checking.next('label').hide();
                        $(_checking).show();
                    },
                    complete :function(){
                        $('#checking_oldpass').hide();
                    }
                }
            },
            email : {
                required : true,
                email    : true,
				remote   : {
                    url :'index.php?mod=ajax&act=check_my_email',
                    type:'post',
                    data:{
                        email : function(){return $('#email').val();},dduserid:<?=$dduser['id']?>
                    },
                    beforeSend:function(){
                        var _checking = $('#check_my_email');
                        _checking.prev('.field_notice').hide();
                        _checking.next('label').hide();
                        $(_checking).show();
                    },
                    complete :function(){
                        $('#check_my_email').hide();
                    }
                }
            },
            qq : {
                required : true,
                range:[1000,999999999999]
            },
			alipay : {
			    required : true,
				alipay    : true,
				remote   : {
                    url :'index.php?mod=ajax&act=check_my_alipay',
                    type:'post',
                    data:{
                        oldpass : function(){ return $('#alipay').val();},dduserid:<?=$dduser['id']?>
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
			realname: {
			    required : true
			},
            mobile: {
			    required : true,
				mobile   : true
			}
        },
        messages : {
            old_password : {
                required : '您必须填写旧密码',
                byteRange: '密码必须在6-30个字符之间',
				remote   : '密码错误'
            },
            email : {
                required : '您必须提供您的电子邮箱',
                email    : '这不是一个有效的电子邮箱',
				remote   : '邮箱已存在'
            },
			qq : {
                required : '您必须提供您的QQ号码',
                range:'QQ号码位数错误'
            },
			alipay : {
                required : '您必须提供您的支付宝',
                alipay:'支付宝格式错误',
				remote:'支付宝已被注册'
            },
			realname : {
			    required : '真实姓名必须填写'
			},
			mobile : {
			    required : '手机号码必须填写',
				mobile   : '手机号码格式错误'
			}
        },
		submitHandler: function(form) {   
            var query=$(form).serialize();
	        var url=$(form).attr('action');
	        ajaxPost(url,query);
        } 
    });
	
	$('#tixianpwdset').validate({
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
            old_tixianpwd : {
                required : true,
                byteRange: [6,20]
            },
            tixianpwd : {
                required : true,
                minlength: 6
            },
            tixianpwd_confirm : {
                required : true,
                equalTo  : '#tixianpwd'
            }
        },
        messages : {
            old_tixianpwd : {
                required : '您必须填写旧密码',
                byteRange: '密码必须在6-30个字符之间',
				remote   : '密码错误'
            },
            tixianpwd  : {
                required : '您必须提供一个密码',
                minlength: '密码长度应在6-20个字符之间'
            },
            tixianpwd_confirm : {
                required : '您必须再次确认您的密码',
                equalTo  : '两次输入的密码不一致'
            }
        },
		submitHandler: function(form) {   
	        var query=$(form).serialize();
	        var url=$(form).attr('action');
	        ajaxPost(url,query);
        }
    });
	
	$('#pwdset').validate({
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
            old_pwd : {
                required : true,
                byteRange: [6,20],
				remote   : {
                    url :'index.php?mod=ajax&act=check_oldpass',
                    type:'post',
                    data:{
                        oldpass : function(){ return $('#old_pwd').val();},dduserid:<?=$dduser['id']?>
                    },
                    beforeSend:function(){
                        var _checking = $('#checking_oldpass');
                        _checking.prev('.field_notice').hide();
                        _checking.next('label').hide();
                        $(_checking).show();
                    },
                    complete :function(){
                        $('#checking_oldpass').hide();
                    }
                }
            },
            ddpwd : {
                required : true,
                minlength: 6
            },
            pwd_confirm : {
                required : true,
                equalTo  : '#ddpwd'
            }
        },
        messages : {
            old_pwd : {
                required : '您必须填写旧密码',
                byteRange: '密码必须在6-30个字符之间',
				remote   : '密码错误'
            },
            ddpwd  : {
                required : '您必须提供一个密码',
                minlength: '密码长度应在6-20个字符之间'
            },
            pwd_confirm : {
                required : '您必须再次确认您的密码',
                equalTo  : '两次输入的密码不一致'
            }
        },
		submitHandler: function(form) {   
	        var query=$(form).serialize();
	        var url=$(form).attr('action');
	        ajaxPost(url,query);
        }
    });
});
</script>

<body>
<div class="mainbody">
	<div class="mainbody1000">
    <?php include(TPLPATH."/user/top.tpl.php");?>
    	<div class="adminmain">
        	<div class="adminleft">
                <?php include(TPLPATH."/user/left.tpl.php");?>
            </div>
        	<div class="adminright">
                <?php include(TPLPATH."/user/notice.tpl.php");?>
                <div class="admin_xfl">
                  <ul>
                    <li id="myinfo"><a href="<?=u('user','info',array('do'=>'myinfo'))?>">个人信息设置</a> </li>
                    <li id="pwd"><a href="<?=u('user','info',array('do'=>'pwd'))?>">登陆密码设置</a> </li>
                    <?php if($app_show==1){?>
                    <li id="apilogin"><a href="<?=u('user','info',array('do'=>'apilogin'))?>">账号通设置</a> </li>
                    <?php }?>
                    </ul>
                    <script>
                    $(function(){
					    $('.admin_xfl li#<?=$do?>').addClass('admin_xfl_xz');
					})
                    </script>
              	</div>
                <div class="admin_table">
                <?php if($do=='myinfo'){?>
                <form id="infoset" name="form1" action="<?=u('user','info',array('do'=>'myinfo'))?>" method="post" style=" padding-left:50px">
    <table border="0" align="left" cellpadding="0" cellspacing="0" class="no_table">
		<tr>
		  <td width="21%" height="35" style="text-align:right">原密码 *&nbsp;&nbsp;&nbsp;</td>
		  <td width="30%"><input name="old_password" type="password" style="width:130px;" id="old_password" class="ddinput" /></td>
		  <td width="" id="ckuser"><label class="field_notice">填写原密码</label><label id="checking_oldpass" class="checking">检查中...</label></td>
		</tr>
		<tr>
		  <td height="35" style="text-align:right">QQ号码 *&nbsp;&nbsp;&nbsp;</td>
		  <td><input name="qq" type="text" id="qq" value="<?=$dduser['qq']?>"  onkeyup="value=value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))" size="20" maxlength="50" style="width:130px;" class="ddinput"/></td>
		  <td id="ckqq2"><label class="field_notice">以便客服及时联系您</label></td>
		</tr>
		<tr>
		  <td height="35" style="text-align:right">电子邮箱 *&nbsp;&nbsp;&nbsp;</td>
		  <td><input name="email" type="text" id="email" value="<?=$dduser['email']?>" style="width:130px;" class="ddinput"/></td>
		  <td><label class="field_notice">请务必填写正确，取回密码用</label><label id="checking_my_email" class="checking">检查中...</label></td>
		</tr>
		<tr>
		  <td height="35" style="text-align:right">支付宝账号 *&nbsp;&nbsp;&nbsp;</td>
		  <td><input name="alipay" type="text" id="alipay"  style="width:130px;" value="<?=$dduser['alipay']?>" maxlength="50" <?php if ($dduser['alipay']!=""){ echo "readonly='readonly' disabled";}?> class="ddinput"/></td>
		  <td id="ckemail"><label class="field_notice">填写后不可更改</label><label id="checking_my_alipay" class="checking">检查中...</label></td>
		</tr>
        
        <tr>
		  <td height="35" style="text-align:right">真实姓名 *&nbsp;&nbsp;&nbsp;</td>
		  <td><input name="realname" type="text" id="realname" value="<?=$dduser['realname']?>" maxlength="50" <?php if ($dduser['realname']!=""){ echo "readonly='readonly' disabled";}?> style="width:130px;" class="ddinput"/></td>
		  <td id="ckemail"><label class="field_notice">填写后不可更改</label></td>
		</tr>
        
        <tr>
		  <td height="35" style="text-align:right">手机号码 *&nbsp;&nbsp;&nbsp;</td>
		  <td><input name="mobile" type="text" id="mobile" style="width:130px;" value="<?=$dduser['mobile']?>" class="ddinput"/></td>
		  <td id="ckemail"><label class="field_notice">请务必填写正确</label></td>
		</tr>
		<tr>
		  <td height="35">&nbsp;</td>
		  <td><input type="hidden" name="sub" value="1" /><div class="img-button "><p><input type="submit" value="保存信息" /></p></div></td>
		  <td></td>
		</tr>
	  </table>
      </form>
<?php }elseif($do=='apilogin'){?>

<?php if(count($api)>0){?> 
<div style="padding-left:50px; padding-top:15px">
<div id="setting_form" class="account_bind">
<div>绑定帐号享受<?=WEBNICK?>为您带来的多种登陆方式。</div>
<ul class="bind_logo">
<?php foreach($api as $row){?>
<li>
<img alt="<?=$row['title']?>" src="<?=TPLURL?>/images/login/<?=$row['code']?>_3.png">
<div class="bind_web">
<?php if(in_array($row['code'],$user_api)){?>
<span class="unbind">您已绑定<?=$row['title']?></span><br/>
<a style="color:#F00" href="<?=u('api','do',array('do'=>'del','web'=>$row['code']))?>" onclick='return confirm("确定解除?")'>解除绑定</a>
<?php }else{?>
<span class="unbind">你还未绑定<?=$row['title']?></span><br>
<a href="<?=u('api',$row['code'])?>">绑定账号</a>
<?php }?>
</div>
</li>
<?php }?>
</ul>
</div>
              </div>
<?php }?>

                      <?php }elseif($do=='pwd'){?>
                      <form id="pwdset" name="form1" action="<?=u('user','info',array('do'=>'pwd'))?>" method="post" style=" padding-left:50px">
    <table border="0" align="left" cellpadding="0" cellspacing="0" bordercolorlight="#9acd32" class="no_table">
		<tr>
		  <td width="21%" height="35"  style="text-align:right">原密码 *&nbsp;&nbsp;&nbsp;</td>
		  <td width="30%"><input name="old_pwd" type="password" style="width:130px;" id="old_pwd" class="ddinput" /></td>
		  <td id="ckuser"><label class="field_notice">填写原密码</label><label id="checking_oldpass" class="checking">检查中...</label></td>
		</tr>
		<tr>
		  <td height="35" style="text-align:right">新密码 *&nbsp;&nbsp;&nbsp;</td>
		  <td><input name="ddpwd" type="password" id="ddpwd" size="20" maxlength="20" style="width:130px;" class="ddinput"/></td>
		  <td id="ckpass"><label class="field_notice">密码为长度 6 - 20 位</label></td>
		</tr>
		<tr>
		  <td height="35" style="text-align:right">确认密码 *&nbsp;&nbsp;&nbsp;</td>
		  <td><input name="pwd_confirm" type="password" id="pwd_confirm" style="width:130px;" class="ddinput"/></td>
		  <td id="ckpass2"><label class="field_notice">请再次确认密码</label></td>
		</tr>
		<tr>
		  <td height="35">&nbsp;</td>
		  <td><input type="hidden" name="sub" value="1" /><div class="img-button "><p><input type="submit" value="保存信息"/></p></div></td>
		  <td></td>
		</tr>
	  </table>
      </form>
                      <?php }?>
              </div>
        	  
        	</div>
    	</div>
  </div>
</div>
<?php
include(TPLPATH."/footer.tpl.php");
?>