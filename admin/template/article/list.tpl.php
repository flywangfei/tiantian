<?php include(ADMINTPL.'/header.tpl.php');?>
<script>
function getIds(){
	if($('#cidselect').val()==0){
		alert('没有选择栏目');
		return false;
	}
	var ids='';
	$('input[name=ids[]]').each(function(){
		if($(this).attr('checked')==true){
			ids=ids+$(this).attr('id')+',';
		}
	});
	if(ids==''){
		alert('没有选择文章');
		return false;
	}
	$('#ids').val(ids);
}
</script>
<form name="form1" action="" method="get">
<table cellspacing="0" width="100%" style="border:1px  solid #DCEAF7; border-bottom:0px; background:#E9F2FB;">
        <tr>
              <td width="150px">&nbsp;<img src="images/arrow.gif" width="16" height="22" align="absmiddle" />&nbsp;<a href="<?=u(MOD,'addedi')?>" class="link3">[新增文章]</a> </td>
              <td width="" align="right">标题：<input type="text" name="q" value="<?=$q?>" />&nbsp;<select name="cid" style="font-size:12px"><option value="0">--顶层栏目--</option><?php getCategorySelect($cid);?></select>&nbsp;<input type="submit" value="提交" /></td>
              <td width="150px" align="right">共有 <b><?php echo $total;?></b> 条记录&nbsp;&nbsp;</td>
            </tr>
      </table>
      <input type="hidden" name="mod" value="<?=MOD?>" />
      <input type="hidden" name="act" value="<?=ACT?>" />
      </form>
      <form name="form2" method="get" action="" style="margin:0px; padding:0px">
                  <table id="listtable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
                    <tr>
                      <th width="3%"><input type="checkbox" onClick="checkAll(this,'ids[]')" /></th>
					  <th width="">标题</th>
                      <th width="6%">缩略图</th>
                      <th width="115px">栏目</th>
                      <th width="10%">来源</th>
                      <th width="5%">点击</th>
                      <th width="5%">排序</th>
                      <th width="8%">操作</th>
                    </tr>
					<?php foreach ($row as $r){?>
					  <tr>
                        <td><input type='checkbox' name='ids[]' value='<?=$r["id"]?>' id='<?=$r["id"]?>' /></td>
                        <td style="text-align:left; padding-left:5px"><?=$r["title"]?></td>
                        <td <?php if($r["img"]!=''){echo 'class="showpic"';}?> pic="<?=$r["img"]?>"><?=$r["img"]?'查看':'无'?></td>
						<td><?=$this_type[$r["cid"]]?></td>
                        <td><?=$r["source"]?></td>
                        <td><?=$r["hits"]?></td>
						<td><?=$r["sort"]?></td>
						<td><a href="<?=u(MOD,'addedi',array('id'=>$r['id']))?>">修改</a></td>
					  </tr>
					<?php }?>
                  </table>
				<div style="position:relative; padding-bottom:10px">
            <input type="hidden" name="mod" value="<?=MOD?>" /><input type="hidden" name="act" value="del" />
            <div style="position:absolute; left:5px; top:5px"><input type="submit" value="删除" class="myself" onclick='return confirm("确定要删除?")'/></div>
            <div class="megas512" style=" margin-top:15px;"><?=pageft($total,$pagesize,u(MOD,'list',array('q'=>$q,'cid'=>$cid)));?></div>
            </div>
       </form>
       <div style="padding-left:10px"><form onsubmit="return getIds();" action="index.php?mod=<?=MOD?>&act=removecid" method="post">批量移动：<select id="cidselect" name="cid" style="font-size:12px"><option value="0">--顶层栏目--</option><?php getCategorySelect($cid);?></select> <input type="hidden" name="ids" id="ids" value="" /><input name="sub" type="submit" value="提交" /></form></div>
<?php include(ADMINTPL.'/footer.tpl.php');?>