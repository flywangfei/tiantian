<?php include(ADMINTPL.'/header.tpl.php');?>
<form action="" method="get">
<table cellspacing="0" width="100%" style="border:1px  solid #DCEAF7; border-bottom:0px; background:#E9F2FB">
        <tr>
              <td width="50px">&nbsp;<img src="images/arrow.gif" width="16" height="22" align="absmiddle" /></td>
              <td width="" align="right"><?=select($select1_arr,$se1,'se1')?>：<input type="text" name="q" value="<?=$q?>" />&nbsp;<?=select($select2_arr,$se2,'se2')?>：<input type="text" style="width:30px" name="linput" value="<?=$linput?>" />-<input type="text" style="width:30px" name="hinput" value="<?=$hinput?>" />&nbsp;<input type="submit" value="提交" /></td>
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
                      <th width="4%">id</th>
                      <th width="">用户名</th>
                      <th width="6%">推荐人ID</th>
                      <th width="140px">注册时间</th>
                      <th width="150px">邮箱</th>
                      <th width="140px"><a href="<?=u(MOD,'list',array('lastlogintime'=>$listorder))?>">最近登录</a></th>
                      <th width="5%"><a href="<?=u(MOD,'list',array('loginnum'=>$listorder))?>">登录次数</a></th>
                      <th width="5%"><a href="<?=u(MOD,'list',array('level'=>$listorder))?>">等级</a></th>
                      <th width="5%"><a href="<?=u(MOD,'list',array('money'=>$listorder))?>">金额</a></th>                     
                      <th width="5%"><a href="<?=u(MOD,'list',array('jifen'=>$listorder))?>">积分</a></th>
                      <th width="9%">QQ</th>
                      <th width="115px">操作</th>
                    </tr>
					<?php foreach ($row as $r){?>
					  <tr>
                        <td><input type='checkbox' name='ids[]' value='<?=$r["id"]?>' id='content_<?=$r["id"]?>' /></td>
                        <td><?=$r["id"]?></td>
                        <td><?=$r["ddusername"]?></td>
						<td><?=$r["tjr"]?></td>
                        <td><?=$r["regtime"]?></td>
                        <td><?=$r["email"]?></td>
						<td><?=$r["lastlogintime"]?></td>
                        <td><?=$r["loginnum"]?></td>
                        <td><?=$r["level"]?></td>
                        <td><?=$r["money"]?></td>
                        <td><?=$r["jifen"]?></td>
                        <td><?=qq($r["qq"])?></td>
						<td><a href="<?=u(MOD,'addedi',array('id'=>$r['id']))?>">查看</a>&nbsp;<a href="<?=u('mingxi','list',array('uname'=>$r['ddusername']))?>">明细</a></td>
					  </tr>
					<?php }?>
		</table>
        <div style="position:relative; padding-bottom:10px">
            <input type="hidden" name="mod" value="<?=MOD?>" /><input type="hidden" name="act" value="del" />
            <div style="position:absolute; left:5px; top:5px"><input type="submit" value="删除" onclick='return confirm("确定要删除?")'/></div>
            <div class="megas512" style=" margin-top:15px;"><?=pageft($total,$pagesize,u(MOD,'list',$page_arr));?></div>
            </div>
       </form>
<?php include(ADMINTPL.'/footer.tpl.php');?>