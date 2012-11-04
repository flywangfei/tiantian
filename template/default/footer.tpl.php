<?php
$about_us_article=$duoduo->select_all('article','id,title','cid="28" order by sort desc limit 4');

$web_help_title=array(5=>'提现问题',3=>'返利问题');
foreach($web_help_title as $k=>$v){
    $web_help_article[$k]=$duoduo->select_all('article','id,title','cid="'.$k.'" order by sort desc limit 4');
}
?>
<div style="clear:both; height:10px">&nbsp;</div>
<div class="bottom01">
<div class="xiangguan">
<ul>
<li><a target="_blank" href="<?=u('help','index')?>"><h3>新手帮助 <span style="font-weight:normal; font-size:11px; font-family:宋体">more>></span></h3></a>
<p><a target="_blank" href="<?=u('help','index',array('cid'=>3))?>">返利常见问题</a></p>
<p><a target="_blank" href="<?=u('help','index',array('cid'=>3))?>">返利订单问题</a></p>
<p><a target="_blank" href="<?=u('help','index',array('cid'=>3))?>">返利提现问题</a></p>
<p><a target="_blank" href="<?=u('help','index',array('cid'=>3))?>">用户常见问题</a></p>
</li>

<?php foreach($web_help_article as $k=>$row){?>
<li><a target="_blank" href="<?=u('article','list',array('cid'=>$k))?>"><h3><?=$web_help_title[$k]?> <span style="font-weight:normal; font-size:11px; font-family:宋体">more>></span></h3></a>
<?php foreach($row as $arr){?>
<p><a target="_blank" href="<?=u('article','view',array('id'=>$arr['id']))?>"><?=$arr['title']?></a></p>
<?php }?>
</li>
<?php }?>
<li><a target="_blank" href="<?=u('about','index')?>"><h3>关于我们 <span style="font-weight:normal; font-size:11px; font-family:宋体">more>></span></h3></a>
<?php foreach($about_us_article as $arr){?>
<p><a target="_blank" href="<?=u('about','index',array('id'=>$arr['id']))?>"><?=$arr['title']?></a></p>
<?php }?>
</li>
</ul>


</div>
<div id="line01">&nbsp;</div>
<div class="xhqu"><?=$webset['banquan']?></div>
</div>
</div>
<?php if(MOD=='huan'){?>
<!--[if IE 6]>
<script src="<?=TPLURL?>/js/DD_belatedPNG_0.0.8a-min.js" mce_src="<?=TPLURL?>/js/DD_belatedPNG_0.0.8a-min.js"></script>
<script type="text/javascript">
DD_belatedPNG.fix('.syts');
DD_belatedPNG.fix('.sgq');
</script> 
<![endif]--> 
<?php }?>

<div id="searchtip">
<div class="xha001">
<div class="xhafont">
<div class="word">
粘贴您刚才看的<b>“淘宝商品地址”</b>到这里购物拿返利！
</div>
<div class="zhizhen">&nbsp;</div>
</div>
<form action="index.php" target="_blank" onsubmit="jumpboxClose()">
<input type="hidden" name="search" value="1" />
<input type="hidden" name="mod" value="tao" />
<input type="hidden" name="act" value="view" />
<div class="xhasearch"><div class="xhasearch2"><input class="xhasearch3" name="q" type="text" /><input class="xhasearch4" value="&nbsp;" name="sub" type="submit" /></div></div>
</form>
<div class="xhalinks">
<div>1、去淘宝网选择自己喜欢的商品。</div>
<div>2、到本站搜索“淘宝商品网址”获取返利链接。</div>
<div>3、确认付款，拿本站额外返的现金。</div>
</div>
</div>
</div>

<?php
$kefu=dd_get_cache('kefu');
if(!empty($kefu)){
?>
<div class='QQbox' id='divQQbox' >
<div class='Qlist' id='divOnline' onmouseout='hideMsgBox(event);' style='display : none;'>
<div class='t'></div>
<div class='infobox'><?=WEBNICK?>真诚为您服务</div>
<div class='con'>
<table border="0">
  <?php foreach($kefu as $row){?>
  <tr>
    <?php if($row['type']==1){?>
    <td><?=qq($row['code'])?></td><td scope="col"><?=$row['title']?></td>
    <?php }else{?>
    <td><?=wangwang($row['code'])?></td><td scope="col"><?=$row['title']?></td>
    <?php }?>
  </tr>
  <?php }?>
</table>
</div>
<div class='b'></div>
</div>
<div id='divMenu' onmouseover='OnlineOver();'><img src='images/qq_1.gif' class='press' alt='在线咨询'></div>
<script language='javascript' src='js/kefu.js' type='text/javascript' charset='utf-8'></script>
</div>
<?php }?>
</body>
</html>