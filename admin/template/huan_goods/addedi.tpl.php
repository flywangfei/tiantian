<?php include(ADMINTPL.'/header.tpl.php');?>
<style>
#array{ width:500px}
</style>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115px" align="right">标题：</td>
    <td>&nbsp;<input name="title" type="text" id="title" value="<?=$row['title']?$row['title']:$relate_row['title']?>" style="width:300px" /></td>
  </tr>
  <tr>
    <td align="right">类别：</td>
    <td>&nbsp;<select name="cid"><?php getCategorySelect($row['cid']?$row['cid']:$_GET['cid']);?></select></td>
  </tr>
  <tr>
    <td align="right">图片：</td>
    <td>&nbsp;<input name="img" type="text" id="img" value="<?=$row['img']?$row['img']:$relate_row['img']?>" style="width:300px" /> <input class="sub" type="button" value="上传图片" onclick="javascript:openpic('<?=u('fun','upload',array('uploadtext'=>'img','sid'=>session_id()))?>','upload','450','350')" /> 可直接添加网络地址</td>
  </tr>
  <tr>
    <td align="right">金额：</td>
    <td>&nbsp;<input name="money" type="text" id="money" value="<?=$row['money']?>" /> 设为0此项不参与兑换</td>
  </tr>
  <tr>
    <td align="right">积分：</td>
    <td>&nbsp;<input name="jifen" type="text" id="jifen" value="<?=$row['jifen']?>" /> 设为0此项不参与兑换</td>
  </tr>
  <tr>
    <td align="right">数量：</td>
    <td>&nbsp;<input name="num" type="text" id="num" value="<?=$row['num']?>" /></td>
  </tr>
  <tr>
    <td align="right">开始时间：</td>
    <td>&nbsp;<input class="timeinput" name="sdate" type="text" id="sdate" value="<?=$row['sdate']?$row['sdate']:$relate_row['sdate']?>" /></td>
  </tr>
  <tr>
    <td align="right">结束时间：</td>
    <td>&nbsp;<input class="timeinput" name="edate" type="text" id="edate" value="<?=$row['edate']?$row['edate']:$relate_row['edate']?>" /></td>
  </tr>
  <tr>
    <td align="right">显示/隐藏：</td>
    <td>&nbsp;<?=html_radio($status,$row['hide'],'hide')?></td>
  </tr>
  <tr>
    <td align="right">排序：</td>
    <td>&nbsp;<input name="sort" type="text" id="sort" value="<?=$row['sort']?$row['sort']:0?>"  /> 数字越大越靠前</td>
  </tr>
  <tr>
    <td align="right">领取代码：</td>
    <td><table border="0">
  <tr>
    <td><textarea style="width:400px; height:150px" name="array"><?=$row['array']?></textarea></td>
    <td>&nbsp; 填写后会员兑换申请以站内信形式获得代码，多个代码可用空格，回车或者逗号隔开。</td>
  </tr>
</table>
</td>
  </tr>
  <tr>
    <td align="right">自动发货：</td>
    <td>&nbsp;<?=html_radio(array(0=>'否',1=>'是'),$row['auto'],'auto')?> 适用于领取代码模式，会员兑换后自动发送站内信</td>
  </tr>
  <tr>
    <td align="right">兑换限制：</td>
    <td>&nbsp;<input name="limit" type="text" id="limit" value="<?=$row['limit']?$row['limit']:0?>"  /> 每个会员每天最多兑换此商品的个数，0表示不限制</td>
  </tr>
  <tr>
    <td align="right">介绍：</td>
    <td>&nbsp;<textarea id="content" name="content"><?=$row['content']?$row['content']:$relate_row['content']?></textarea></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="id" value="<?=$row['id']?>" /><input type="hidden" name="relateid" value="<?=$_GET['relateid']?>" /><input type="submit" class="sub" name="sub" value=" 保 存 " /></td>
  </tr>
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>