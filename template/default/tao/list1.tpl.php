<div class="goodslist_main" id="splistbox">
                    <ul>
                    <?php foreach($goods as $row) {?>
                        <li class="info">
                        <div class="goodslist_main_left">
                        	<div class="goodslist_main_left_img"><a class="taopic" <?=webtype('rel="nofollow" class="fanlitip"')?> href="<?=$row["gourl"]?>" target="_blank" pic="<?=base64_encode($row["pic_url"].'_310x310.jpg')?>"><?=html_img($row["pic_url"],1,$row["name"])?></a></div>
                        	<div class="goodslist_main_left_bt title"><a target="_blank" <?=webtype('rel="nofollow" class="fanlitip"')?> href="<?=$row["gourl"]?>"><?php echo $row["title"] ?></a></div>
                            <div class="goodslist_main_left_sell"><p>本期已售出<span><?php echo $row["commission_num"] ?> </span>件 <img zhanggui='<?=$row["nick"]?>' alt="等级" src="images/dian.png" align="absmiddle" /> </p> </div>
                            <div class="goodslist_main_left_seller"><p>卖家：<A href="<?=$row["go_shop"]?>" target=_blank title="逛逛<?=$row["nick"]?>的店铺"><?=$row["nick"]?></a> <?=wangwang($row["nick"])?><?php if($webset['taoapi']['goods_comment']==1){?>&nbsp;&nbsp; (<a zhangguiid='<?=$row["nick"]?>' url="&auctionNumId=<?=$row["num_iid"]?>" goto="<?=$row['jump']?>" style="color:#06F; text-decoration:underline; cursor:pointer" class="seecomment">查看评价</a>) <?php }?></p>
                            </div>
                        </div>
                        <?php
						$nick_arr[]=$row["nick"];
						?>
                        <div class="goodslist_main_right">
                        	<div class="goodslist_main_right_price">
                            <p class="price">淘宝价：<span><?=$row["price"]?></span> 元 </p> 
                            <?php if($row["fxje"]>0){?>
                            <p class="fxje"> 可返现<span class="greenfont"><?=$row["fxje"]?></span> 元 </p> 
                            <?php }else{?>
                            <p> <span class="greenfont">暂无返现</span> </p>
                            <?php }?>
                            <p>&nbsp;<a target="_blank" href="<?=$row["go_view"]?>">详情</a></p>
                            <p id="<?=$row["num_iid"]?>" class="tbcuxiao" style="clear:both; margin-top:5px; width:150px;"></p>
                            <?php
							$iid_arr[]=$row["num_iid"];
							?>
                        	</div>
                            <div style="clear:both"></div>
                            <div class="goodslist_main_right_tb">
                                <a target="_blank" href="<?=u('tao','list',array('cid'=>0,'q'=>$row["name"]))?>"><div class="goodslist_main_right_bj"></div></a>
                                <a target="_blank" class="fanlitip" rel="nofollow" href="<?=$row['jump']?>"><div class="goodslist_main_right_buy">去淘宝购买</div></a>
                            </div>
                        </div>
                        </li>
                    <?php }?>
                    </ul>
                </div>
<?php include(TPLPATH.'/tao/listjs.tpl.php')?>