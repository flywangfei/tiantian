<script>
function suanfanli(v){
	f=fan*v/price;
	f=Math.round(f * 100) / 100;
    $('#jumpbox .text_f').text(f);
}
$(function(){
	
	$("a.taopic").live('mouseover',function(e){
		var topx = 120;
		var positionX=e.originalEvent.x-$(this).offset().left||e.originalEvent.layerX||0;
		var positionY=e.originalEvent.y-$(this).offset().top||e.originalEvent.layerY||0;
		var imgSrc = decode64($(this).attr('pic'));
		$('#layerPic .photo').html('<img src="'+imgSrc+'" />');
		$('#layerPic').css('display', 'block');
		var imgH = $('#layerPic img')[0].height;
		if (imgH>400) {
			$('#layerPic img').css('height', '400px');
			imgH = 400;
		}
		var imgX = $(this).offset().left;
		var imgY = $(this).offset().top;
		var layX = imgX + 100;
		var layY = imgY;
		var toTop = $(document).scrollTop() - $(this).offset().top;
		if (toTop>0) {
			layY += toTop;
			toTop = 20;
		} else {
			var toTop = $(this).offset().top - $(document).scrollTop() + imgH + 20 - $(window).height();
			if (toTop>0) {
				layY -= toTop;
				if (toTop>imgH) toTop = imgH;
			} else toTop = 20;
		}

		$('#layerPic').css('left', layX+'px');
		$('#layerPic').css('top', layY+'px');
		$('#layerPic .sell_bg').css('top', (toTop+20)+'px');
		$("a.taopic").mouseout(function(e){
			$('#layerPic').css('display', 'none');						  
		});
	});
	
	<?php if($webset['taoapi']['fanlitip']==1){?> 
    $('#splistbox .info .fanlitip').jumpBox({  
	    title: '这是您刚刚查看的商品：',
		titlebg:1,
		LightBox:'show',
		easyClose:0,
		jsCode:"param2=parse_str(ajaxUrl);pic_url=decode64(param2['pic']);title=$(this).parents('.info').find('.title').find('a').text();price=param2['price'];fan=param2['fan'];contain = contain.replace(/{pic_url}/, pic_url).replace(/{title}/, title).replace(/{price}/, price).replace(/{back}/, fan);",
		contain:'<div class="alert_go_tao"><div class="info"><table width=""border="0"><tr><td width="62"rowspan="3"><div class="pic"><img src="{pic_url}"/></div></td><td width="219"><span class="tit">{title}</span></td></tr><tr><td><span class="price">淘宝价格：{price}元</span><span class="fan">　返现：{back}元</span></td></tr><tr><td><span class="price_r">实付价格：</span><input type="text"class="text_p"value=""  onkeyup="suanfanli(this.value)"/><span class="fan_r">实返现：</span><span class="text_f">？</span></td></tr></table><div style="clear:both"></div><div class="alert_notice"><em></em><div class="notice_content">输入最终购买价格(不含邮费)，算一下最终返利有多少？</div></div></div><p><span>●</span><a>虚拟商品无返利</a><span>●</span><a>实际返利与成交价有关</a><span>●</span><a>确认收货后才能查询返利</a></p><div style=" margin-top:3px"><a href="<?=u('article','view',array('id'=>1))?>'+
'" style="color:#03F" target="_blank">●用“<?=WEBNICK?>”去“淘宝网”购物 省钱方法详解【点击】</a></div></div>',
		height:240,
		width:520,
		a:1
    });
	<?php }?>
	
	$('#splistbox .seecomment').live('click',function(){
	    var url=$(this).attr('url');
		var goto=$(this).attr('goto');
		var commentUrl="http://rate.taobao.com/detail_rate.htm?"+url+"&showContent=2&currentPage=1&ismore=1&siteID=7";
		jumpboxOpen('<div id="comment"><div><div class="commentleft">评论</div><div class="commentright">评价人</div></div><div style=" clear:both; overflow-y:scroll; height:380px" id="commentc"><ul style=" margin-top:120px; text-align:center;">正在加载评价……<br/><img alt="等待加载评论" src="images/wait2.gif" /></ul></div>',446,830);
		$.ajax({
	        url: '<?=u('ajax','goods_comment')?>',
		    type: "POST",
		    data:{'comment_url':commentUrl},
		    dataType: "json",
		    success: function(data){
			    if(data.rateListInfo.paginator.items>0){
					jsonData=data.rateListInfo.rateList;
					c=jsonData.length;
					$('#commentc').html('');
					for(var i=0;i<c;i++){
						if(jsonData[i]['displayRatePic']=='') jsonData[i]['displayRatePic']='b_red_1.gif';
                        jsonLi='<li><div class="commnetleft">'+jsonData[i]['rateContent']+'<br><span>['+jsonData[i]['rateDate']+']</span></div><div class="commnetright">买家：'+jsonData[i]['displayUserNick']+'<br><img alt="信用" src="images/'+jsonData[i]['displayRatePic']+'" /></div><div style=" clear:both"></div<></li>';
						$('#commentc').append(jsonLi);
                    }
			    }
			    else{
			        alert('无评价');
					jumpboxClose();
			    }
		     },
			 error: function(XMLHttpRequest,textStatus, errorThrown){
                 alert('评论内容获取失败');
				 //alert(XMLHttpRequest.status);
                 //alert(XMLHttpRequest.readyState);
				 //alert(textStatus);
				 jumpboxClose();
             }
	    });
	});
});
<?php if($webset['taoapi']['promotion']==1){?>
function getCuxiao(iids){
    $.ajax({
	    url: '<?=u('ajax','tao_cuxiao')?>',
		type: "POST",
		data:{'iids':iids},
		dataType: "json",
		success: function(resp){//alert(resp[0].price);
			for(var i in resp){
				data=resp[i];
			    var cuxiaoPrice=data.price;
				var cuxiaoName=data.name;
				var iid=data.iid;
				$('#'+iid).html('<i>'+cuxiaoName+'</i>：<b>'+cuxiaoPrice+'</b> 元');
				var price=$('#'+iid).parents('.info').find('.price span').text();
				$('#'+iid).parents('.info').find('.price span').css('text-decoration','line-through');
				var fxje=$('#'+iid).parents('.info').find('.fxje span').text();
				var x=fxje*cuxiaoPrice/price;
				x=Math.round(x * 100) / 100;
				$('#'+iid).parents('.info').find('.fxje span').text(x);
			}
		},
	    error: function(){
            //alert('失败');
        }
	});
}
<?php
$iids='';$i=0;
foreach($iid_arr as $v){
	if($i==5){ //每5个iid提交一次请求
		echo 'getCuxiao("'.$iids.'");';
		$iids='';$i=0;
	}
	$iids.=$v.',';
	$i++;
}
echo 'getCuxiao("'.$iids.'");';
}
?>
</script>