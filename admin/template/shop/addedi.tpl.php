<?php include(ADMINTPL.'/header.tpl.php');?>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <?php if($id>0){?>
  <tr>
    <td width="115px" align="right">掌柜名：</td>
    <td>&nbsp;<?=$row['nick']?></td>
  </tr>
  <tr>
    <td align="right">店铺名：</td>
    <td>&nbsp;<?=$row['title']?></td>
  </tr>
  <tr>
    <td align="right">logo：</td>
    <?php if(strpos($row['pic_path'],'images/')!==false){?>
    <td>&nbsp;<img src="../<?=$row['pic_path']?>" /></td>
    <?php }else{?>
    <td>&nbsp;<img src="<?=TAOLOGO?><?=$row['pic_path']?>" /></td>
    <?php }?>
  </tr>
  <tr>
    <td align="right">类别：</td>
    <td>&nbsp;<?=select($shop_type,$row['cid'],'cid')?></td>
  </tr>
  <tr>
    <td align="right">等级：</td>
    <td>&nbsp;<img src="../images/level_<?=$row["level"]?>.gif" /></td>
  </tr>
  <tr>
    <td align="right">商品数量：</td>
    <td>&nbsp;<?=$row['total_auction']?></td>
  </tr>
  <tr>
    <td align="right">推广量：</td>
    <td>&nbsp;<?=$row['auction_count']?></td>
  </tr>
  <tr>
    <td align="right">创店时间：</td>
    <td>&nbsp;<?=$row['created']?></td>
  </tr>
  <tr>
    <td align="right">宝贝与描述相符：</td>
    <td>&nbsp;<?=$row['item_score']?></td>
  </tr>
  <tr>
    <td align="right">卖家的服务态度：</td>
    <td>&nbsp;<?=$row['service_score']?></td>
  </tr>
  <tr>
    <td align="right">卖家发货的速度：</td>
    <td>&nbsp;<?=$row['delivery_score']?></td>
  </tr>
  <tr>
    <td align="right">返利：</td>
    <td>&nbsp;<?=$row['fanxianlv']?>%</td>
  </tr>
  <tr>
    <td align="right">推广链接：</td>
    <td>&nbsp;<input type="text" name="shop_click_url" style="width:600px" value="<?=$row['shop_click_url']?>" /></td>
  </tr>
  <tr>
    <td align="right">点击：</td>
    <td>&nbsp;<input type="text" name="hits" value="<?=$row['hits']?>" /></td>
  </tr>
  <tr>
    <td align="right">排序：</td>
    <td>&nbsp;<input type="text" name="sort" value="<?=$row['sort']?>" /> 数字越大越靠前，优先级高于推荐</td>
  </tr>
  <tr>
    <td align="right">推荐位：</td>
    <td>&nbsp;<label><input <?php if($row['index_top']==1){?> checked="checked"<?php }?> type="checkbox" value="1" name="index_top" />网站首页</label> <label><input <?php if($row['tao_top']==1){?> checked="checked"<?php }?> type="checkbox" value="1" name="tao_top" />淘宝首页</label></td>
  </tr>
  <?php }else{?>
  <tr>
    <td width="115px" align="right">掌柜昵称：</td>
    <td>&nbsp;<input type="text" name="nick" value="" /></td>
  </tr>
  <?php }?>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="id" value="<?=$row['id']?>" /><input type="submit" class="sub" name="sub" value=" 确 认 " /></td>
  </tr>
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>