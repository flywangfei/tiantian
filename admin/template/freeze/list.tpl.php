<?php include(ADMINTPL.'/header.tpl.php');?>
<form name="form1" action="" method="get" onSubmit="if($('#do').val()=='jiesuan'){return confirm('确定要结算?');}">
<table cellspacing="0" width="100%" style="border:1px  solid #DCEAF7; border-bottom:0px; background:#E9F2FB;">
        <tr>
              <td width="150px">&nbsp;<img src="images/arrow.gif" width="16" height="22" align="absmiddle" /> </td>
              <td width="" align="right" style="position:relative"><div id="hi" style="position:absolute; right:80px; display:none; top:30px; background:#FFF; width:100px; height:20px; line-height:20px; text-align:center">例：201205</div>会员名：<input type="text" name="uname" value="<?=$uname?>" />&nbsp;日期：<input onFocus="$('#hi').show();" style="width:50px;" maxlength="6" type="text" name="date" value="<?=$date?>" />&nbsp;<input type="submit" value="提交" /></td>
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
                      <th width="">会员</th>
                      <th width="150px">金额</th>
                      <th width="150px">积分</th>
                      <th width="20%">月份</th>
                      <th width="8%">操作</th>
                    </tr>
					<?php foreach ($row as $r){?>
					  <tr>
                        <td><input type='checkbox' name='ids[]' value='<?=$r["id"]?>' id='content_<?=$r["id"]?>' /></td>
                        <td><?=$r["ddusername"]?></td>
                        <td><?=$r["money"]?></td>
                        <td><?=$r["jifen"]?></td>
						<td><?=date('Y年m月',strtotime($r["date"].'01'))?></td>
                        <td><a onclick='return confirm("确定要结算?")' href="<?=u('freeze','addedi',array('id'=>$r['id']))?>">结算</a></td>
					  </tr>
					<?php }?>
                  </table>
				<div style="position:relative; padding-bottom:10px">
            <input type="hidden" name="mod" value="<?=MOD?>" /><input type="hidden" id="inputName" name="act" value="del" />
            <div style="position:absolute; left:5px; top:5px"><input type="submit" value="删除" class="myself" onclick='return confirm("确定要删除?")'/> <input type="submit" value="结算" onclick='$("#inputName").val("addedi");return confirm("确定要结算?")'/></div>
            <div class="megas512" style=" margin-top:15px;"><?=pageft($total,$pagesize,u(MOD,'list',array('uname'=>$uname)));?></div>
            </div>
       </form>
<?php include(ADMINTPL.'/footer.tpl.php');?>