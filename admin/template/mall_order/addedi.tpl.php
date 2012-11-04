<?php 
include(ADMINTPL.'/header.tpl.php');
$user=$duoduo->select('user','ddusername,level','id="'.$row['uid'].'"')
?>
<script>
function fenduan(val){
	level=<?=$user['level']?>;
	<?php
	foreach($webset['mallfxbl'] as $k=>$v){
		$webset['mallfxbl'][$k.'a']=$v;
		unset($webset['mallfxbl'][$k]);
	}
	?>
	<?=php2js_object($webset['mallfxbl'],'arr');?>
	var re=0;
    for(var k in arr){
    	k=parseInt(k);
        if(level>=k){
        	re=val*arr[k+'a'];
            re=re*100;
  			re=re.toFixed(1);
  			re=Math.round(re)/100; //本来直接用toFixed函数就可以，但是火狐浏览器不行
            break;
		}
    }
    if(re==0){
    	re=val*arr[k];
    	re=re.toFixed(2);
    }
    return re;
}

function fxjeJifen(commission){
	var fxje=fenduan(commission);
	$('#fxje').val(fxje);
	var jifen=fxje*<?=$webset['jifenbl']?>;
	jifen=jifen*100;
  	jifen=jifen.toFixed(1);
  	jifen=Math.round(jifen)/100;
	$('#jifen').val(jifen);
}
</script>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
<?php if($id>0){?>
  <tr>
    <td width="115px" align="right">商城：</td>
    <td>&nbsp;<?=$row['mall_name']?></td>
  </tr>
  <tr>
    <td align="right">联盟：</td>
    <td>&nbsp;<?=$lm_arr[$row['lm']]?></td>
  </tr>
  <tr>
    <td align="right">下单时间：</td>
    <td>&nbsp;<?=date('Y-m-d H:i:s',$row['order_time'])?></td>
  </tr>
  <tr>
    <td align="right">订单号：</td>
    <td>&nbsp;<?=$row['order_code']?></td>
  </tr>
  <tr>
    <td align="right">商品编号：</td>
    <td>&nbsp;<?=$row['product_code']?></td>
  </tr>
  <tr>
    <td align="right">数量：</td>
    <td>&nbsp;<?=$row['item_count']?></td>
  </tr>
  <tr>
    <td align="right">单价：</td>
    <td>&nbsp;<?=$row['item_price']?></td>
  </tr>
  <tr>
    <td align="right">总额：</td>
    <td>&nbsp;<?=$row['sales']?></td>
  </tr>
  <tr>
    <td align="right">佣金：</td>
    <td>&nbsp;<input type="text" id="commission" name="commission" onblur="fxjeJifen($(this).val());" value="<?=$row['commission']?>" /> 填写佣金后系统会自动从新计算返利和积分</td>
  </tr>
  <tr>
    <td align="right">返利：</td>
    <td>&nbsp;<input type="text" id="fxje" name="fxje" value="<?=$row['fxje']?>" /></td>
  </tr>
  <tr>
    <td align="right">积分：</td>
    <td>&nbsp;<input type="text" id="jifen" name="jifen" value="<?=$row['jifen']?>" /></td>
  </tr>
  
  <?php if($row['status']==1 || $row['status']==-1){?>
  <tr>
    <td align="right">状态：</td>
    <td>&nbsp;<?=$status_arr2[$row['status']]?></td>
  </tr>
  <tr>
    <td align="right">会员：</td>
    <td>&nbsp;<?=$user['ddusername']?></td>
  </tr>
  <?php }elseif($row['status']==0){?>
  <tr>
    <td align="right">状态：</td>
    <td>&nbsp;<?=select($status_arr2,$row['status'],'status')?></td>
  </tr>
  <tr>
    <td align="right">会员：</td>
    <td>&nbsp;<input type="text" name="uname" value="<?=$duoduo->select('user','ddusername','id="'.$row['uid'].'"')?>" /></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="id" value="<?=$row['id']?>" /><input type="submit" class="sub" name="sub" value=" 确 认 " /></td>
  </tr>
  <?php }?>
<?php }else{?>
  <tr>
    <td width="115px" align="right">商城：</td>
    <td>&nbsp;<?=select($malls,0,'mall_id')?></td>
  </tr>
  <tr>
    <td align="right">联盟：</td>
    <td>&nbsp;<?=select($lm_arr,0,'lm')?></td>
  </tr>
  <tr>
    <td align="right">下单时间：</td>
    <td>&nbsp;<input type="text" name="order_time" id="sdatetime" /></td>
  </tr>
  <tr>
    <td align="right">订单号：</td>
    <td>&nbsp;<input type="text" name="order_code" /></td>
  </tr>
  <tr>
    <td align="right">商品编号：</td>
    <td>&nbsp;<input type="text" name="product_code" /></td>
  </tr>
  <tr>
    <td align="right">数量：</td>
    <td>&nbsp;<input type="text" name="item_count" /></td>
  </tr>
  <tr>
    <td align="right">单价：</td>
    <td>&nbsp;<input type="text" name="item_price" /></td>
  </tr>
  <tr>
    <td align="right">总额：</td>
    <td>&nbsp;<?=$row['sales']?><input type="text" name="sales" /></td>
  </tr>
  <tr>
    <td align="right">佣金：</td>
    <td>&nbsp;<input type="text" name="commission" /></td>
  </tr>
  <tr>
    <td align="right">状态：</td>
    <td>&nbsp;<?=select($status_arr2,$row['status'],'status')?></td>
  </tr>
  <tr>
    <td align="right">会员：</td>
    <td>&nbsp;<input type="text" name="uname" /></td>
  </tr>
  <tr>
    <td align="right">唯一编号：</td>
    <td>&nbsp;<input type="text" name="unique_id" /> 亿起发专用</td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="id" value="<?=$row['id']?>" /><input type="submit" class="sub" name="sub" value=" 确 认 " /></td>
  </tr>
<?php }?>
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>