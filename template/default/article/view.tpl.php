<?php
$css[]=TPLURL.'/css/article.css';
include(TPLPATH."/header.tpl.php");
?>
<div class="mainbody">
<div class="mainbody1000">
<div class="fuleft">
	<div class="news_txt1">
    	<div class="news_txt_bt1"><h1><?=$article['title']?></h1><div style="margin-top:5px; padding-bottom:5px"><span>发布时间：<?=date('Y-m-d H:i:s',$article['addtime'])?>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;来源：<?=$article['source']?$article['source']:WEBNICK?>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;点击：<?=$article['hits']?></span></div></div>
        <div class="news_txt_txt1"><?=$article['content']?></div>
        <div class="news_txt_links">
        <ul>
        <li><span>上一篇：</span><a href="<?=u('article','view',array('id'=>$last_article['id']))?>"><?=$last_article['title']?$last_article['title']:'没有了'?></a></li>
        <li><span>下一篇：</span><a href="<?=u('article','view',array('id'=>$next_article['id']))?>"><?=$next_article['title']?$next_article['title']:'没有了'?></a></li>
        </ul>
        </div>
    </div>
    
</div>
<div class="furight">
<?php include TPLPATH."/article/right.tpl.php";?>
</div>

</div>
</div>
<?php 
include(TPLPATH."/footer.tpl.php");
?>