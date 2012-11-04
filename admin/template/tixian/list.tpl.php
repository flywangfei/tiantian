<?php include(ADMINTPL.'/header.tpl.php');?>
<form action="" method="get">
<table cellspacing="0" width="100%" style="border:1px  solid #DCEAF7; border-bottom:0px; background:#E9F2FB">
        <tr>
              <td width="200px">&nbsp;<img src="images/arrow.gif" width="16" height="22" align="absmiddle" />&nbsp;<a href="<?=u(MOD,ACT,array('first'=>1))?>" class="link3">[首次提现]</a> 总金额：<?=$sum?> 元</td>
              <td width="" align="right"><?=select($select_arr,$se1,'se')?>：<input type="text" name="q" value="<?=$q?>" />&nbsp;<?=select($status_arr,$status,'status')?>&nbsp;<input type="submit" value="提交" /></td>
              <td width="20%" align="right">共有 <b><?php echo $total;?></b> 条记录&nbsp;&nbsp;</td>
            </tr>
      </table>
      <input type="hidden" name="mod" value="<?=MOD?>" />
      <input type="hidden" name="act" value="<?=ACT?>" />
      </form>
      <form name="form2" method="get" action="" style="margin:0px; padding:0px">
      <table id="listtable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
                    <tr>
                      <th width="3%"><input type="checkbox" onClick="checkAll(this,'ids[]')" /></th>
                      <th width="8%">用户名</th>
                      <th width="">支付宝</th>
                      <th width="6%">金额</th>
                      <th width="150px">时间</th>
                      <th width="140px">ip</th>
                      <th width="9%">真实姓名</th>
                      <th width="9%">手机</th>
                      <th width="115px">状态</th>
                      <th width="115px">操作</th>
                    </tr>
					<?php foreach ($row as $r){?>
					  <tr>
                        <td><input type='checkbox' name='ids[]' value='<?=$r["id"]?>' id='content_<?=$r["id"]?>' /></td>
                        <td><a href="<?=u('mingxi','list',array('uname'=>$r["ddusername"]))?>" title="查看明细" style="text-decoration:underline"><?=$r["ddusername"]?></a></td>
						<td class=b><?=$r["alipay"]?></td>
                        <td class=a><?=$r["money"]?></td>
                        <td><?=date('Y-m-d H:i:s',$r["addtime"])?></td>
						<td><?=$r["ip"]?></td>
                        <td class=c><?=$r["realname"]?></td>
                        <td class=d><?=$r["mobile"]?></td>
                        <td class=e><?=$status_arr[$r["status"]]?></td>
						<td><a href="<?=u(MOD,'addedi',array('id'=>$r['id'],'do'=>'yes'))?>">确认</a>&nbsp;<a href="<?=u(MOD,'addedi',array('id'=>$r['id'],'do'=>'no'))?>">退回</a></td>
					  </tr>
					<?php }?>
		</table>
        <div style="position:relative; padding-bottom:10px">
            <input type="hidden" name="mod" value="<?=MOD?>" /><input type="hidden" id="act" name="act" value="del" />
            <div style="position:absolute; left:5px; top:5px"><input type="submit" value="删除" onclick='return confirm("确定要删除?")'/> <input type="submit" value="批量确认提现" onclick='$("#act").val("list");return confirm("确定要批量提现?")'/></div>
            <div class="megas512" style=" margin-top:15px;"><?=pageft($total,$pagesize,u(MOD,'list',$page_arr));?></div>
            </div>
       </form>
<?php include(ADMINTPL.'/footer.tpl.php');?>