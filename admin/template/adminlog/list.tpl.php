<?php include(ADMINTPL.'/header.tpl.php');?>
<table cellspacing="0" width="100%" style="border:1px  solid #DCEAF7; border-bottom:0px; background:#E9F2FB;">
        <tr>
        <form name="form1" action="" method="get">
              <td width="300px">&nbsp;<img src="images/arrow.gif" width="16" height="22" align="absmiddle" />&nbsp;日期：<input style="width:70px" type="text" id="sday" name="sday" /> - <input style="width:70px" type="text" id="eday" name="eday" />&nbsp;<input type="submit" name="sub" value="删除" /></td>
              <input type="hidden" name="mod" value="<?=MOD?>" />
              <input type="hidden" name="act" value="del" />
              </form>
              <form name="form1" action="" method="get">
              <td width="" align="right"><?=select($se_arr,$se,'se')?>：<input type="text" name="q" value="<?=$q?>" />&nbsp;<input type="submit" value="提交" /></td>
              <td width="150px" align="right" class="bigtext">共有 <b><?php echo $total;?></b> 条记录&nbsp;&nbsp;</td>
               <input type="hidden" name="mod" value="<?=MOD?>" />
      <input type="hidden" name="act" value="<?=ACT?>" />
      </form>
            </tr>
      </table>
     
      <form name="form2" method="get" action="" style="margin:0px; padding:0px">
                  <table id="listtable" border=1 cellpadding=0 cellspacing=0  bordercolor="#dddddd">
                    <tr>
                      <th width="3%"  ><input type="checkbox" onClick="checkAll(this,'ids[]')" /></th>
					  <th width="">管理员</th>
                      <th width="20%">操作IP</th>
                      <th width="20%">模块</th>
                      <th width="115px">操作</th>
                      <th width="20%">执行时间</th>
                    </tr>
					<?php foreach ($row as $r){?>
					  <tr>
                        <td><input type='checkbox' name='ids[]' value='<?=$r["id"]?>' id='content_<?=$r["id"]?>' /></td>
                        <td><?=$r["admin_name"]?></td>
						<td><?=$r["ip"]?></td>
                        <td><?=$r["mod"]?></td>
                        <td><?=$r["do"]?></td>
						<td><?=date('Y-m-d H:i:s',$r["addtime"])?></td>
					  </tr>
					<?php }?>
                  </table>
				<div style="position:relative; padding-bottom:10px">
            <input type="hidden" name="mod" value="<?=MOD?>" /><input type="hidden" name="act" value="del" />
            <div style="position:absolute; left:5px; top:5px"><input type="submit" value="删除" class="myself" onclick='return confirm("确定要删除?")'/></div>
            <div class="megas512" style=" margin-top:15px;"><?=pageft($total,$pagesize,u(MOD,'list'));?></div>
            </div>
       </form>
<?php include(ADMINTPL.'/footer.tpl.php');?>