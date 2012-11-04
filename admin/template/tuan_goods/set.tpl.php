<?php 
include(ADMINTPL.'/header.tpl.php');
$mall_type=$duoduo_type['mall'];
?>
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
  <tr>
    <td width="115px" align="right">团购模块：</td>
    <td>&nbsp;<label><input <?php if($webset['tuan']['open']==1){?> checked="checked"<?php }?> name="tuan[open]" type="radio" value="1"/> 开启</label>&nbsp;<label><input <?php if($webset['tuan']['open']==0){?> checked="checked"<?php }?> name="tuan[open]" type="radio" value="0"/> 关闭</label></td>
  </tr>
  <tr>
    <td align="right">默认分类：</td>
    <td>&nbsp;<?=select($duoduo->select_2_field('tuan_type'),$webset['tuan']['cid'],'tuan[cid]')?> 如果商品不符合现有分类，将自动归于此类</td>
  </tr>
  <tr>
    <td align="right">采集间隔：</td>
    <td>&nbsp;<select name="tuan[autoget]">
                        <?php for($i=1;$i<=24;$i++){?>
                        <option value="<?=$i?>" <?php if($i==$webset['tuan']['autoget']){?> selected="selected"<?php }?>><?=$i?></option>
                        <?php }?>
                        </select> 自动采集的间隔时间，单位小时</td>
  </tr>
  <tr>
    <td align="right">删除过期数据：</td>
    <td>&nbsp;<label><input value="1" type="radio" name="tuan[autogdel]" <?php if($webset['tuan']['autogdel']==1){?> checked="checked"<?php }?> />是</label>&nbsp;&nbsp;
              <label><input value="0" type="radio" name="tuan[autogdel]" <?php if($webset['tuan']['autogdel']==0){?> checked="checked"<?php }?> />否</label> 自动删除过期团购商品</td>
  </tr>
  <tr>
    <td align="right">首页个数：</td>
    <td>&nbsp;<input name="tuan[shownum]" type="text" id="shownum" value="<?=$webset['tuan']['shownum']?>" /> 首页每个栏目显示的商品个数，根据模板，3的倍数</td>
  </tr>
  <tr>
    <td align="right">列表页个数：</td>
    <td>&nbsp;<input name="tuan[listnum]" type="text" id="listnum" value="<?=$webset['tuan']['listnum']?>" /> 列表页显示的商品个数，根据模板，3的倍数</td>
  </tr>
  <tr>
    <td align="right">团购类别：</td>
    <td>&nbsp;<?=select($mall_type,$webset['tuan']['mall_cid'],'tuan[mall_cid]')?> 商城类别中团购的分类的id</td>
  </tr>
  <tr>
     <td align="right">&nbsp;</td>
     <td>&nbsp;<input type="submit" name="sub" value=" 保 存 设 置 " /></td>
  </tr>
  </form>
</table>

<?php include(ADMINTPL.'/footer.tpl.php');?>