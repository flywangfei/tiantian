<?php include(ADMINTPL.'/header.tpl.php');?>
<form name="form1" action="" method="get">
<table cellspacing="0" width="100%" style="border:1px  solid #DCEAF7; border-bottom:0px; background:#E9F2FB;">
        <tr>
              <td width="150px">&nbsp;<img src="images/arrow.gif" width="16" height="22" align="absmiddle" />&nbsp;<a href="<?=u(MOD,'addedi')?>" class="link3">[新增第三方登陆]</a> </td>
              <td width="75%" align="right">名称：<input type="text" name="q" value="<?=$q?>" />&nbsp;<input type="submit" value="提交" /></td>
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
					  <th width="">名称</th>
                      <th width="25%">key</th>
                      <th width="25%">secret</th>
                      <th width="6%">标示代码</th>
                      <th width="6%">状态</th>
                      <th width="5%">排序</th>
                      <th width="8%">操作</th>
                    </tr>
					<?php foreach ($row as $r){?>
					  <tr>
                        <td><input <?php if($r['sys']==1){?>title="系统数据，不准删除"  disabled="disabled"<?php }?> type='checkbox' name='ids[]' value='<?=$r["id"]?>' id='content_<?=$r["id"]?>' /></td>
                        <td><?=$r["title"]?></td>
                        <td><?=$r["key"]?></td>
						<td><?=$r["secret"]?></td>
                        <td><?=$r["code"]?></td>
                        <td><?=$open_arr[$r["open"]]?></td>
						<td><?=$r["sort"]?></td>
						<td><a href="<?=u(MOD,'addedi',array('id'=>$r['id']))?>">修改</a></td>
					  </tr>
					<?php }?>
                  </table>
				<div style="position:relative; padding-bottom:10px">
            <input type="hidden" name="mod" value="<?=MOD?>" /><input type="hidden" name="act" value="del" />
            <div style="position:absolute; left:5px; top:5px"><input type="submit" value="删除" class="myself" onclick='return confirm("确定要删除?")'/></div>
            <div class="megas512" style=" margin-top:15px;"><?=pageft($total,$pagesize,u(MOD,'list',array('q'=>$q)));?></div>
            </div>
       </form>
<?php include(ADMINTPL.'/footer.tpl.php');?>