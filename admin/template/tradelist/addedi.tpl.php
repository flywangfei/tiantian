<?php include(ADMINTPL.'/header.tpl.php');?>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115px" align="right">商品：</td>
    <td>&nbsp;<?=$row['item_title']?></td>
  </tr>
  <tr>
    <td align="right">确认收货时间：</td>
    <td>&nbsp;<?=$row['pay_time']?></td>
  </tr>
  <tr>
    <td align="right">店铺：</td>
    <td>&nbsp;<?=$row['shop_title']?></td>
  </tr>
  <tr>
    <td align="right">掌柜：</td>
    <td>&nbsp;<?=$row['seller_nick']?></td>
  </tr>
  <tr>
    <td align="right">商品类别id：</td>
    <td>&nbsp;<?=$row['category_id']?></td>
  </tr>
  <tr>
    <td align="right">商品类别名称：</td>
    <td>&nbsp;<?=$row['category_name']?></td>
  </tr>
  <tr>
    <td align="right">商品id：</td>
    <td>&nbsp;<?=$row['num_iid']?></td>
  </tr>
  <tr>
    <td align="right">订单号：</td>
    <td>&nbsp;<?=$row['trade_id']?></td>
  </tr>
  <tr>
    <td align="right">单价：</td>
    <td>&nbsp;<?=$row['pay_price']?>元</td>
  </tr>
  <tr>
    <td align="right">数量：</td>
    <td>&nbsp;<?=$row['item_num']?></td>
  </tr>
  <tr>
    <td align="right">总额：</td>
    <td>&nbsp;<?=$row['item_num']*$row['pay_price']?>元</td>
  </tr>
  <tr>
    <td align="right">佣金比例：</td>
    <td>&nbsp;<?=$row['commission_rate']*100?>%</td>
  </tr>
  <tr>
    <td align="right">佣金：</td>
    <td>&nbsp;<?=$row['commission']?>元</td>
  </tr>
  <tr>
    <td align="right">返利：</td>
    <td>&nbsp;<?=$row['fxje']?>元</td>
  </tr>
  <tr>
    <td align="right">积分：</td>
    <td>&nbsp;<?=$row['jifen']?></td>
  </tr>
  <?php if($row['checked']==2){?>
  <tr>
    <td align="right">会员：</td>
    <td>&nbsp;<?=$duoduo->select('user','ddusername','id="'.$row['uid'].'"')?> 会员ID：<?=$row['uid']?></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="id" value="<?=$row['id']?>" /><input type="hidden" name="do" value="1" /><input type="submit" class="sub" name="sub" value="退 款 " /></td>
  </tr>
  <?php }elseif($row['checked']==1){?>
  <tr>
    <td align="right">会员：</td>
    <td>&nbsp;<input type="text" name="uname" value="<?=$duoduo->select('user','ddusername','id="'.$row['uid'].'"')?>" /> 会员ID：<?=$row['uid']?></td>
  </tr>
  <tr>
    <td align="right">订单截图：</td>
    <td>&nbsp;<img src="../<?=$row['ddjt']?>"/></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="id" value="<?=$row['id']?>" /><input type="hidden" name="do" value="2" /><input type="submit" class="sub" name="sub" value=" 确 认 " /></td>
  </tr>
  <?php }elseif($row['checked']==0){?>
  <tr>
    <td align="right">会员：</td>
    <td>&nbsp;<input type="text" name="uname" value="" /> 会员ID：<?=$row['uid']?></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="id" value="<?=$row['id']?>" /><input type="hidden" name="do" value="2" /><input type="submit" class="sub" name="sub" value=" 确 认 " /></td>
  </tr>
  <?php }elseif($row['checked']==-1){?>
  <tr>
    <td align="right">会员：</td>
    <td>&nbsp;<?=$duoduo->select('user','ddusername','id="'.$row['uid'].'"')?> 会员ID：<?=$row['uid']?></td>
  </tr>
  <?php }?>
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>