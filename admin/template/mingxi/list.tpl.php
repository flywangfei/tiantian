<?php include(ADMINTPL.'/header.tpl.php');?>
<form name="form1" action="" method="get">
<table cellspacing="0" width="100%" style="border:1px  solid #DCEAF7; border-bottom:0px; background:#E9F2FB;">
        <tr>
              <td width="150px">&nbsp;<img src="images/arrow.gif" width="16" height="22" align="absmiddle" /> </td>
              <td width="" align="right">会员名：<input type="text" name="uname" value="<?=$uname?>" />&nbsp;<input type="submit" value="提交" /></td>
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
                      <th width="8%">会员</th>
					  <th width="8%">事件</th>
                      <th width="">说明</th>
                      <th width="5%">金额</th>
                      <th width="5%">积分</th>
                      <th width="140px">时间</th>
                      <th width="8%">剩余金额</th>
                    </tr>
					<?php foreach ($row as $r){?>
					  <tr>
                        <td><input type='checkbox' name='ids[]' value='<?=$r["id"]?>' id='content_<?=$r["id"]?>' /></td>
                        <td><a href="<?=u('mingxi','list',array('uname'=>$r["ddusername"]))?>" title="查看明细" style=" text-decoration:underline"><?=$r["ddusername"]?></a></td>
                        <td><?=$mingxi_tpl[$r["shijian"]]['title']?></td>
						<td style="text-align:left; padding-left:5px"><?=mingxi_content($r,$mingxi_tpl[$r["shijian"]]['content'])?></td>
                        <td><?=$r["money"]?></td>
                        <td><?=$r["jifen"]?></td>
						<td><?=$r["addtime"]?></td>
                        <td><?=$r["leave_money"]?></td>
					  </tr>
					<?php }?>
                  </table>
				<div style="position:relative; padding-bottom:10px">
            <input type="hidden" name="mod" value="<?=MOD?>" /><input type="hidden" name="act" value="del" />
            <div style="position:absolute; left:5px; top:5px"><input type="submit" value="删除" onclick='return confirm("确定要删除?")'/></div>
            <div class="megas512" style=" margin-top:15px;"><?=pageft($total,$pagesize,u(MOD,'list',array('uname'=>$uname)));?></div>
            </div>
       </form>
<?php include(ADMINTPL.'/footer.tpl.php');?>