<?php include(ADMINTPL.'/header.tpl.php');$act_arr=array('list','addedi','del','set');?>
<script>
$(function(){
    $('#node_id').change(function(){
	    var node = $(this).val();
		$('#node').val(node);
	});
	$('#mod_id').change(function(){
	    var node = $(this).find("option:selected").text();
		$('#mod').val(node);
	});
	$('#act_id').change(function(){
	    var node = $(this).find("option:selected").text();
		$('#act').val(node);
	});
})
</script>
<div class="explain-col">
  说明，如要添加新节点，模块和行为两项为空即可。
</div>
<br />
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable"  align="center" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115px" align="right">名称：</td>
    <td>&nbsp;<input name="title" type="text" id="title" value="<?=$row['title']?>"/></td>
  </tr>
  <tr>
    <td align="right">节点：</td>
    <td>&nbsp;<input name="node" type="text" id="node" value="<?=$row['node']?$row['node']:'base'?>"/>&nbsp;<?=select($node_arr,$row['node'],'node_id')?> 默认节点，可自行添加</td>
  </tr>
  <tr>
    <td align="right">模块：</td>
    <td>&nbsp;<input name="mod" type="text" id="mod" value="<?=$row['mod']?>"/>&nbsp;<?=select($mod_arr,$row['mod'],'mod_id')?> 默认节点，可自行添加</td>
  </tr>
  <tr>
    <td align="right">行为：</td>
    <td>&nbsp;<input name="act" type="text" id="act" value="<?=$row['act']?>"/>&nbsp;<?=select($act_arr,'','act_id')?> 常用行为，可自行添加</td>
  </tr>
  <tr>
    <td align="right">状态：</td>
    <td>&nbsp;<?=html_radio($hide_arr,$row['hide'],'hide')?></td>
  </tr>
  <tr>
    <td align="right">排序：</td>
    <td>&nbsp;<input name="sort" type="text" id="sort" value="<?=$row['sort']?$row['sort']:$row['listorder']?>" /> 数字越大越靠前</td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="id" value="<?=$row['id']?>" /><input type="submit" class="sub" name="sub" value=" 保 存 " /></td>
  </tr>
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>