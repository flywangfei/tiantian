<div class="goodslist_main_2" id="splistbox">
                    <ul>
                    <?php foreach($goods as $row) {?>
                        <li class="info">
                            <div class="goodslist_main_left_img_2"><a <?=webtype('rel="nofollow" class="fanlitip"')?> href="<?=$row["gourl"]?>" target="_blank"><?=html_img($row["pic_url"],2,$row["name"],'',160,160)?></a></div>
                        	<div class="goodslist_main_left_bt_2 title"><a target="_blank" <?=webtype('rel="nofollow" class="fanlitip"')?> href="<?=$row["gourl"]?>"><?php echo $row["title"] ?></a></div>
                            <div class="goodslist_main_left_xy_2"><p>卖家信用：<img zhanggui='<?=$row["nick"]?>' alt="等级" src="images/dian.png" align="absmiddle" /></p> </div>
                            <div class="goodslist_main_left_seller_2"><p>卖家：<A href="<?=$row["go_shop"]?>" target=_blank title="逛逛<?=$row["nick"]?>的店铺"><?=$row["nick"]?></a> <?=wangwang($row["nick"],2)?></p>
                            </div>
                            <?php
							$nick_arr[]=$row["nick"];
							?>
                        	<p class="price">淘宝价：<span><?=$row["price"]?></span> 元 </p> 
                            <p id="<?=$row["num_iid"]?>" class="tbcuxiao">淘宝热卖商品</p>
                            <?php
							$iid_arr[]=$row["num_iid"];
							?>
                            <p class="fxje"> 可返现：<span class="greenfont"><?=$row["fxje"]?></span> 元 </p>
                            <div class="goodslist_main_right_tb_2">
                                  <a rel="nofollow" class="fanlitip" href="<?=$row['jump']?>" target="_blank" ><div class="goodslist_main_right_buy">去淘宝购买</div></a><?php if($webset['taoapi']['goods_comment']==1){?>&nbsp;&nbsp; (<a zhangguiid='<?=$row["nick"]?>' url="&auctionNumId=<?=$row["num_iid"]?>" goto="<?=$goods['jump']?>" style="color:#06F; text-decoration:underline; cursor:pointer" class="seecomment">查看评价</a>) <?php }?>
                            </div>
                        </li>  
                     <?php }?> 
                                 
                    </ul>
                </div>	
<?php include(TPLPATH.'/tao/listjs.tpl.php')?>