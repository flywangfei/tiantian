<!DOCTYPE html PUBliC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<meta name="author" content="duoduo123.com" />
<?php if($webset['qq_meta']!=''){echo $webset['qq_meta']."\r\n";}?>
<?php if(is_file(DDROOT.'/data/title/'.$mod.'_'.$act.'.title.php')){?>
<?php include(DDROOT.'/data/title/'.$mod.'_'.$act.'.title.php');?>
<?php }else{?>
<title><?=TITLE?></title>
<meta name="keywords" content="<?php echo WEBNAME;?>" />
<meta name="description" content="<?php echo WEBNAME;?>" />
<?php }?>
<script src="http://a.tbcdn.cn/apps/top/x/sdk.js?appkey=<?=$webset['taoapi']['jssdk_key']?>"></script>
<?php if(isset($webset['static'][MOD][ACT]) && $webset['static'][MOD][ACT]==1){?>
<script>
var siteUrl='<?=SITEURL?>';
var curlUrl='http://'+document.domain+'<?=URLMULU?>';
if(curlUrl!=siteUrl){
	window.location.href=siteUrl;
}
</script>
<?php }?>
<base href="<?php define('CURURL',"http://".$_SERVER['HTTP_HOST'].URLMULU);echo CURURL;?>/" />
<?php
$css[]="css/jumpbox.css";
$css[]="css/helpWindows.css";
$css[]="css/kefu.css";
$css[]=TPLURL."/css/hf.css";
$css[]=TPLURL."/css/common.css";
echo css($css);

$js[]=TPLURL.'/js/jquery.js';
$js[]=TPLURL.'/js/fun.js';
$js[]='js/base64.js';
$js[]='data/error.js';
$js[]='data/noWordArr.js';
$js[]='js/fun.js';
$js[]='js/jumpbox.js';
if($webset['taoapi']['s8']==1){
	$js[]=TPLURL.'/js/taokey.js';
}
echo js($js);
?>
</head>

<body>
<div class="container">
  <div class="top">
    <div class="top1000">
      <div class="topleft" style="display:none">
        <div class="topleftA">您好，欢迎来到<?=WEBNICK?>！  请<a href="<?=u('user','login')?>">登录</a> / <a href="<?=u('user','register')?>">免费注册</a> <?php if($app_show==1){?>或使用<?php }?></div>
        <?php if($app_show==1){?>
        <div class=loginWays onmouseover=showLogin() onmouseout=showLogin()>
          <SPAN id=weibo_login class=firstWay>
            <A style="CURSOR: pointer" href="<?=u('api',$apps[0]['code'],array('do'=>'go'))?>"><img style="width:16px; height:16px" alt="用<?=$apps[0]['code']?>号登录" src="<?=TPLURL?>/images/login/<?=$apps[0]['code']?>_1.gif"><?=$apps[0]['title']?>登陆</A><SPAN class=icon-down></SPAN>
          </SPAN>
        <div style="DISPLAY: none" id=menu_weibo_login class=pw_menu>
        <ul style="WIDTH: 118px" class=menuList>
          <?php foreach($apps as $k=>$row){?>
          <li><A href="<?=u('api',$row['code'],array('do'=>'go'))?>"><img style="width:16px; height:16px" alt='使用<?=$row['title']?>帐号登录' src="<?=TPLURL?>/images/login/<?=$row['code']?>_1.gif" /><?=$row['title']?>帐户登录</A></li>
          <?php }?>
        </ul>
      </div>
    </div>
    <?php }?>
  </div>
<script id="jshtml" type="text/duoduo">
<div class=loginWays1 onmouseover=showHide('menu_usernav') onmouseout=showHide('menu_usernav')>
          <SPAN>
            我的账户<img src="<?=TPLURL?>/images/downarrow.gif" alt="箭头" />
          </SPAN>
          <div id=menu_usernav>
            <div class="wode">我的账户<img src="<?=TPLURL?>/images/toparrow.gif" alt="箭头" /></div>
            <ul>
              <li><A href="<?=u('user','tradelist')?>">我的订单管理</A></li>
              <li><A href="<?=u('user','mingxi')?>">我的账户明细</A></li>
              <li><A href="<?=u('user','tuiguang')?>">我要推广赚钱</A></li>
              <li><A href="<?=u('user','info')?>">我的账户设置</A></li>
            </ul>
          </div>
        </div>
		<div class"fl" style=" margin-top:10px">|&nbsp;&nbsp;&nbsp;<a href="<?=u('user','exit')?>">退出</a></div>
</script>
<script>
var topHtml='<div class="topleftA" style="padding-top:10px;">账户：<a href="<?=u('user')?>">{name}</a> <a href="<?=u('user','msg')?>">{msgsrc}</a>&nbsp;&nbsp;|&nbsp;&nbsp;余额：<a href="<?=u('user','mingxi')?>">￥{money}</a>&nbsp;&nbsp;|&nbsp;&nbsp;</div>';
$.ajax({
	url: "<?=u('ajax','userinfo')?>",
	type: "POST",
	dataType:'json',
	success: function(data){
		if(data.s==1){
			topHtml=topHtml.replace('{name}',data.user.name);
			topHtml=topHtml.replace('{money}',data.user.money);
			topHtml=topHtml.replace('{msgsrc}',data.user.msgsrc);
			topHtml+=$('#jshtml').html();
			$('.container .topleft').html(topHtml).show();
		}
		else{
			$('.container .topleft').show();
		}
	}
});
</script>
  <div class="topright"> 
    <ul>
      <li> <a href="<?=u('help','index')?>">网站帮助</a>   </li>
      <li> <a href="javascript:;" onClick="AddFavorite('<?=SITEURL?>','<?=WEBNICK?>')">收藏本站</a> </li>  
      <li> <a href="comm/shortcut.php">快捷桌面 </a></li>     
      <li id="fonta"> <a href="<?=u('sitemap','index')?>">淘宝分类 </a></li>  
    </ul>
  </div>
</div>
</div>
<div class="search">
<div class="search1000">

<div class="logo">

  <a href="<?=SITEURL?>"><img src="<?=LOGO?>" alt="<?=WEBNAME?>" /></a></div>

<div class="searchR"><div class='searchbox' id="searchbox">
<div style="TEXT-AliGN: left;">
<div class=s-nav>
  <a class="y" value="输入您想要的淘宝商品网址" mod="tao" act="view" name="q">淘宝</a>
  <?php if($webset['paipai']['open']==1){?>
  <a class="n" value="输入商品名称或者商品网址" mod="paipai" act="list" name="q">拍拍</a>
  <?php }?>
  <?php if($webset['yiqifaapi']['open']==1){?>
  <a class="n" value="输入您想要的商品关键字" mod="mall" act="goods" name="q">比价</a>
  <?php }?>
  <a class="n" value="输入您想找的掌柜" mod="tao" act="shop" name="nick">掌柜</a>
  <a class="n" value="输入您想要的商城" mod="mall" act='list' name="q">商城</a> 
  <a class="n" value="输入您想看的宝贝" mod="baobei" act='list' name="q">宝贝</a>
  <?php if($webset['tuan']['open']==1){?>
  <a class="n" value="输入您想要的团购" mod="tuan" act='list' name="q">团购</a>
  <?php }?>
 </div>
<div class=clear></div>
<FORM style="FLOAT: left" class='box' method='get' name='formname' action='index.php' target="_blank">
<SPAN class=box-middle>
<INPUT id=s-txt class=s-txt onfocus="this.value='';" name='q' value='输入您想要的淘宝商品网址' />
<input type="hidden" id="mod" name="mod" value="tao" class="mod" />
<input type="hidden" id="act" name="act" value="view" class="act"/> 
<input type="hidden" name="search" value="1"/> 
<INPUT class=sbutton type=submit>
</SPAN> 
<SPAN class=box-right></SPAN>
</FORM>
<p></p>
</div>
</div></div></div>
</div>
<div class="daohang">
  <div class="daohang1000">
    <ul class="ulnav">
    <?php 
	$nav_c=count($nav);
	$nav_num=10; //导航个数
	$nav_c=$nav_c>=$nav_num?$nav_num:$nav_c;
	
	for($i=0;$i<$nav_c;$i++){
		$have_child_class='';
	    if ($nav[$i]['tag'] == PAGETAG) {
		    $dom_id = "id='fontc'";
	    } else {
		    $dom_id = "";
	    }
		if(!empty($nav[$i]['child'])){
			$have_child_class=' have_child';
			$em='<em></em>';
		}
		else{
			$have_child_id='';
			$em='';
		}
		if($i==$nav_c-1){
			$lastclass=' last';
		}
		else{
			$lastclass=' ';
		}
	?>
      <li class="linav<?=$have_child_class?><?=$lastclass?>" <?=$dom_id?>> <a <?=$nav[$i]['target']?> class="anav" href="<?=$nav[$i]['link']?>"><?=$nav[$i]['title']?><?=$nav[$i]['type_img']?><?=$em?></a>
      <?php if($em!=''){?>
      <ul class="n-h-list">
        <?php foreach($nav[$i]['child'] as $row){?>
        <li><a <?=$row['target']?> href="<?=$row['link']?>"><?=$row['title']?> <?=$row['alt']?></a> </li>
        <?php }?>
	  </ul>
      <?php }?>
      </li>
    <?php }?>
      
    </ul></div>
</div>
<script>
var i=-1;
var $searchA=$('#searchbox .s-nav a');
$searchA.each(function(index){
    var mod = $(this).attr('mod');
	var act = $(this).attr('act');
	var name = $(this).attr('name');
	var value = $(this).attr('value');
	var text = $(this).text();
	
	if(mod=='<?=MOD?>' && act=='<?=ACT?>'){
	    $searchA.attr('class','n');
		$(this).attr('class','y');
		i=index;
		curMod=mod;
		curAct=act;
		return;
	}
});
if(i>-1){
    $('#searchbox .mod').val('<?=MOD?>');
	$('#searchbox .act').val('<?=ACT?>');
	$('#searchbox #s-txt').val($searchA.eq(i).attr('value'));
	$('#searchbox #s-txt').attr('name',$searchA.eq(i).attr('name'));
}
else{
    $('#searchbox .mod').val('tao');
	$('#searchbox .act').val('view');
}

function reg_url(q){
	var mod=$('#searchbox #mod').val();
	var act=$('#searchbox #act').val();
    if(q.indexOf('http://')<0 && (mod=='tao' && act=='view')){ //不是网址
	var word=inArray(q,noWordArr);
	    if(word!=''){
		    alert('无此商品，请更换其他商品查询！');
		    return 2;
		}
		else{
		    return 1;
		}
	}
}

$(function(){
	$(".have_child").hover(function() {
		thisId=$(this).attr('id');
		$(this).attr('id','navc');
        $(this).find("a").eq(0).addClass("sub_on").removeClass("sub");
        $(this).find("ul").show();
    },
    function() {
		if(typeof(thisId) == "undefined"){
			thisId='';	
		}
		$(this).attr('id',thisId);
        $(this).find("a").eq(0).addClass("sub").removeClass("sub_on");
        $(this).find("ul").hide()
    });
	
    $('#searchbox .box').jumpBox({  
		LightBox:'show',
		jsCode:'$content.html($("#searchtip").html());',
		reg:'reg_url($("#s-txt").val())',
		height:250,
		width:555,
		bind:'submit',
		a:1,
		background:'url(images/xiexian.gif) #FFFFFF'
    });
})
</script>