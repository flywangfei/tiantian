<?php
$css[]=TPLURL.'/css/article.css';
include(TPLPATH."/header.tpl.php");
?>
<div class="mainbody">
<div class="mainbody1000">
<div class="fuleft">
	<div class="news_list">
    	<div class="news_list_bt"><?=$catname?></div>
        <ul>
        <?php foreach($list as $row){?>
        <li><a href="<?=u('article','view',array('id'=>$row['id']))?>"><?=$row['title']?></a><span><?=date('m-d',$row['addtime'])?></span></li>
        <?php }?>
        </ul>
        <div ><div class="megas512"><?=pageft($total,$pagesize,$page_url,WJT)?></div></div>
    </div>
    
</div>
<div class="furight">
<?php include TPLPATH."/article/right.tpl.php";?>
</div>

</div>
</div>
<?php include TPLPATH."/footer.tpl.php";?>
