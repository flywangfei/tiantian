<?php
$css[]=TPLURL."/css/view.css";
include(TPLPATH.'/header.tpl.php');
?>
<script src="js/jQuery.autoIMG.js"></script>
<script src="comm/jssdk.php"></script>
<script src="js/md5.js"></script>

<div class="mainbody">
	<div class="mainbody1000">
		<div class="shopleft">
		<?php include(TPLPATH.'/tao/shopinfo.tpl.php');?>
            <?=AD(7)?>
            <?php if(WEBTYPE==1){?>
            <div class="shopxiangguan">
                <ul>
                <?php foreach($goods2 as $row) {?>
                <li><a target="_blank" href="<?=u('tao','view',array('iid'=>$row["num_iid"]))?>"><?=html_img($row["pic_url"],2,$row['name'])?></a><p><?=$row['name']?></p><p><span>淘宝价:￥<?=$row['price']?> 元</span></p><p>返利:<b><?=$row['fxje']?> </b>元</p> </li>
                <?php }?>
                </ul>
            </div>  
            <?php }?>      
        </div>
      <div class="shopright">
       	<div class="shopitem">
                <h3><?=$goods['title']?>&nbsp;&nbsp;<span style="font-size:12px; font-family:宋体"> 【<a style="color:#F60;" href="<?=u('tao','list',array('cid'=>0,'q'=>$goods['title']))?>" target="_blank">查看同款商品</a>】</span></h3>
                <div class="shopitem_main">
                    <div class="shopitem_main_l"><a href="<?=$goods['jump']?>" target="_blank"><?=html_img($goods['pic_url'],3,$goods['title'])?></a></div>
                    <div class="shopitem_main_r">
                    	<div class="shopitem_main_r_1"><img src="images/baozhang.gif" ></div>
                        <?php if($goods['promotion_price']>0){?>
                        <div class="shopitem_main_r_2"><span class="tbcuxiao"><i><?=$goods['promotion_name']?></i></span>：<span class="price"> <?=$goods['promotion_price']?></span> 元&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;折后返<span class="price dd_fxje">计算中</span>元</div>
                        <?php }else{?>
                        <div class="shopitem_main_r_2" style="font-family:宋体"><?=$price_name?>：<span class="price"> <?=$goods['price']?></span> 元&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;最高返<span class="price dd_fxje">计算中</span>元</div>
                        <?php }?>
                        <div class="shopitem_main_r_3">运费承担： <?=$goods['freight_payer']?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php if($goods['promotion_price']>0){?>原价：<span style="text-decoration:line-through"><?=$goods['price']?></span><?php }?></div>
                        <div class="shopitem_main_r_3" style="font-family:宋体">运&nbsp;&nbsp;&nbsp;&nbsp;费： 平邮 10.00 元 快递 10.00 元 EMS 15.00 元 </div>
                        <div class="shopitem_main_r_3">商品数量： <?=$goods['num']?> 件 </div>
                        <div class="shopitem_main_r_3">所在地区： <?=$goods['location']['state']?> <?=$goods['location']['$city']?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;新旧程度： <?php if($goods['stuff_status']=='new'){echo "全新";}if($goods['stuff_status']=='unused'){echo "闲置";}if($goods['stuff_status']=='second'){echo "二手";}?> <?php if($goods['has_invoice']=='true'){echo "有发票";}?> </div>
                        <div class="shopitem_main_r_3">掌柜名称： <?=$goods['nick']?> <?=wangwang($goods['nick'])?> </div>
                        <div class="shopitem_main_r_5">温馨提示：<span> 虚拟商品如话费，游戏，机票等无返利哦！</span> </div>
                        <div class="shopitem_main_r_4"><a id="clickUrl" href="<?=$goods['jump']?>" <?php if($webset['taoapi']['fanlitip']==1){?> class="fanlitip" <?php }?> target="_blank"><img alt="立刻去购买" src="<?=TPLURL?>/images/gomai.gif" /></a><a onclick="$(this).attr('href',$('.shopmessage .dd_jump').attr('href'));" href="" target="_blank"><img alt="逛逛掌柜店铺" src="<?=TPLURL?>/images/gozhanggui.gif" /></a></div>
                        <div class="shopitem_main_r_6"><p>宝贝分享：</p>
                            <div class="bshare-custom"><a title="分享到QQ空间" class="bshare-qzone">QQ</a>
<a title="分享到新浪微博" class="bshare-sinaminiblog">新浪</a>
<a title="分享到人人网" class="bshare-renren">人人</a>
<a title="分享到腾讯微博" class="bshare-qqmb">腾讯</a>
<a title="更多平台" class="bshare-more bshare-more-icon"></a><span class="BSHARE_COUNT bshare-share-count">0</span></div><script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/buttonLite.js#style=-1&amp;uuid=<?=$webset['bshare']['uuid']?>&amp;pophcol=2&amp;lang=zh"></script><script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/bshareC0.js"></script>
                        </div>
                    </div>
                </div>
<script>
ddFxje=-1;
function showFxje(){
	if(ddFxje>=0){
		var clickUrl='<?=$goods['jump']?>'+'&fan=';
		$(".shopright .shopitem_main_r_2 .dd_fxje").html(ddFxje);
		$(".shopright .shopitem_main_r_4 #clickUrl").attr('href',clickUrl+ddFxje);
		$(".shopright .shopitem_main_l a").attr('href',clickUrl+ddFxje);
		$('.shopitem .goodscomment .pingjia .pingjia_more a').attr('href',clickUrl+ddFxje);
		clearInterval(showFxjeProcess);
	} 
}
showFxjeProcess = setInterval("showFxje()", 500);

$(".shopright .shopitem_main_l").imgAutoSize(310,310);
function suanfanli(v){
	f=fan*v/price;
	f=Math.round(f * 100) / 100;
    $('#jumpbox .text_f').text(f);
}
$(function(){
<?php if($webset['taoapi']['fanlitip']==1){?>
	$('.shopright .shopitem_main_r .fanlitip').jumpBox({  
	    title: '这是您刚刚查看的商品：',
		titlebg:1,
		LightBox:'show',
		easyClose:0,
		jsCode:"param2=parse_str(ajaxUrl);pic_url=decode64(param2['pic']);title='<?=$goods['title']?>';if(typeof param2['promotion_price']!='undefined'){price=param2['promotion_price']}else{price=param2['price']};fan=param2['fan'];contain = contain.replace(/{pic_url}/, pic_url).replace(/{title}/, title).replace(/{price}/, price).replace(/{back}/, fan);",
		contain:'<div class="alert_go_tao"><div class="info"><table width=""border="0"><tr><td width="62"rowspan="3"><div class="pic"><img src="{pic_url}"/></div></td><td width="219"><span class="tit">{title}</span></td></tr><tr><td><span class="price">淘宝价格：{price}元</span><span class="fan">　返现：{back}元</span></td></tr><tr><td><span class="price_r">实付价格：</span><input type="text"class="text_p"value=""  onkeyup="suanfanli(this.value)"/><span class="fan_r">实返现：</span><span class="text_f">？</span></td></tr></table><div style="clear:both"></div><div class="alert_notice"><em></em><div class="notice_content">输入最终购买价格(不含邮费)，算一下最终返利有多少？</div></div></div><p><span>●</span><a>虚拟商品无返利</a><span>●</span><a>实际返利与成交价有关</a><span>●</span><a>确认收货后才能查询返利</a></p><div style=" margin-top:3px"><a href="<?=u('article','view',array('id'=>1))?>'+
'" style="color:#03F" target="_blank">●用“<?=WEBNICK?>”去“淘宝网”购物 省钱方法详解【点击】</a></div></div>',
		height:240,
		width:520,
		a:1
    });
<?php }?>
<?php if($webset['taoapi']['goods_comment']==1){?>
    $('.shopit_txt a').click(function(){
    	$('.shopit_txt ul li').addClass('shopit_xz');
		$(this).parent('li').removeClass('shopit_xz');
		vdo=$(this).attr('do');
		
		if(vdo=='desc'){
		    $('.shopit_txt_ms').show();
			$('.goodscomment').hide();
			return true;
		}
		else if(vdo=='comment'){
		    $('.shopit_txt_ms').hide();
			$('.goodscomment').show();
		}
		
		var commentUrl=$('.shopit_txt #pjan').attr('url');
		if(commentUrl==''){
			alert('评论地址加载中，请稍后再试');
			return true;
		}
		$.ajax({
	        url: '<?=u('ajax','goods_comment')?>',
		    type: "POST",
		    data:{'comment_url':commentUrl},
		    dataType: "json",
		    success: function(data){
			    if(data.rateListInfo.paginator.items>0){
			        var commentScore=parseFloat(data.scoreInfo.merchandisScore);  //评价得分
					var commentItems=parseInt(data.rateListInfo.paginator.items);  //评价数量
					var commentTotal=parseInt(data.scoreInfo.merchandisTotal);  //评价总次数
					
					num=commentScore*10;
					x2 = Math.floor(num%10); 
					num /= 10; 
                    x1 = Math.floor(num%10); 

					$('.pingjianum').html(commentItems); 
		            $('#pjdfnum').html(commentTotal);
		            $('.ajaxpjdf').html(commentScore);
		            var biaochi=parseInt(commentScore/5*380);
		            $('#biaochi').css('margin-left',biaochi+'px');
			        $('#getpling').hide();
			        $('#plcontent').show();
					$('.goodscomment .ov5hx').css('width',commentScore*20)
					
					jsonData=data.rateListInfo.rateList;
					c=jsonData.length;
					for(var i=0;i<c;i++){
						if(jsonData[i]['displayRatePic']=='') jsonData[i]['displayRatePic']='b_red_1.gif';
                        jsonLi='<li><div class="commnetleft">'+jsonData[i]['rateContent']+'<br><span>['+jsonData[i]['rateDate']+']</span></div><div class="commnetright">买家：'+jsonData[i]['displayUserNick']+'<br><img src="images/'+jsonData[i]['displayRatePic']+'" /></div></li>';
						$('#comment').append(jsonLi+'<div style="clear:both"></div>');
                    }
			    }
			    else{
			        alert('评论加载失败');
			    }
		     }
	    });
	});
<?php }?>
});
<?php
if(in_array($jssdk_items_convert['cid'],$virtual_cid['goods'])){ //虚拟商品返利强制为0
	echo 'ddFxje=0;';
}
else{
	php2js_array($jssdk_items_convert,'parame');
	echo "taobaoTaobaokeWidgetItemsConvert(parame);";
}	

/*$jssdk_url_convert['outer_code']=1;
$jssdk_url_convert['url']='http://ju.taobao.com/tg/home.htm?spm=608.1000562.0.5.6bda93&item_id=18739176492&page=1';
echo "taobaoTaobaokeWidgetUrlConvert(parame);";*/
?>
</script>

                <div class="shopit_txt">
                    <ul>
                    <?php if(WEBTYPE==1){?>
                    <li><a do='desc'>宝贝描述</a> </li>
                    <?php }?>
                    <?php if($webset['taoapi']['goods_comment']==1){?>
                    <li class="shopit_xz"><a id="pjan" do="comment" url="">商品评价</a> </li>
                    <?php }?>
                    </ul>
                    <div class="shopit_txt_ms"><?=$goods['desc']?></div>
                </div>
                <div class="goodscomment" style=" display:none">
                
                <div class="pjdf">
					<div class="pjleft"><ul>
						<li class="pjfs">店铺的“宝贝与描述相符”得分</li>
						<li class="pjfs2">
                        <div style="float:left"><font class="ajaxpjdf" style="font-size:24px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#FF6600">5.0</font> 分</div>
                        <div style="float:left">
                        <DIV class=xx3 style="padding-top:5px">
                        <DIV class="bg5bx">
                    <DIV class="ov5hx" style="WIDTH: 100px;"></DIV>
                    </DIV>
                    </DIV>
                        </div>
                        <div style="clear:both"></div>
                        </li>
						<li class="gdf">(共打分 <font id="pjdfnum" color="#FF6600">100</font> 次)</li>
						</ul>
					</div>
					<div class="pjright">
						<ul>
							<li style="width:380px; height:20px; margin-top:21px;"><div id="biaochi" style="width:28px; height:21px; background:url(template/<?=MOBAN?>/images/pjfs.gif); margin-left:370px; text-align:center;"><font class="ajaxpjdf" style="font-size:12px; font-family:Arial, Helvetica, sans-serif; color:#fff">4.5</font></div></li>
							<li style="background:url(template/<?=MOBAN?>/images/rate_scroller_bar.png) no-repeat; width:400px; height:20px;"></li>
							<li style=" width:420px; background:url(template/<?=MOBAN?>/images/pjfssm.gif) no-repeat; height:45px;"></li>
						</ul>
					</div>
				</div>

                <div class="pingjia">
                    <div class="pingjia_bt">
                    	 <div class="pingjia_bt_l">
                    	 评论
                    	 </div>
                         <div class="pingjia_bt_r">
                    	 评价人
                    	 </div>
                    </div>
                    <div id="comment">
  
                    </div>
                    <div class="pingjia_more">
                     <a href="<?=$goods['jump']?>" target="_blank">更 多</a>
                    </div>
                </div>
                </DIV>
        </div>
                   
                 
            </div>
        </div> 
	</div>
<div class="clear"></div>
<?php include(TPLPATH.'/footer.tpl.php');?>