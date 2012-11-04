<?php
if($txstatus=='1'){
	$txstate_msg = "您当前有一笔提现申请正在处理当中，我们将支付到您的支付宝中，请注意查收！ <a href='".u('user','mingxi',array('do'=>'out'))."'>>>查看详细</a>";
}else{
	if($dduser['money']==0){
		$txstate_msg = "感谢您使用".WEBNICK."，当您购物累积获得返现超过".$webset['tixian_limit']."元，就可以申请提现。祝您购物愉快！";
	}elseif($dduser['live_money']<$webset['tixian_limit']){
		$txstate_msg = '亲！您当前的可用余额是 <span>'.$dduser['live_money'].'</span> 元，还差 <span>'.($webset['tixian_limit']-$dduser['live_money']).'</span> 元就可以申请提现了！';
	}else{
		$txstate_msg = "亲！您当前的可用余额是<span>".$dduser['live_money']."</span> 元，可以申请提现了！&nbsp;&nbsp;&nbsp;&nbsp;<img style='margin-bottom:-10px' src='images/face/2.gif'/><a id=tixian name='tx'><b style='color:red;cursor:pointer'>申请提现</b>>>></a>";
	}
}

if($sign==1){
    if($webset['sign']['money']>0 && $webset['sign']['jifen']>0){
	    $sign_word='亲！您今天还没有签到哦！签到可获得 <span>'.$webset['sign']['money'].'</span> 元和 <span>'.$webset['sign']['jifen'].'</span> 积分的奖励！ <img style="margin-bottom:-10px" src="images/face/2.gif"/><a href="javascript:;" id=sign><b style="color:red">点击签到</b>>>></a>';
	}
	elseif($webset['sign']['money']>0 && $webset['sign']['jifen']<=0){
		$sign_word='亲！您今天还没有签到哦！签到可获得 <span>'.$webset['sign']['money'].'</span> 元的奖励！ <img style="margin-bottom:-10px" src="images/face/2.gif"/><a href="javascript:;" id=sign><b style="color:red">点击签到</b>>>></a>';
	}
	elseif($webset['sign']['jifen']>0 && $webset['sign']['money']<=0){
		$sign_word='亲！您今天还没有签到哦！签到可获得 <span>'.$webset['sign']['jifen'].'</span> 积分的奖励！ <img style="margin-bottom:-10px" src="images/face/2.gif"/><a href="javascript:;" id=sign><b style="color:red">点击签到</b>>>></a>';
	}
}
elseif($sign==0){
    $sign_word='亲！您今天的签到奖励已经领取完毕，明天继续吧！';
}

$css[]=TPLURL."/css/usercss.css";
include(TPLPATH."/header.tpl.php");
?>
<script type="text/javascript" src="js/jquery.validate.js"></script>
<script>
$(function(){
    $('#sign').click(function(){
		$.ajax({
		    url:'<?=u('ajax','sign')?>&time=<?=TIME?>',
			dataType:'json',
			success: function(data){
			    if(data.s==0){
				    alert(errorArr[data.id]);
				}
				else if(data.s==1){
					alert('签到完成');
				    location.replace(location.href);
				}
		    }
		});
    });
	
	$('.tubiao_closew').click(function(){
	    $('.adminright_ts1').fadeOut('slow');
		return false;
	});
})

</script>
<div class="mainbody">
	<div class="mainbody1000">
    <?php include(TPLPATH."/user/top.tpl.php");?>
    	<div class="adminmain">
        	<div class="adminleft">
                <?php include(TPLPATH."/user/left.tpl.php");?>
            </div>
        	<div class="adminright">
            <?php if($default_pwd!=''){?>
                <div class="adminright_gg">
                    <div class="gonggaotubiao"></div>
                    <b>提醒：</b> 您的本站原始密码为：<b style=' color:#F00;'><?=$default_pwd?></b> 为了您账号安全请及时修改！ 
                </div>
             <?php }?>
             <?php include(TPLPATH."/user/notice.tpl.php");?>
                <div class="adminright_user">
                    <div class="adminright_user_bt"><S class="adminuser_1"></S><h3>欢迎您：<?=$dduser['name']?></h3><s class="adminuser_2"></s></div>
                    <div class="adminright_user_time"><p>上次登录时间：<?=$dduser['lastlogintime']?></p></div>
                    <div class="adminright_user_main">
                        <div class="adminright_user_main_l">
                            <a href="<?=u('user','avatar')?>"><img src="<?=a($dduser['id'])?>" /></a>
                            <p><a href="<?=u('user','avatar')?>"> 修改头像</a></p>
                        </div>
                      <div class="adminright_user_main_r">
                          <p>可用余额：<span><?=$dduser['live_money']?></span> 元 (未结算：<?=$freeze_money?> 元) <a href="<?=u('user','mingxi')?>"> 收入明细>></a></a> </p>
                          <p>可用积分：<span><?=$dduser['live_jifen']?></span> (未结算：<?=$freeze_jifen?>)    <a href="<?=u('user','huan')?>">兑换明细>></a></p>
                            <p>已 提 现：<span><?=number_format($yitixian,2)?> 元</span>    <a href="<?=u('user','mingxi',array('do'=>'out'))?>">提现明细>></a></p>
                            <p>会员等级：<span><?=$dduser['level']?> <?=$dengji_img?></span></p>
                      </div>
                        
                    </div>
                    <div class="adminright_user_wei"></div>
                </div>
                <div class="adminright_yuye">
                    <div class="tishitubiao"></div>
                    <p><?=$txstate_msg?></p>
                </div>
                <?php if($sign>0){?>
                <div class="adminright_qd">
                    <div class="tishitubiao"></div>
                    <p><?=$sign_word?></p>
                </div>
                <?php }?>
                
                <?php if(($app_show==1 && $apilogin_id==0) || $dduser['realname']==''){?>
                <div class="adminright_ts1">
                	<div class="tubiao_tishi"></div>
                    <div class="adminright_ts1_bt">功能提示和安全设置！</div>
                    <a href="" class="tubiao_closew"></a>
                    <ul>
                    <?php if($app_show==1 && $apilogin_id==0){?>
                    	<li><p>您还没有绑定第三方登陆，享受<?=WEBNICK?>为您提供的多种登陆方式吧！</p><a href="<?=u('user','info',array('do'=>'apilogin'))?>"><div class="tubiao_bangdin"></div></a></li>
                    <?php }?>
                    <?php if($dduser['realname']==''){?>
                        <li id="noborder"><p>您还没有绑定真实姓名，这将使您无法兑现返利，我们建议您立即设置!</p><a href="<?=u('user','info')?>"><div class="tubiao_shezhi"></div></a></li>
                    <?php }?>
                    </ul>
                </div>
                <?php }?>
            </div>
        
        </div>
  </div>
</div>

<?php
include(TPLPATH."/user/tixian.tpl.php");
include(TPLPATH."/footer.tpl.php");
?>