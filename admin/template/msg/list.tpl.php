<?php include(ADMINTPL.'/header.tpl.php');?>
<form name="form1" action="" method="get">
<table cellspacing="0" width="100%" style="border:1px  solid #DCEAF7; border-bottom:0px; background:#E9F2FB">
        <tr>
              <td width="115px" class="bigtext">&nbsp;<img src="images/arrow.gif" width="16" height="22" align="absmiddle" />&nbsp;<a href="<?=u(MOD,'addedi')?>" class="link3">[发送站内信]</a> </td>
              <td width="" align="right">会员名：<input type="text" name="uname" value="<?=$uname?>" />&nbsp;<?=select($do_arr,$do,'do')?>&nbsp;<input type="submit" value="提交" /></td>
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
                      <th width="6%">状态</th>
                      <th width="115px">标题</th>
                      <th width="">内容</th>
					  <th width="115px"><?=$do_arr[$do_reverse]?></th>
                      <th width="140px">发送时间</th>
                      <th width="115px">执行操作</th>
                    </tr>
					<?php foreach ($row as $r){?>
					  <tr>
                        <td><input type='checkbox' name='ids[]' value='<?=$r["id"]?>' id='content_<?=$r["id"]?>' /></td>
                        <td><img src="../images/msg<?=$r["see"]?>.gif" /></td>
                        <td><?=$r["title"]?></td>
						<td style="padding:5px; text-align:left; line-height:15px"><?=$r["content"]?></td>
						<td><?=$r["ddusername"]?$r["ddusername"]:'网站客服'?></td>
                        <td><?=$r["addtime"]?></td>
						<td><a class="read" href="<?=u(MOD,'addedi',array('id'=>$r["id"]))?>">阅读</a></td>
					  </tr>
					<?php }?>
                  </table>
        <div style="position:relative; padding-bottom:10px">
            <input type="hidden" name="mod" value="<?=MOD?>" /><input type="hidden" name="act" value="del" />
            <div style="position:absolute; left:5px; top:5px"><input type="submit" value="删除" onclick='return confirm("确定要删除?")'/></div>
            <div class="megas512" style=" margin-top:15px;"><?=pageft($total,$pagesize,u(MOD,'list',array('uname'=>$uname,'do'=>$do)));?></div>
            </div>
       </form>
<?php include(ADMINTPL.'/footer.tpl.php');?>