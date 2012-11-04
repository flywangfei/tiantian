<?php include(ADMINTPL.'/header.tpl.php');?>
<form action="" method="get">
<table cellspacing="0" width="100%" style="border:1px  solid #DCEAF7; border-bottom:0px; background:#E9F2FB">
        <tr>
              <td width="115px" class="bigtext">&nbsp;<img src="images/arrow.gif" width="16" height="22" align="absmiddle" />&nbsp;<a href="<?=u(MOD,'report')?>" class="link3">[获取订单]</a> </td>
              <td width="" align="right"><input type="text" name="q" value="<?=$q?>" />&nbsp;<?=select($select_arr,$se,'se')?>&nbsp;<?=select($checked_arr,$checked,'checked')?>&nbsp;<input type="submit" value="提交" /></td>
              <td width="125px" align="right" class="bigtext">共有 <b><?php echo $total;?></b> 条记录&nbsp;&nbsp;</td>
            </tr>
      </table>
      <input type="hidden" name="mod" value="<?=MOD?>" />
      <input type="hidden" name="act" value="<?=ACT?>" />
      </form>
      <form name="form2" method="get" action="" style="margin:0px; padding:0px">
      <table id="listtable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
                    <tr>
                      <th width="3%"><input type="checkbox" onClick="checkAll(this,'ids[]')" /></th>
                      <th width="115px">交易号</th>
					  <th width="">商品名称</th>
                      <th width="5%">单价</th>
                      <th width="4%">数量</th>
                      <th width="6%">成交额</th>
                      <th width="4%">佣金</th>
                      <th width="4%">返利</th>
                      <th width="4%">积分</th>
                      <th width="11%">交易时间</th>
                      <th width="6%">状态</th>
                      <th width="7%">会员</th>
                      <th width="5%">操作</th>
                    </tr>
					<?php foreach ($row as $r){?>
					  <tr>
                        <td><input type='checkbox' name='ids[]' value='<?=$r["id"]?>' id='content_<?=$r["id"]?>' /></td>
                        <td><?=$r["trade_id"]?></td>
						<td><?=$r["item_title"]?></td>
                        <td><?=$r["pay_price"]?></td>
                        <td><?=$r["item_num"]?></td>
                        <td><?=$r["real_pay_fee"]?></td>
						<td><?=$r["commission"]?></td>
                        <td><?=$r["fxje"]?></td>
                        <td><?=$r["jifen"]?></td>
                        <td><?=$r["pay_time"]?></td>
                        <td><?=$checked_status[$r["checked"]]?></td>
                        <td><?=$r["uname"]?></td>
						<td><a href="<?=u(MOD,'addedi',array('id'=>$r['id']))?>" class=link4>
                        <?php if($r["checked"]==2){?>
                        退款
                        <?php }elseif($r["checked"]==1){?>
                        审核
                        <?php }elseif($r["checked"]==0){?>
                        返现
                        <?php }elseif($r["checked"]==-1){?>
                        查看
                        <?php }?>
                        </a></td>
					  </tr>
					<?php }?>
		</table>
        <div style="position:relative; padding-bottom:10px">
            <input type="hidden" name="mod" value="<?=MOD?>" /><input type="hidden" name="act" value="del" />
            <div style="position:absolute; left:5px; top:5px"><input type="submit" value="删除" onclick='return confirm("确定要删除?")'/></div>
            <div class="megas512" style=" margin-top:15px;"><?=pageft($total,$pagesize,u(MOD,'list',array('q'=>$q,'se'=>$se,'checked'=>$checked)));?></div>
            </div>
       </form>
<?php include(ADMINTPL.'/footer.tpl.php');?>