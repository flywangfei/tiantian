<?php include(ADMINTPL.'/header.tpl.php');?>
<script>
function checkNode(t){
	classname=$(t).attr('id');
    if($(t).attr('checked')==true){
		$('.'+classname).attr('checked',true);
	}
	else{
		$('.'+classname).attr('checked',false);
	}
}

$(function(){
    $('.children input').click(function(){
		var node=$(this).attr('node');
		if($(this).attr('checked')==true){  
		    $('#'+node).attr('checked',true);
		}
		else{
		    var classname=$(this).attr('class');
			var ok=1;
			$('.'+classname).each(function(){
			    if($(this).attr('checked')==true){
				    ok=1;
					return false;
				}
				else{
				    ok=0;
				}
			});
			if(ok==0){
			    $('#'+node).attr('checked',false);
			}
		}
	});
})
</script>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115px" align="right">名称：</td>
    <td>&nbsp;<input name="title" type="text" id="title" value="<?=$row['title']?>"/><input type="hidden" name="id" value="<?=$row['id']?>" /></td>
  </tr>
  <tr>
    <td align="right">菜单：</td>
    <td style="padding-left:5px">
    <?php foreach($menus as $key=>$row){?>
    <div><label><input type="checkbox"  id="<?=$row['node']?>" name="ids[]" <?php if($role_menu_arr[$key]){?> checked="checked"<?php }?> value="<?=$key?>" onclick='javascript:checkNode($(this));'/>&nbsp;<span style="font-size:12px;font-family:wingdings">1</span>&nbsp;<?=$row['title']?></label></div>
    <?php foreach($row['children'] as $k=>$v){?>
    <div style="line-height:28px"><label class="children">└─<input node="<?=$row['node']?>" class="<?=$row['node']?>" <?php if($role_menu_arr[$v['id']]){?> checked="checked"<?php }?> type="checkbox" name="ids[]" value="<?=$v['id']?>" />&nbsp;<span style="font-size:12px;font-family:wingdings">2</span>&nbsp;<?=$v['title']?>(模块：<?=$v['mod']?> 行为：<?=$v['act']?>)</label></div>
    <?php }?>
	<?php }?>
    </td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="submit" class="sub" name="sub" value=" 保 存 " /></td>
  </tr>
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>