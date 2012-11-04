<?php include(ADMINTPL.'/header.tpl.php');?>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115px" align="right">会员名：</td>
    <td>&nbsp;<input name="ddusername" type="text" id="ddusername" value="<?=$row['ddusername']?>" /> <a href="<?=u('msg','addedi',array('name'=>$row['ddusername']))?>">发送站内信</a></td>
  </tr>
  <tr>
    <td align="right">登陆密码：</td>
    <td>&nbsp;<?=limit_input('ddpassword')?> 点击激活修改</td>
  </tr>
  <tr>
    <td align="right">真实姓名：</td>
    <td>&nbsp;<input name="realname" type="text" id="realname" value="<?=$row['realname']?>" /> </td>
  </tr>
  <tr>
    <td align="right">注册时间：</td>
    <td>&nbsp;<input name="regtime" type="text" id="regtime" value="<?=$row['regtime']?>" /></td>
  </tr>
  <tr>
    <td align="right">注册IP：</td>
    <td>&nbsp;<input name="regip" type="text" id="regip" value="<?=$row['regip']?>" /></td>
  </tr>
  <tr>
    <td align="right">登陆次数：</td>
    <td>&nbsp;<input name="loginnum" type="text" id="loginnum" value="<?=$row['loginnum']?>" /></td>
  </tr>
  <tr>
    <td align="right">上次登录时间：</td>
    <td>&nbsp;<input name="lastlogintime" type="text" id="lastlogintime" value="<?=$row['lastlogintime']?>" /></td>
  </tr>
  <tr>
    <td align="right">上次提现时间：</td>
    <td>&nbsp;<input name="lasttixian" type="text" id="lasttixian" value="<?=$row['lasttixian']?date('Y-m-d H:i:s',$row['lasttixian']):''?>" /></td>
  </tr>
  <tr>
    <td align="right">支付宝：</td>
    <td>&nbsp;<input name="alipay" type="text" id="alipay" value="<?=$row['alipay']?>" /></td>
  </tr>
  <tr>
    <td align="right">邮箱：</td>
    <td>&nbsp;<input name="email" type="text" id="email" value="<?=$row['email']?>" /></td>
  </tr>
  <tr>
    <td align="right">金额：</td>
    <td>&nbsp;<input name="money" type="text" id="money" value="<?=$row['live_money']?>" /></td>
  </tr>
  <tr>
    <td align="right">积分：</td>
    <td>&nbsp;<input name="jifen" type="text" id="jifen" value="<?=$row['live_jifen']?>"  /></td>
  </tr>
  <?php if($webset['taoapi']['freeze']>0){?>
  <tr>
    <td align="right">未结算金额：</td>
    <td>&nbsp;<?=$row['freeze_money']?> 
	<?php if($webset['taoapi']['freeze']==1){?><a style="text-decoration:underline" onclick='return confirm("确定要结算?")' href="<?=u('freeze','addedi',array('uid'=>$row['id']))?>">去结算</a> (金额和积分同时结算)<?php }?>
    <?php if($webset['taoapi']['freeze']==2){?>（16日内淘宝订单金额不准提现）<?php }?>
    </td>
  </tr>
  <tr>
    <td align="right">未结算积分：</td>
    <td>&nbsp;<?=$row['freeze_jifen']?></td>
  </tr>
  <?php }?>
  <tr>
    <td align="right">等级：</td>
    <td>&nbsp;<input name="level" type="text" id="level" value="<?=$row['level']?>" /></td>
  </tr>
  <tr>
    <td align="right">红心：</td>
    <td>&nbsp;<input name="hart" type="text" id="hart" value="<?=$row['hart']?>" /></td>
  </tr>
  <tr>
    <td align="right">推荐人id：</td>
    <td>&nbsp;<?=limit_input('tjr',$row['tjr'],150,0)?> 会员：<?=$duoduo->select('user','ddusername','id="'.$row['tjr'].'"')?></td>
  </tr>
  <tr>
    <td align="right">QQ：</td>
    <td>&nbsp;<input name="qq" type="text" id="qq" value="<?=$row['qq']?>" /> <?=qq($row['qq'])?></td>
  </tr>
  <tr>
    <td align="right">手机：</td>
    <td>&nbsp;<input name="mobile" type="text" id="mobile" value="<?=$row['mobile']?>" /></td>
  </tr>
  <tr>
    <td align="right">绑定网站：</td>
    <td>&nbsp;<?=$webnames?></td>
  </tr>
  <tr>
    <td align="right">已提现：</td>
    <td>&nbsp;<?=limit_input('yitixian',$row['yitixian'],150,0)?></td>
  </tr>
  <tr>
    <td align="right">UCenter id：</td>
    <td>&nbsp;<?=limit_input('ucid',$row['ucid'],150,0)?></td>
  </tr>
  <tr>
    <td align="right">提现状态：</td>
    <td>&nbsp;<?=html_radio($tixian_status,$row['txstatus'],'txstatus')?></td>
  </tr>
  <tr>
    <td align="right">兑换状态：</td>
    <td>&nbsp;<?=html_radio($duihuan_status,$row['dhstate'],'dhstate')?></td>
  </tr>
  <tr>
    <td align="right">上次签到时间：</td>
    <td>&nbsp;<input name="signtime" type="text" id="signtime" value="<?=$row['signtime']>0?date('Y-m-d H:i:s',$row['signtime']):0?>" /></td>
  </tr>
  <tr>
    <td align="right">激活：</td>
    <td>&nbsp;<?=html_radio($jihuo_status,$row['jihuo'],'jihuo')?></td>
  </tr>
  <tr>
    <td align="right">返现宝：</td>
    <td>&nbsp;<?=html_radio($fxb_status,$row['fxb'],'fxb')?></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="id" value="<?=$row['id']?>" /><input type="submit" class="sub" name="sub" value=" 保 存 " /></td>
  </tr>
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>