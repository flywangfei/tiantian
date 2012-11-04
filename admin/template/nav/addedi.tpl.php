<?php include(ADMINTPL.'/header.tpl.php');?>
<script>
navArr=new Array();
<?php foreach($nav_tag as $k=>$v){?>
navArr[<?=$k?>]='<?=$v?>';
<?php }?>
$(function(){
	$('#pid').change(function(){
		$('#tag').val(navArr[$(this).val()]);
	});
	
	$('#sm').jumpBox({  
		height:400,
		width:600,
		contain:$('#mydiv').html()
    });	
})
</script>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115px" align="right">名称：</td>
    <td>&nbsp;<input name="title" type="text" id="title" value="<?=$row['title']?>" /></td>
  </tr>
  <tr>
    <td align="right">模块：</td>
    <td>&nbsp;<input name="mod" type="text" id="mod" value="<?=$row['mod']?>"/></td>
  </tr>
  <tr>
    <td align="right">行为：</td>
    <td>&nbsp;<input name="act" type="text" id="act" value="<?=$row['act']?>" /></td>
  </tr>
  <tr>
    <td align="right">导航标记：</td>
    <td>&nbsp;<input name="tag" type="text" id="tag" value="<?=$row['tag']?>"/> <a style="color:#FF6600; cursor:pointer; text-decoration:underline" id="sm" >设置向导</a> 用于模板导航关联</td>
  </tr>
  <tr>
    <td align="right">目标：</td>
    <td>&nbsp;<?=html_radio($target,$row['target'],'target')?></td>
  </tr>
  <tr>
    <td align="right">是否隐藏：</td>
    <td>&nbsp;<?=html_radio($status,$row['hide'],'hide')?></td>
  </tr>
  <tr>
    <td align="right">状态：</td>
    <td>&nbsp;<?=html_radio($type,$row['type'],'type')?></td>
  </tr>
  <tr>
    <td align="right">自定义连接：</td>
    <td>&nbsp;<input name="url" type="text" id="url" value="<?=$row['url']?>" style="width:300px" /> 以http://开头，添加绝对地址</td>
  </tr>
  <tr>
    <td align="right">是否提示登陆：</td>
    <td>&nbsp;<?=html_radio(array(0=>'否',1=>'是'),$row['tip'],'tip')?></td>
  </tr>
  <tr>
    <td align="right">自定义字符：</td>
    <td>&nbsp;<input name="custom" type="text" id="custom" value="<?=$row['custom']?>" style="width:300px" /> 自定义代码，二次开发模板用</td>
  </tr>
  <tr>
    <td align="right">父导航：</td>
    <td>&nbsp;<?=select($nav_arr,$row['pid'],'pid')?> 选择父标签后，导航标记要与父导航标记相同</td>
  </tr>
  <tr>
    <td align="right">短说明：</td>
    <td>&nbsp;<input name="alt" type="text" id="alt" value="<?=$row['alt']?>" /> 只适用于子导航</td>
  </tr>
  <tr>
    <td align="right">排序：</td>
    <td>&nbsp;<input name="sort" type="text" id="sort" value="<?=$row['sort']?$row['sort']:0?>" /> 数字越大越靠前</td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="id" value="<?=$row['id']?>" /><input type="submit" class="sub" name="sub" value=" 保 存 " /></td>
  </tr>
</table>
</form>
<div id="mydiv" style="display:none; ">
<div  style="font-size:14px; color:#666666; font-family:'宋体'">
<table width="300" border="1">
  <tr>
    <td>模块/行为</td>
    <td>导航标记</td>
  </tr>
  <tr>
    <td>index/index</td>
    <td>index</td>
  </tr>
  <tr>
    <td>tao/index</td>
    <td>tao</td>
  </tr>
  <tr>
    <td>mall/list</td>
    <td>mall</td>
  </tr>
  <tr>
    <td>mall/goods</td>
    <td>bijia</td>
  </tr>
  <tr>
    <td>huodong/list</td>
    <td>huodong</td>
  </tr>
  <tr>
    <td>huan/list</td>
    <td>huan</td>
  </tr>
  <tr>
    <td>tao/zhe</td>
    <td>zhekou</td>
  </tr>
  <tr>
    <td>baobei/list</td>
    <td>baobei</td>
  </tr>
  <tr>
    <td>tuan/list</td>
    <td>tuan</td>
  </tr>
  <tr>
    <td>shop/list</td>
    <td>shop</td>
  </tr>
  <tr>
    <td>tao/list</td>
    <td>tao</td>
  </tr>
  <tr>
    <td>help/index</td>
    <td>help</td>
  </tr>
  <tr>
    <td>article/index</td>
    <td>article</td>
  </tr>
  <tr>
    <td>paipai/index</td>
    <td>paipai</td>
  </tr>
  <tr>
    <td>paipai/list</td>
    <td>paipai</td>
  </tr>
</table>

</div>
</div>
<?php include(ADMINTPL.'/footer.tpl.php');?>