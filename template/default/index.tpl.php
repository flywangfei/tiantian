<?php
$taoshop_num=15; 
$shangcheng_num=8;
$mall_num=23;

//首页标签
$tpl=dd_get_cache('index.tpl');

//幻灯片
$slides=dd_slides($duoduo,10);

//网站前台公告
$article_3=dd_article($duoduo,27,4);

//商城类型
$type_all=dd_get_cache('type');
$mall_type=$type_all['mall'];

//淘宝店铺
$shops=dd_shop($duoduo,$webset,$dduser,$taoshop_num);

//商城
$shangcheng=dd_mall($duoduo,$shangcheng_num);

foreach($shops as $i=>$row){
	$row['url']=u('tao','shop',array('nick'=>$row['nick']));
	$row['fan']=fenduan($row['fanxianlv'],$webset['fxbl'],$dduser['level']).'%';
	$row['img']=TAOLOGO.$row['pic_path'];
	$shops[$i]=$row;
}

foreach($shangcheng as $i=>$row){
	$row['url']=u('mall','view',array('id'=>$row['id']));
	$shangcheng[$i]=$row;
}

$malls=array_merge($shops,$shangcheng);

//淘宝热卖
$tao_goods=dd_index_tao_goods($duoduo,$webset,$dduser,$ddTaoapi,$tao_hot_page,5);

//拍拍热卖
if($webset['paipai']['open']==1){
	include(DDROOT.'/comm/paipai.class.php');
	$paipai_set=$webset['paipai'];
	$paipai_set['fxbl']=$webset['paipaifxbl'];
	$paipai_goods=dd_paipai($paipai_set,$dduser,$pai_hot_page);
}

//大家正在省
$dingdaning=dd_index_dingdan($duoduo,$webset,$dduser,$ddTaoapi,10);

if($webset['tuan']['open']==1){//团购商品
    $tuan_goods=dd_tuan($duoduo,$tuan_start_num,5);
}

//淘宝打折
$tao_zhe=$webset['tao_zhe'];
$goods=dd_tao_zhe($tao_zhe,$ddTaoapi,$tao_zhe_page,$webset['fxbl'],$dduser['level']);

//热门分享
$baobei=dd_baobei($duoduo,5);

//友情链接
$yqlj=dd_link($duoduo,30,0);

//合作伙伴
$hzhb=dd_link($duoduo,30,1);

$css[]=TPLURL."/css/index.css";
include(TPLPATH.'/header.tpl.php');
?>
<script src="<?=TPLURL?>/js/jquery.KinSlideshow-1.2.1.min.js" type="text/javascript"></script>
<script type="text/javascript">
var siteUrl='<?=SITEURL?>';
var curlUrl='http://'+document.domain+'<?=URLMULU?>';
if(curlUrl!=siteUrl){
	window.location.href=siteUrl;
}

var a=document.location.href.split('?');
var reg=/top_appkey=.*/;
if(reg.test(a[1])==true){
	window.location.href='index.php?mod=tao&act=session&'+a[1];
}

function ajaxMall(val,num){
	if(!isNaN(val)){
		data={cid:val,'num':num};
		if(val==0){
		  data.taoshop_num=<?=$taoshop_num?>;
		  data.shangcheng_num=<?=$shangcheng_num?>;
		  data.mall_num=<?=$mall_num?>;
		}
	}else{
		data={title:val,'num':num};
    }

    $.ajax({
	    url: 'index.php?mod=ajax&act=malls',
		type: "POST",
		data:data,
		dataType: "json",
		success: function(data){
		    var jsonLi='';
		    var WJT=<?=WJT?>;
		    arr=new Array();
			i=0;
		    for(var i in data){
				var liClass='';
				var onError='';
				if(val==0){
					if(i<<?=$taoshop_num?>){
						liClass=' class="tb"';
						onError="onerror=\"this.src='images/tbdp.gif'\"";
					}
				}
			    arr['id']=data[i]['id'];	
			    jsonLi+='<li'+liClass+'><div class="pailie"><a target="_blank" href="'+data[i]['url']+'"><img '+onError+' alt="'+data[i]['title']+'" src="'+data[i]['img']+'" /></a><p>最高返 | <span>'+data[i]['fan']+'</span></p></div></li>';
		    }
			if(jsonLi==''){
			    jsonLi='没有匹配商城！'
			}
		    $('.shangjia .zhanshi').html(jsonLi);
         }
	});
}
$(function(){
	$("#KinSlideshow").KinSlideshow({
		btn:{btn_fontHoverColor:"#FFFFFF"},
		titleFont:{TitleFont_size:14,TitleFont_color:"#FFFFFF"},
		titleBar:{titleBar_height:30}
	});
	
	$('.shangjia .fenlei2 ul li a').hover(function(){
        $('.shangjia .fenlei2 ul li').removeClass('fontL');
		$(this).parent('li').addClass('fontL');
		var cid=$(this).parent('li').attr('cid');
		ajaxMall(cid,20);
	});
	
	$('.leimu .kuang01').keyup(function(){
	    var val=$(this).val();
		if(val!=''){
		    ajaxMall(val,20);
		}
	});
	dd=setTimeout("shengSlider=new slider({id:'gundong'});",3000);
	
	$(".biaoti").each(function(){
    	$(this).find('li:last').attr('id','fontf');
 	});
});

function aa(){
	if("undefined" != typeof shengSlider){
		clearInterval(dd);
		if(shengSlider.stop==1){
			dd=setTimeout("shengSlider=new slider({id:'gundong'});",3000);
		}
	}
}

function bb(){
	if("undefined" != typeof shengSlider){
		shengSlider.stop=1;
	}
	else{
	    shengSlider = new Object();
		shengSlider.stop=1;
	}
}

function H$(i) {return document.getElementById(i)}
function H$$(c, p) {return p.getElementsByTagName(c)}
var slider = function () {
	function inits (o) {
		this.id = o.id;
		this.at = o.auto ? o.auto : 3;
		this.o = 0;
		this.stop=o.stop?o.stop:0;
		this.pos();
	}
	inits.prototype = {
		pos : function () {
			clearInterval(this.__b);
			if(this.stop==1) return false;
			this.o = 0;
			var el = H$(this.id), li = H$$('li', el), l = li.length;
			var _t = li[l-1].offsetHeight;
			var cl = li[l-1].cloneNode(true);
			cl.style.opacity = 0; cl.style.filter = 'alpha(opacity=0)';
			el.insertBefore(cl, el.firstChild);
			el.style.top = -_t + 'px';
			this.anim();
		},
		anim : function () {
			var _this = this;
			this.__a = setInterval(function(){_this.animH()}, 20);
		},
		animH : function () {
			var _t = parseInt(H$(this.id).style.top), _this = this;
			if (_t >= -1) {
				clearInterval(this.__a);
				H$(this.id).style.top = 0;
				var list = H$$('li',H$(this.id));
				H$(this.id).removeChild(list[list.length-1]);
				this.__c = setInterval(function(){_this.animO()}, 20);
				//this.auto();
			}else {
				var __t = Math.abs(_t) - Math.ceil(Math.abs(_t)*.07);
				H$(this.id).style.top = -__t + 'px';
			}
		},
		animO : function () {
			this.o += 20;
			if (this.o == 100) {
				clearInterval(this.__c);
				H$$('li',H$(this.id))[0].style.opacity = 1;
				H$$('li',H$(this.id))[0].style.filter = 'alpha(opacity=100)';
				this.auto();
			}else {
				H$$('li',H$(this.id))[0].style.opacity = this.o/100;
				H$$('li',H$(this.id))[0].style.filter = 'alpha(opacity='+this.o+')';
			}
		},
		auto : function () {
			var _this = this;
			this.__b = setInterval(function(){_this.pos()}, this.at*1000);
		}
   }
	return inits;
}();
</script>
<div class="mainbody">
<div class="mainbody1000"> 
<?=AD(1)?>
<?php include(TPLPATH.'/inc/top2.tpl.php');?>
<div class="mainleft">
  <div class="jiaodian">
    <div id="KinSlideshow" style="visibility:hidden;">
      <?php foreach($slides as $row){?>
      <a href="<?=$row['url']?>" target="_blank"><img src="<?=$row['img']?>" alt="<?=$row['title']?>" width="740" height="280" /></a>
      <?php }?>
    </div>
</div>
<div class="leimu">
<div class="leimutop">
<div class="biaoti2"><h3>返现商家</h3> </div>
<div class="search23"><div id="searchtu2"><input class="kuang01" type="text" /></div><div id="searchtu"><img alt="搜索" src="<?=TPLURL?>/images/search02.gif" style=" width:23px; height:23px" /></div></div>


</div>

<div class="kong01">&nbsp;</div>
<div class="shangjia">
<div class="fenlei2"><ul>
<li class="fontL" cid='0'><a href="javascript:;">最热商城</a></li>
<?php $i=0; foreach($mall_type as $id=>$title){$i++;if($i==15){break;}?>
<li cid='<?=$id?>'><a href="javascript:;"><?=$title?></a></li>
<?php if($i==13) break; }?>
</ul></div> 
<div class="zhanshi"><ul>
<?php foreach($malls as $i=>$row){?>
<li <?php if($i<$taoshop_num){?> class="tb"<?php }?>><div class="pailie"><a target="_blank" href="<?=$row['url']?>"><img <?php if($i<$taoshop_num){?> onerror="this.src='images/tbdp.gif'"<?php }?> src="<?=$row['img']?>" alt="<?=$row['title']?>" /></a>  <p>最高返 | <span><?=$row['fan']?></span></p></div></li>
<?php }?>
</ul></div> </div>

</div>
</div>
<div class="mainright">
<div class="gonggao">
<h3><?=WEBNICK?>欢迎您</h3> 
<div class="userinfo">
<div class="nologin" style="display:none">
<div style=" width:205px; float:left">
<form action="<?=u('user','login')?>" method="post">
<table border="0" >
  <tr>
    <td height="40">账号：</td>
    <td><input type="text" class="ddinput" name="username" style="width:150px" /></td>
  </tr>
  <tr>
    <td height="40">密码：</td>
    <td><input type="password"  class="ddinput" name="password" style="width:150px"/></td>
  </tr>
  <tr>
    <td></td>
    <td><div style="float:left"><div class="img-button "><p><input type="submit" name="sub" value="登 陆"></p></div></div><div style="float:left; margin-left:4px; padding-top:4px"><label><input name="remember" id="remember" style="vertical-align:middle" type="checkbox" checked="checked" value="1" />记住我</label> <a href="<?=u('user','register')?>">注册</a></div><div style="clear:both"></div></td>
  </tr>
</table>
</form>
</div>
<div style="float:left; width:25px; padding-top:8px;">
  <?php foreach($apps as $k=>$row){if($k==5){break;}?>
          <div style="margin-bottom:5px"><A href="<?=u('api',$row['code'],array('do'=>'go'))?>"><img style="width:16px; height:16px" alt='使用<?=$row['title']?>帐号登录' title="使用<?=$row['title']?>帐号登录" src="<?=TPLURL?>/images/login/<?=$row['code']?>_1.gif" /></A></div>
          <?php }?>
</div>
<div style="clear:both"></div>
</div>
<div class="logined" style="display:none">
<div class="avatar">
  <div class="aborder">
    <a href="<?=u('user','avatar')?>"><img alt="<?=$dduser['name']?>" src="<?=a($dduser['id'])?>" /></a>
  </div>
</div>
<div class="xinxi">
<div><b>欢迎您：</b>&nbsp;&nbsp;<span class="name"><?=$dduser['name']?></span></div>
<div><b>账户余额：</b>&nbsp;&nbsp;<span class="money"><?=$dduser['money']?></span> 元</div>
<div><b>账户积分：</b>&nbsp;&nbsp;<span class="jifen"><?=$dduser['jifen']?></span></div>
</div>
<div style="clear:both; height:10px"></div>

<div style="float:left"><div class="img-button "><p><input type="submit" onclick="location.href='<?=u('user','index')?>'" name="sub" value="会员中心"></p></div></div>
<div style="float:left; margin-left:20px"><div class="img-button "><p><input type="submit" onclick="location.href='<?=u('user','exit')?>'" name="sub" value="退出登录"></p></div></div>
<div style="clear:both"></div>
</div>
</div>
<script>
$.ajax({
	url: "<?=u('ajax','userinfo')?>",
	type: "POST",
	dataType:'json',
	success: function(userInfo){
		if(userInfo.s==1){
			$('.mainright .userinfo .nologin').hide();
			$logined=$('.mainright .userinfo .logined');
			$logined.find('.avatar img').attr('src',userInfo.user.avatar).attr('alt',userInfo.user.name);
			$logined.find('.xinxi .name').html(userInfo.user.name);
			$logined.find('.xinxi .money').html(userInfo.user.money);
			$logined.find('.xinxi .jifen').html(userInfo.user.jifen);
			$logined.show();
		}
		else{
			$('.mainright .userinfo .nologin').show();
		}
	}
});
</script>
</div>

<div class="zixun"><h3>网站公告</h3> 
<ul>
<?php foreach($article_3 as $row){?>
<li><a title="<?=$row['title']?>" target="_blank" href="<?=u('article','view',array('id'=>$row['id']))?>"><?=$row['title']?></a></li>
<?php }?>
</ul> </div>
<div class="shenqian"> <h3>大家正在省</h3> 
<div class="jCarouselLite" style="position:relative; height:484px; overflow:hidden">
<ul id="gundong" style="position:absolute">
<?php foreach($dingdaning as $row){?>
<li><p><?=$row['name']?> 刚省了<span id="fontd"> <?=$row['fxje']?> 元</span> <br> <span><a onmouseover="bb();" onmouseout='aa();' style="display:block" target="_blank" href="<?=$row['gourl']?>"><?=$row['item_title']?></a></span><br>  
<span id="fonte">返利 <?=$row['commission_rate']?> %</span></p><a href="<?=$row['gourl']?>" target="_blank"><img style="width:65px; height:65px" alt="<?=$row['item_title']?>" src="<?=$row['img']?>" /></a></li>
<? }?>
<div style="clear:both"></div>
</ul>
</div>
</div>
</div>

<div class="hotsale">
<div class="biaoti"><h3><?=$tpl['category'][0]?></h3> 
<ul>
<?php foreach($tpl['info'][0] as $row){?>
<?php if($row['word']!=''){?>
<li><a <?php if($row['b']==1){?> class="b" <?php }?> target="_blank" href="<?=u('tao','list',array('cid'=>0,'q'=>$row['word']))?>"><?=$row['word']?></a></li>
<?php }?>
<?php }?>
</ul>
</div>
<div class="tuwen01"><ul>
<?php foreach($tao_goods as $k=>$row){?>
<li><a target="_blank" href="<?=$row['gourl']?>"><?=html_img($row["pic_url"],2,$row["name"])?></a> <p style="height:55px"><a target="_blank" href="<?=$row['gourl']?>"><?=$row["name"]?></a></p>
<p>淘宝价:<span id="fontd"> ￥<?=$row['price']?></span> 元</p><p>  可返现:<span id="fontg"> ￥<?=$row['fxje']?></span> 元</p> </li>
<?php }?>
</ul></div>
</div>

<?php if($webset['paipai']['open']==1){?>
<div class="hotsale">
<div class="biaoti"><h3><?=$tpl['category'][1]?></h3> 
<ul>
<?php foreach($tpl['info'][1] as $row){?>
<?php if($row['word']!=''){?>
<li><a <?php if($row['b']==1){?> class="b" <?php }?> target="_blank" href="<?=u('paipai','list',array('q'=>$row['word']))?>"><?=$row['word']?></a></li>
<?php }?>
<?php }?>
</ul>
</div>
<div class="tuwen01"><ul>
<?php foreach($paipai_goods as $k=>$row){?>
<li><a target="_blank" href="<?=$row['jump']?>"><?=html_img($row["middleImg"],0,$row["title"])?></a> <p style="height:55px"><a target="_blank" href="<?=$row['jump']?>"><?=$row["title"]?></a></p>
<p>拍拍价:<span id="fontd"> ￥<?=$row['price']?></span> 元</p><p>  可返现:<span id="fontg"> ￥<?=$row['fxje']?></span> 元</p> </li>
<?php }?>
</ul></div>
</div>
<?php }?>

<div class="hotsale">
<div class="biaoti"><h3><?=$tpl['category'][2]?></h3> 
<ul>
<?php foreach($tpl['info'][2] as $row){?>
<?php if($row['word']!=''){?>
<li><a target="_blank" href="<?=u('tao','zhe',array('q'=>$row['word']))?>"><?=$row['word']?></a></li>
<?php }?>
<?php }?>
</ul>
</div>
<div class="tuwen01"><ul>
<?php foreach($goods as $row){?>
<li><a href="<?=$row['gourl']?>" target="_blank"><?=html_img($row['pic_url'],2,$row['name'])?></a> <p style="height:58px; overflow:hidden"><a href="<?=$row['gourl']?>"><?=$row['name']?></a></p>
<p id="fonth">结束时间:<span id="fontd"> <?=trantime($row['coupon_end_time'])?></span></p> <p>现价:<span id="fontd"> ￥<?=$row['coupon_price']?></span>&nbsp;原价:<span id="fonti"><?=$row['price']?></span> </p><p>  可返现:<span id="fontg"> ￥<?=$row['coupon_fxje']?></span>元</p> </li>
<?php }?>
</ul></div>

</div>

<?php if(!empty($baobei)){?>
<div class="fenxiang">
<div class="biaoti"><h3><?=$tpl['category'][3]?></h3> 
<ul>
<?php foreach($tpl['info'][3] as $row){?>
<?php if($row['word']!=''){?>
<li><a target="_blank" href="<?=u('baobei','list',array('cid'=>0,'q'=>$row['word']))?>"><?=$row['word']?></a></li>
<?php }?>
<?php }?>
</ul>
</div>
<div class="tuwen01"><ul>
<?php foreach($baobei as $row){?>
<li><a target="_blank" href="<?=u('baobei','view',array('id'=>$row['id']))?>"><img alt="<?=$row['title']?>" src="<?=$row['img']?>" /></a> <p style="height:36px; overflow:hidden"><a target="_blank" href="<?=u('baobei','view',array('id'=>$row['id']))?>"><?=$row['title']?></a></p>
<p id="fonth"><img alt="喜欢" id="xihuan" src="<?=TPLURL?>/images/xihuan.gif" /><span id="fontd"> <?=$row['hart']?></span></p> </li>
<?php }?>
</ul></div>
</div>
<?php }?>

<?php if($webset['tuan']['open']==1){?>
<div class="tuangouk">
<div class="biaoti"><h3><?=$tpl['category'][4]?></h3> 
<ul>
<?php foreach($tpl['info'][4] as $row){?>
<?php if($row['word']!=''){?>
<li><a target="_blank" href="<?=u('tuan','list',array('cid'=>0,'q'=>$row['word']))?>"><?=$row['word']?></a></li>
<?php }?>
<?php }?>
</ul>
</div>
<div class="tuwen01"><ul>
<?php foreach($tuan_goods as $row){?>
<li><div class="tuanpic"><a target="_blank" href="<?=u('tuan','view',array('id'=>$row['id']))?>"><img src="<?=$row['img']?>" alt="<?=$row['title']?>" /></a></div><p style="height:36px; overflow:hidden"><a target="_blank" href="<?=u('tuan','view',array('id'=>$row['id']))?>"><?=$row['title']?></a></p>
<p id="fonth">团购价:<span id="fontd"> <?=$row['price']?></span>元 <span id="zhekou"><?=$row['rebate']?>折</span></p> <p>  最高返:<span id="fontg"> <?=$row['fan']?></span></p> <p><a target="_blank" href="<?=u('tuan','view',array('id'=>$row['id']))?>"><img alt="查看详情" src="<?=TPLURL?>/images/tuan.gif" name="tuanimg" width="106" height="32" border="0" id="tuanimg" /></a></p>
</li>
<?php }?>
</ul></div>
</div>
<?php }?>

<div class="links">
<div class="linksbiaoti"><h3>&nbsp;</h3> </div>
<div class="links01"> <ul><li><h3>友情链接:</h3></li>
<?php foreach($yqlj as $row){?>
<li><a href="<?=$row['url']?>" target="_blank"><?=$row['title']?></a></li>
<?php }?>
</ul></div>
<div class="linksline"> <img alt="间隔线" src="<?=TPLURL?>/images/line02.gif" style="width:900px; height:10px" /></div>
<div class="links02"> <ul><li><h3>合作伙伴:</h3></li>
<?php foreach($hzhb as $row){?>
<li><a href="<?=$row['url']?>" target="_blank"><img alt="<?=$row['title']?>" style="width:95px; height:33px" src="<?=$row['img']?>" /></a></li>
<?php }?>
</ul></div>
<div style="clear:both"></div>
</div>
<div class="cleandd"></div>

</div>
</div>
<?php include(TPLPATH.'/footer.tpl.php');?>