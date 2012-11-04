<?php  //淘宝商品列表
$css[]=TPLURL."/css/goods.css";
$css[]=TPLURL."/css/list.css";
include(TPLPATH."/header.tpl.php");
?>
<script src="comm/jssdk.php"></script>
<script src="js/md5.js"></script>
<div class="mainbody">
	<div class="mainbody1000">
		
        <div class="small_big" id="layerPic">
			<div class="sell_bg"></div>
			<div class="photo"></div>
		 </div>
         
        <div class="goodsleft">
        
        <?php if($cat_list[0]!=''){?>
        <div class="goodslist" style="margin-bottom:10px;">
    <div class="morecat">
      <ul>
      <?php foreach($cat_list as $k=>$v){?>
      <li><a href="<?=u('tao','list',array('cid'=>$v['cid']))?>" <?php if($v['cid']==$cid){?> style="font-weight:bold; color:#F00" <?php }?>)><?=$v['name']?></a></li>
      <?php }?>
      </ul>
      <div style="clear:both"></div>
    </div>
    </div>
    <?php }?>
        	<div class="goodslist">
                <?php include(TPLPATH."/tao/hotword.tpl.php");?>
                <?php include(TPLPATH."/tao/list".$list.".tpl.php");?>
                <?php if(empty($goods)){?>
                     <div style="margin-left:10px; margin-bottom:30px; font-size:14px">暂无查询条件商品数据！</div>
                     <?php }?> 
                <div class="megas512" ><?=pageft($TotalResults,$pagesize,$show_page_url,WJT)?></div>
            </div>
            
        </div> 
        <div class="goodsright">
        	<div class="shopmessage">
            <?php include(TPLPATH."/tao/right.tpl.php");?>
        
            </div>
              <?=AD(3)?>      
        </div>
	</div>
</div>	
<script type="text/javascript" src="js/jquery.lazyload.js"></script>
<script language="javascript">
<?php
$jssdk_shops_convert['method']='taobao.taobaoke.widget.shops.convert';
$jssdk_shops_convert['count']=count($nick_arr);
$jssdk_shops_convert['from']='list';
$jssdk_shops_convert['fields']='seller_nick,user_id,seller_credit,shop_type';

$i=0;
$strnicks='';
if($jssdk_shops_convert['count']>10){
	foreach($nick_arr as $v){
		$strnicks.=$v.',';
		if($i==9){
			$strnicks=preg_replace('/,$/','',$strnicks);
			$nicks_array[]=$strnicks;
			$i=-1;
			$strnicks='';
		}
		$i++;
	}
	$strnicks=preg_replace('/,$/','',$strnicks);
	if($strnicks!=''){
		$nicks_array[]=$strnicks;
	}
}
else{
	$nicks_array[]=implode(',',$nick_arr);
}
echo "shopsInfo=new Array();j=0;\r\n";
foreach($nicks_array as $strnicks){
	$jssdk_shops_convert['seller_nicks']=$strnicks;
	php2js_array($jssdk_shops_convert,'parame');
	echo "taobaoTaobaokeWidgetShopsConvert(parame);\r\n";
}
?>

function showLevel(){ 
	for(var i in shopsInfo){
		var goodsdom=$('#splistbox .info');
		if(shopsInfo[i]['level']>0){
			$(goodsdom).find('img[zhanggui='+shopsInfo[i]['seller_nick']+']').attr('src','images/level_'+shopsInfo[i]['level']+'.gif');
			var plurl=$(goodsdom).find('a[zhangguiid='+shopsInfo[i]['seller_nick']+']').attr('url');
			$(goodsdom).find('a[zhangguiid='+shopsInfo[i]['seller_nick']+']').attr('url','userNumId='+shopsInfo[i]['user_id']+plurl);
		}
		else{
			$(goodsdom).find('img[zhanggui='+shopsInfo[i]['seller_nick']+']').remove();
		}
		clearInterval(showLevelProcess);
	}
}
showLevelProcess = setInterval("showLevel()", 100);
$(function(){
	$("div.pic a img").lazyload({
        placeholder : "<?=TPLURL?>/images/grey.gif",
        effect      : "fadeIn",
	    threshold : 200
    });
})
</script>
<?php include(TPLPATH."/footer.tpl.php");?>