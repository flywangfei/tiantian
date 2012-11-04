<?php include(ADMINTPL.'/header.tpl.php');?>
<form name="form1" action="" method="get">
<table cellspacing="0" width="100%" style="border:1px  solid #DCEAF7; border-bottom:0px; background:#E9F2FB;">
        <tr>
              <td width="300px">&nbsp;<img src="images/arrow.gif" width="16" height="22" align="absmiddle" />&nbsp;<a href="<?=u(MOD,'addedi')?>" class="link3">[新增站内信模板]（供二次开发专用）</a> </td>
              <td width="" align="right">标题：<input type="text" name="q" value="<?=$q?>" />&nbsp;<input type="submit" value="提交" /></td>
              <td width="150px" align="right">共有 <b><?php echo $total;?></b> 条记录&nbsp;&nbsp;</td>
            </tr>
      </table>
      <input type="hidden" name="mod" value="<?=MOD?>" />
      <input type="hidden" name="act" value="<?=ACT?>" />
      </form>
                  <table id="listtable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
                    <tr>
                      <th width="5%">id</th>
					  <th width="25%">标题</th>
                      <th width="">发送对象</th>
                      <th width="12%">操作</th>
                    </tr>
					<?php foreach ($row as $r){?>
					  <tr>
                        <td><?=$r["id"]?></td>
                        <td><?=$r["title"]?></td>
						<td><input type="checkbox" <?php if($r['web']!=''){?> checked="checked"<?php }?> disabled="disabled" /> 站内信<input type="checkbox" <?php if($r['email']!=''){?> checked="checked"<?php }?> disabled="disabled" /> 邮件<!--<input type="checkbox" <?php if($r['sms']!=''){?> checked="checked" <?php }?> disabled="disabled" /> 短信--></td>
						<td><a href="<?=u(MOD,'addedi',array('id'=>$r['id']))?>" class=link4>修改</a></td>
					  </tr>
					<?php }?>
                  </table>
				<div style="position:relative; padding-bottom:10px">
            <div class="megas512" style=" margin-top:15px;"><?=pageft($total,$pagesize,u(MOD,'list',array('q'=>$q)));?></div>
            </div>
<?php include(ADMINTPL.'/footer.tpl.php');?>