<?php
$css[]=TPLURL.'/css/duihuan.css';
include(TPLPATH."/header.tpl.php");
?>
<div style="width:1000px; background:#FFF; border:#D0210C 1px solid; margin:auto; margin-top:10px; padding-bottom:10px">
<div id="main">
<?=AD(10)?>
  <div id="apDiv6">
    <?php include(TPLPATH."/huan/left.tpl.php");?>
  </div>
  <div id="apDiv7">
  <div id="apDiv8">
    <?php include(TPLPATH."/huan/top.tpl.php");?>
  </div>
  <div id="apDiv1124">
  <?php foreach($huan as $row){$n++;?>
    <div class="tbdplist4" <?php if($n==1){?> style="_margin-left:5px" <?php } ?>>
      <div class="apDiv4">
      <?php 
		if($row["edate"]<TIME && $row["edate"]>0){
			$fs="<div class=sgq></div>";
		}
		elseif($row["sdate"]>TIME){
		    $fs="<div class=wks></div>";
		}
		else{
			$fs="<div class=syts></div>";
		}
		echo $fs;
	?>
        <a href="<?=u('huan','view',array('id'=>$row["id"]))?>"><img src="<?php echo $row["img"];?>" width="130" height="130" alt="<?=$row["title"]?>" /></a>
      </div>
    <div id="apDiv15"><?=$row["title"]?></div>
    <div id="apDiv16"><b style="color:#F00"><?=$row["jifen"]?></b>&nbsp;积分或余额&nbsp;<b style="color:#F00"><?=$row["money"]?></b>&nbsp;元</div>
    </div><?php }$n=0;?>
    <div style="clear:both"></div>
    <div class="megas512" style="clear:both;"><?=pageft($total,$pagesize,$page_url,WJT)?></div>
    </div>
    <div style="clear:both"></div>
</div>
<div style="clear:both"></div>
</div>
<div style="clear:both"></div>
</div>
<?php include(TPLPATH."/footer.tpl.php");?>