<?php 
include(ADMINTPL.'/header.tpl.php');
$mall_type=array(''=>'全部')+$this_type;
?>
<form name="form1" action="" method="get">
<table cellspacing="0" width="100%" style="border:1px  solid #DCEAF7; border-bottom:0px; background:#E9F2FB">
        <tr>
              <td width="20%">&nbsp;<img src="images/arrow.gif" width="16" height="22" align="absmiddle" />&nbsp;<a href="<?=u(MOD,'addedi')?>" class="link3">[新增商城]</a> </td>
              <td width="" align="right">商城名或网址：<input type="text" name="q" value="<?=$q?>" />&nbsp;<?=select($mall_type,$cid,'cid')?>&nbsp;<input type="submit" value="提交" /></td>
              <td width="150px" align="right">共有 <b><?php echo $total;?></b> 条记录&nbsp;&nbsp;</td>
            </tr>
      </table>
      <input type="hidden" name="mod" value="<?=MOD?>" />
      <input type="hidden" name="act" value="<?=ACT?>" />
      </form>
      <form name="form2" method="get" action="" style="margin:0px; padding:0px">
                  <table id="listtable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
                    <tr>
                      <th width="4%"><input type="checkbox" onClick="checkAll(this,'ids[]')" /></th>
					  <th width="20%">名称</th>
                      <th width="">网址</th>
                      <th width="6%">联盟</th>
                      <th width="5%">最高返</th>
                      <th width="6%">类别</th>
                      <th width="8%"><a href="<?=u(MOD,'list',array('edate'=>$listedate))?>">到期时间</a></th>
                      <th width="5%"><a href="<?=u(MOD,'list',array('sort'=>$listsort))?>">排序</a></th>
                      <th width="5%">logo</th>
                      <th width="140px">添加时间</th>
                      <th width="6%">操作</th>
                    </tr>
					<?php foreach ($row as $r){?>
					  <tr>
                        <td><input type='checkbox' name='ids[]' value='<?=$r["id"]?>' id='content_<?=$r["id"]?>' /></td>
						<td><?=$r["title"]?></td>
                        <td><?=$r["url"]?></td>
                        <td><?=$lm[$r["lm"]]?></td>
                        <td><?=$r["fan"]?></td>
                        <td><?=$this_type[$r["cid"]]?></td>
                        <td><?=date('Y-m-d',$r["edate"])?></td>
                        <td><?=$r["sort"]?></td>
                        <td class="showpic" pic="<?=http_pic($r["img"])?>">查看</td>
						<td><?=date('Y-m-d H:i:s',$r["addtime"])?></td>
						<td><a href="<?=u(MOD,'addedi',array('id'=>$r['id']))?>" class=link4>修改</a></td>
					  </tr>
					<?php }?>
                  </table>
				<div style="position:relative; padding-bottom:10px">
            <input type="hidden" name="mod" value="<?=MOD?>" /><input type="hidden" name="act" value="del" />
            <div style="position:absolute; left:5px; top:5px"><input type="submit" value="删除" class="myself" onclick='return confirm("确定要删除?")'/></div>
            <div class="megas512" style=" margin-top:15px;"><?=pageft($total,$pagesize,u(MOD,'list',array('cid'=>$cid,'q'=>$q,'edate'=>$_GET['edate'],'sort'=>$sort)));?></div>
            </div>
       </form>
<?php include(ADMINTPL.'/footer.tpl.php');?>