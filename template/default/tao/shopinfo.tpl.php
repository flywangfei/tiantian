<script>
<?php
echo "shopsInfo=new Array();j=0;";
$parame['seller_nicks']=$nick;
php2js_array($jssdk_shops_convert,'parame');
echo "taobaoTaobaokeWidgetShopsConvert(parame);\r\n";
?>
function showShopInfo(){
	if(shopsInfo['level']>0){
		$('.shopmessage #shopFxbl').html(shopsInfo['fxbl']+'%');
		$('.shopmessage .shoptxt-img img').attr('src','images/level_'+shopsInfo['level']+'.gif');
		$('.shopmessage #goodsnum').html('宝贝数量：'+shopsInfo['auction_count']);
		$('.shopmessage .dd_jump').attr('href',shopsInfo['jump']);
		clearInterval(showShopInfoProcess);
		
		<?php if(MOD=='tao' && ACT=='shop'){?>
		var goodsUrl='index.php?mod=ajax&act=shop_items_get&uid='+shopsInfo['user_id']+'&nick='+encodeURIComponent(shopsInfo['seller_nick'])+'&taoke='+shopsInfo['taoke']+'&level='+shopsInfo['level']+'&list=<?=$list?>';
		$.ajax({
	    	url: goodsUrl,
			type: "GET",
			success: function(data){
		    	if(data!=''){
					$('#splistbox ul').html(data);
				}
			}
		});
		<?php }?>
		
		<?php if(MOD=='tao' && ACT=='view'){?>
		$('.shopit_txt #pjan').attr('url','<?=$comment_url?>'+shopsInfo['user_id']);
		<?php }?>
	}
}
showShopInfoProcess = setInterval("showShopInfo()", 500);
</script>
<div class="shopmessage">
                <div class="shopname">
                	<h3><A class="dd_jump" href="" target=_blank><?=$shop['title']?></A></h3>
                </div>
                <div class="shoplogo">
                    <div class="shoplogo-img"><?=html_img($shop['logo'],0,$shop['title'],'',80,80,$shop['onerror'])?></div>
                    <div class="shoplogo-font"><p>平均返现:</p><h3 id="shopFxbl"></h3></div>
                </div>
                <div class="shoptxt">
                <p>掌柜名称：<a class="dd_jump" href="" target="_blank" ><?=$shop['nick']?></a></p>
                <p>店铺信誉：<span class="shoptxt-img"><img src="images/level_<?=$shop['level']?>.gif" ></span></p>
                <p id="goodsnum">宝贝数量：</p>
                <p>创店时间：<?=date('Y-m-d',strtotime($shop['created']))?></p>
                <b>店铺动态评分</b>
                <div class="shoptxt-dt">	
                    <DIV class=title>宝贝与描述相符：</DIV>
                    <DIV class=xx3>
                    <DIV style="WIDTH: 100px; BACKGROUND: url(<?=TPLURL?>/images/5bx.gif) no-repeat 0px 0px; FLOAT: left; HEIGHT: 19px" title="<?=$shop['item_score']?>分">
                    <DIV style="WIDTH: 100px; BACKGROUND: url(<?=TPLURL?>/images/5hx.gif) 0px 0px; HEIGHT: 19px; width:<?=$shop['item_score']*20?>px">
                    </DIV>
                    </DIV>
                    </DIV>
                </div>
                <div class="shoptxt-dt">
                	<DIV class=title>卖家的服务态度：</DIV>
                    <DIV class=xx3>
                    <DIV style="WIDTH: 100px; BACKGROUND: url(<?=TPLURL?>/images/5bx.gif) no-repeat 0px 0px; FLOAT: left; HEIGHT: 19px" title="<?=$shop['service_score']?>分">
                    <DIV style="WIDTH: 100px; BACKGROUND: url(<?=TPLURL?>/images/5hx.gif) 0px 0px; HEIGHT: 19px; width:<?=$shop['service_score']*20?>px">
                    </DIV>
                    </DIV>
                    </DIV>
                </div>
                <div class="shoptxt-dt">
                	<DIV class=title>卖家发货的速度：</DIV>
                    <DIV class=xx3>
                    <DIV style="WIDTH: 100px; BACKGROUND: url(<?=TPLURL?>/images/5bx.gif) no-repeat 0px 0px; FLOAT: left; HEIGHT: 19px" title="<?=$shop['delivery_score']?>分">
                    <DIV style="WIDTH: 100px; BACKGROUND: url(<?=TPLURL?>/images/5hx.gif) 0px 0px; HEIGHT: 19px; width:<?=$shop['delivery_score']*20?>px">
                    </DIV>
                    </DIV>
                    </DIV>
                </div>
              
                <div class="shopbutton">
                <A class="dd_jump" href="" target=_blank>
					<DIV class=shop_button1 onMouseOver="this.className='shop_button1_h';" onmouseout="this.className='shop_button1';"></DIV>
                </A>
                </div>
              </div>
            </div>