<?php include(ADMINTPL.'/header.tpl.php');?>
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
  <tr>
    <td width="115px" align="right">晒单奖励积分：</td>
    <td>&nbsp;<input name="baobei[shai_jifen]" value="<?=$webset['baobei']['shai_jifen']?>"/></td>
  </tr>
  <tr>
    <td align="right">分享奖励积分：</td>
    <td>&nbsp;<input name="baobei[share_jifen]" value="<?=$webset['baobei']['share_jifen']?>"/></td>
  </tr>
  <tr>
    <td align="right">红心奖励积分：</td>
    <td>&nbsp;<input name="baobei[hart_jifen]" value="<?=$webset['baobei']['hart_jifen']?>"/></td>
  </tr>
  <tr>
    <td align="right">晒单起始时间：</td>
    <td>&nbsp;<input name="baobei[shai_s_time]" value="<?=$webset['baobei']['shai_s_time']?>"/></td>
  </tr>
  <tr>
    <td align="right">宝贝评语：</td>
    <td>&nbsp;<input name="baobei[word_num]" value="<?=$webset['baobei']['word_num']?>"/> (个字以内)不要过多，否则页面容易错位</td>
  </tr>
  <tr>
    <td align="right">宝贝评论：</td>
    <td>&nbsp;<input name="baobei[comment_word_num]" value="<?=$webset['baobei']['comment_word_num']?>"/> (个字以内)不要过多，否则页面容易错位</td>
  </tr>
  <tr>
    <td align="right">分享等级限制：</td>
    <td>&nbsp;<input name="baobei[share_level]" value="<?=$webset['baobei']['share_level']?>"/> 会员等级大于此设置才可分享商品</td>
  </tr>
  <tr>
    <td align="right">评论等级限制：</td>
    <td>&nbsp;<input name="baobei[comment_level]" value="<?=$webset['baobei']['comment_level']?>"/> 会员等级大于此设置才可评论商品</td>
  </tr>
  <tr>
    <td align="right">栏目设置：</td>
    <td>&nbsp;<?php foreach($webset['baobei']['cat'] as $k=>$v){?><input style="width:40px;" name="baobei[cat][<?=$k?>]" value="<?=$v?>"/>&nbsp;<?php }?> 注意：只能进行同义词修改，比如“上衣”改成“上装”</td>
  </tr>
  <tr>
     <td align="right">&nbsp;</td>
     <td>&nbsp;<input type="hidden" name="baobei[re_tao_cid]" value="<?=$webset['baobei']['re_tao_cid']?>" /><input type="submit" name="sub" value=" 保 存 设 置 " /></td>
  </tr>
  </form>
</table>

<?php include(ADMINTPL.'/footer.tpl.php');?>