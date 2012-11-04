<?php
$css[]=TPLURL."/css/shop.css";
$css[]=TPLURL."/css/list.css";
include(TPLPATH."/header.tpl.php");
?>
<script src="comm/jssdk.php"></script>
<script src="js/md5.js"></script>
<div class="mainbody">
	<div class="mainbody1000">
        
		<div class="shopleft">
            <div id="shopfix">
        	<?php include(TPLPATH.'/tao/shopinfo.tpl.php');?>
            </DIV>
            <?=AD(8)?>        
        </div>
        <div class="small_big" id="layerPic">
			<div class="sell_bg"></div>
			<div class="photo"></div>
		 </div>
        <div class="shopright">
        	<div class="goodslist">
                <?php include(TPLPATH."/tao/hotword.tpl.php");?>
                <?php include(TPLPATH."/tao/list".$list.".tpl.php");?> 
            </div>
            
        </div> 
	</div>
</div>
<script>
//fixDiv('shopfix',2);
</script>
<?php
include(TPLPATH."/footer.tpl.php");
?>
