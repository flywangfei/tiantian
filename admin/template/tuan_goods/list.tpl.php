<?php include(ADMINTPL.'/header.tpl.php');?>
<form action="" method="get">
<table cellspacing="0" width="100%" style="border:1px  solid #DCEAF7; border-bottom:0px; background:#E9F2FB">
        <tr>
              <td width="20%" class="bigtext">&nbsp;<img src="images/arrow.gif" width="16" height="22" align="absmiddle" />&nbsp;<a href="<?=u(MOD,'addedi')?>" class="link3">[添加商品]</a> </td>
              <td width="65%" align="right">商品名：<input type="text" name="q" value="<?=$q?>" />&nbsp;<?=select($malls,$mall_id,'mall_id')?>&nbsp;<input type="submit" value="提交" /></td>
              <td width="150px" align="right" class="bigtext">共有 <b><?php echo $total;?></b> 条记录&nbsp;&nbsp;</td>
            </tr>
      </table>
      <input type="hidden" name="mod" value="<?=MOD?>" />
      <input type="hidden" name="act" value="<?=ACT?>" />
      </form>
      <form name="form2" method="get" action="" style="margin:0px; padding:0px">
      <table id="listtable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
                    <tr>
                      <th width="3%"><input type="checkbox" onClick="checkAll(this,'ids[]')" /></th>
                      <th width="">商品名</th>
                      <th width="5%">城市</th>
                      <th width="7%">网站</th>
                      <th width="8%">图片</th>
                      <th width="8%">开始时间</th>
                      <th width="8%">结束时间</th>
                      <th width="5%">原价</th>
                      <th width="5%">现价</th>                     
                      <th width="5%">折扣</th>
                      <th width="6%">购买人数</th>
                      <th width="4%"><a href="<?=u(MOD,'list',array('sort'=>desc))?>">排序</a></th>
                      <th width="6%">操作</th>
                    </tr>
					<?php foreach ($row as $r){?>
					  <tr>
                        <td><input type='checkbox' name='ids[]' value='<?=$r["id"]?>' id='content_<?=$r["id"]?>' /></td>
                        <td><?=utf_substr($r["title"],56)?></td>
						<td><?=$r["city"]?></td>
                        <td><?=$r["mallname"]?></td>
                        <td class="showpic" pic="<?=$r["img"]?>">查看</td>
						<td><?=date('Y-m-d',$r["sdatetime"])?></td>
                        <td><?=date('Y-m-d',$r["edatetime"])?></td>
                        <td><?=$r["value"]?></td>
                        <td><?=$r["price"]?></td>
                        <td><?=$r["rebate"]?></td>
                        <td><?=$r["bought"]?></td>
                        <td><?=$r["sort"]?></td>
						<td><a href="<?=u(MOD,'addedi',array('id'=>$r['id']))?>" class=link4>修改</a></td>
					  </tr>
					<?php }?>
		</table>
        <div style="position:relative; padding-bottom:10px">
            <input type="hidden" name="mod" value="<?=MOD?>" /><input type="hidden" name="act" value="del" />
            <div style="position:absolute; left:5px; top:5px"><input type="submit" value="删除" onclick='return confirm("确定要删除?")'/></div>
            <div class="megas512" style=" margin-top:15px;"><?=pageft($total,$pagesize,u(MOD,'list',array('q'=>$q,'mall_id'=>$mall_id,'sort'=>'desc')));?></div>
            </div>
       </form>
<?php include(ADMINTPL.'/footer.tpl.php');?>