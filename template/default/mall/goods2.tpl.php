<div class="goodslist_main_2">
                    <ul>
                    <?php foreach($goods as $row) {?>
                        <li class="info">
                            <div class="goodslist_main_left_img_2 pic"><a href="<?=$row["goods_jump"]?>" target="_blank"><?=html_img($row["picurl"],0,$row["productName"],'',160,160)?></a></div>
                        	<div class="goodslist_main_left_bt_2"><a target="_blank" href="<?=$row["goods_jump"]?>"><?php echo $row["productName"] ?></a></div>
                            <div class="goodslist_main_left_xy_2"><p><?=$row['discount']?></p> </div>
                            <div class="goodslist_main_left_seller_2"><p>商家：<a href="<?=$row['mall_jump']?>" target=_blank><?=$row['merchantName']?></a> <?=$row['renzheng']?'<img alt="网站认证" src="'.TPLURL.'/images/renzheng.gif" />':''?></p>
                            </div>
                        	<p class="price">价格：<span><?=$row["showPrice"]?></span> 元 </p> 
                            <p class="fxje">最高返：<span class="greenfont"><?=$row["fan"]?></span></p>
                            <p>市场报价：<?=$row['showRefPrice']>0?'<span style="text-decoration:line-through">'.$row['showRefPrice'].'</span> 元':'暂无'?></p>
                            <div class="goodslist_main_right_tb_2">
                                  <a href="<?=$row['goods_jump']?>" target="_blank" ><div class="goodslist_main_right_buy">去商城购买</div></a>
                            </div>
                        </li>  
                        <?php }?>                
                    </ul>
                </div>	