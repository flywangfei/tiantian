<?php
$css[]=TPLURL.'/css/usercss.css';
include(TPLPATH."/header.tpl.php");
?>
<script type="text/javascript"> 
    function jsCopy(e){ 
        e.select(); //选择对象 
        document.execCommand("Copy"); //执行浏览器复制命令

       alert("已复制好，可贴粘。"); 
    } 
</script> 

<div class="mainbody">
	<div class="mainbody1000">
    <?php include(TPLPATH."/user/top.tpl.php");?>
    	<div class="adminmain">
        	<div class="adminleft">
                <?php include(TPLPATH."/user/left.tpl.php");?>
            </div>
        	<div class="adminright">
                <?php include(TPLPATH."/user/notice.tpl.php");?>
                <div class="admin_xfl">
                    <ul>
                    <li id="url"><a href="<?=u('user','tuiguang',array('do'=>'url'))?>">我要推广</a> </li>
                    <li id="list"><a href="<?=u('user','tuiguang',array('do'=>'list'))?>">我推广的好友</a> </li>
                    </ul>
                    <script>
                    $(function(){
					    $('.admin_xfl li#<?=$do?>').addClass('admin_xfl_xz');
					})
                    </script>
              	</div>
                <div class="adminright_yuye">
                    <div class="tishitubiao"></div>
                    <p>推广成功的好友，只要他从本站去淘宝购物，您每次都可以获取其返利的<?=$webset['tgbl']*100?>%作为您的推广佣金！</p>
                </div>
                <?php if($do=='list'){?> 
                <div class="admin_table">
                    <table width="770" border="0" cellpadding="0" cellspacing="1">
                      <tr>
                        <th width="167" height="26">用户名</th>
                        <th width="184">已获佣金(仅参考)</th>
                        <th width="162">登录次数</th>
                        <th width="118">会员等级</th>
                        <th width="133">注册时间</th>
                      </tr>
                      <?php foreach($tuiguang as $arr){?>
                      <tr>
                        <td height="33"><?=$arr['ddusername']?></td>
                        <td><?=$arr['yj']?></td>
                        <td><?=$arr['loginnum']?></td>
                        <td><?=$arr['level']?></td>
                        <td><?=$arr['regtime']?></td>
                      </tr>
                      <?php }?>
                    </table>
              </div>
               <div class="megas512" style="clear:both"><?=pageft($total,$pagesize,u(MOD,ACT,array('do'=>$do)))?></div>
              <?php }?>
              <?php if($do=='url'){?>
              <div class="union_link" style="font-size:12px; height:auto;">
     	<DIV class=share_QQ>
<DIV class=share_title></DIV>
<DIV class=share_link>
<H4>这是您的专用邀请链接，请通过 MSN 或 QQ 发送给好友：</H4>
<INPUT class=text value=<?=$webset['tgurl']?>rec=<?=$dduser['id']?> type=text id="recom_qq"> <INPUT class=smt onclick="jsCopy(document.getElementById('recom_qq'))" value=复制推广连接 type=button> 
</DIV></DIV>
<DIV class=share_blog>
<DIV class=share_title></DIV>
<DIV class=share_link>
<H4>在支持HTML的网页（比如论坛、博客），可以复制下列HTML代码：</H4><TEXTAREA id=recom_html class=area>&lt;a href="<?=$webset['tgurl']?>rec=<?=$dduser['id']?>" target="_blank"&gt;<?=WEBNICK?>（淘宝购物返现网）&lt;/a&gt;</TEXTAREA> 
<INPUT class=smt onclick="jsCopy(document.getElementById('recom_html'))" value=复制推广连接 type=button name=button> 
</DIV>
</DIV>
<DIV class=union_share>
<H4>分享推广：</H4>
<UL>
  <LI><A  href="http://v.t.sina.com.cn/share/share.php?title=<?=urlencode("推荐一个省钱网站——#".WEBNICK."#，登录".WEBNICK."后去淘宝网购物后还可返还1.5%至30%的现金 @".WEBNICK." ".TGURL."?rec=".$dduser['id']."")?>&url=http://<?=URL?>" target=_blank><IMG src="<?=TPLURL?>/images/share_01.gif"><BR>新浪微博</A> </LI>
  <LI><A href="http://share.renren.com/share/buttonshare.do?link=http%3A%2F%2F<?=URL?>" target=_blank><IMG src="<?=TPLURL?>/images/share_02.gif" width=49 height=49><BR>人人网</A> </LI>
  <LI><a href="javascript:u=location.href;t='<?=WEBNICK?>';c = %22%22 + (window.getSelection ? window.getSelection() : document.getSelection ? document.getSelection() : document.selection.createRange().text);var url=%22http://cang.baidu.com/do/add?it=%22+encodeURIComponent(t)+%22&iu=%22+encodeURIComponent(u)+%22&dc=%22+encodeURIComponent(c)+%22&fr=ien#nw=1%22;window.open(url,%22_blank%22,%22scrollbars=no,width=600,height=450,left=75,top=20,status=no,resizable=yes%22); void 0"><IMG src="<?=TPLURL?>/images/share_03.gif" width=49 height=49><BR>百度收藏夹</A> </LI>
  <LI><a href=javascript:window.open('http://shuqian.qq.com/post?from=3&title='+encodeURIComponent('<?=WEBNICK?>')+'&uri='+encodeURIComponent('<?=TGURL?>?rec=<?=$dduser['id']?>')+'&jumpback=2&noui=1','favit','');void(0)><IMG src="<?=TPLURL?>/images/share_04.gif" width=48 height=49><BR>QQ书签</A> </LI>
  <LI><A  href="http://www.kaixin001.com/~repaste/repaste.php?rtitle=<?=WEBNICK?>-淘宝返现网站，帮你在淘宝网购物省钱的网站，最高可以节省35%，皇冠信誉保障！&rurl=<?=TGURL?>?rec=<?=$dduser['id']?>" target=_blank><IMG src="<?=TPLURL?>/images/share_05.gif" width=49 height=49><BR>开心网</A> </LI>
  <LI><A  href="http://xianguo.com/service/submitdigg/?title=<?=urlencode("推荐一个省钱网站——#".WEBNICK."#，登录".WEBNICK."后去淘宝网购物后还可返还1.5%至30%的现金 @".WEBNICK." ".TGURL."?rec=".$dduser['id'])?>" target="_blank"><IMG src="<?=TPLURL?>/images/share_06.gif" width=49 height=49><BR>鲜果网</A> </LI>
  <LI><A  href="https://www.google.com/bookmarks/mark?op=edit&bkmk=http%3A%2F%2F<?=URL?>&output=popup&title=<?=urlencode("推荐一个省钱网站——#".WEBNICK."#，登录".WEBNICK."后去淘宝网购物后还可返还1.5%至30%的现金 @".WEBNICK." ".TGURL."?rec=".$dduser['id'])?>"  target=_blank><IMG src="<?=TPLURL?>/images/share_07.gif" width=49 height=49><BR>Google书签</A> </LI>
</UL></DIV>
  </div>
            <?php }?>
            
    	</div>
  </div>
</div>
</div>
<?php
include(TPLPATH."/footer.tpl.php");
?>