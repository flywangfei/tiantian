<?php
$css[]=TPLURL.'/css/usercss.css';
$css[]='css/qqFace.css';
include(TPLPATH."/header.tpl.php");
$shai_tip=array(0=>'<b class="shai" style="cursor:pointer; font-weight:normal">晒单</b>',1=>'<b style=" color:#5DDC4A; font-weight:normal">已晒单</b>');
?>
<script>
function checkTradelist(){
    var q=document.getElementById('q').value;
	if(q=='输入订单号' || q==''){
	    alert('订单号不能为空');
		return false;
	}
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
                <div class="admin_searchx">
                <form action="index.php" onsubmit="return checkTradelist()">
                <input type="hidden" name="mod" value="user" /><input type="hidden" name="act" value="tradelist" />
                  <input class="admin_searchx_input1" type="text" id="q" name="q" value=" 输入订单号" onclick="this.value=''" />
                  <select name="do" style="margin-left:10px;font-size:12px;"><option value="lost">淘宝订单</option><option value="paipailost">拍拍订单</option><option value="malllost">商城订单</option></select><input class="admin_searchx_b" type="submit" value="查找遗漏订单" style="margin-left:10px; font-size:12px;" /></form>
                </div>
                <div class="admin_xfl">
                    <ul>
                    <li id="taobao"><a href="<?=u('user','tradelist',array('do'=>'taobao'))?>">我的淘宝订单</a> </li>
                    <li id="paipai"><a href="<?=u('user','tradelist',array('do'=>'paipai'))?>">我的拍拍订单</a> </li>
                    <li id="mall"><a href="<?=u('user','tradelist',array('do'=>'mall'))?>">我的商城订单</a> </li>
                    <li id="checked"><a href="<?=u('user','tradelist',array('do'=>'checked'))?>">待审核订单</a> </li>
                    </ul>
              	</div>
                <script>
          $('.admin_xfl ul #<?=$do?>').addClass('admin_xfl_xz');
          </script>
                <div class="admin_table">
                    <table width="770" border="0" cellpadding="0" cellspacing="1">
                    <?php if($do=='taobao'){?>
                      <tr>
                        <th width="120" height="26">订单号</th>
                        <th>宝贝名称</th>
                        <th width="73">金额</th>
                        <th width="59">返现</th>
                        <th width="80">成交时间</th>
                        <th width="43">操作</th>
                      </tr>
                      <?php foreach ($dingdan as $r){?>
                      <tr>
                        <td height="33"><?=$r["trade_id"]?></td>
                        <td><?=$r["item_title"]?></td>
                        <td><?=$r["pay_price"]?></td>
                        <td><?=round($r["fxje"],2)?></td>
                        <td><?=date('Y-m-d',strtotime($r["pay_time"]))?></td>
                        <?php if($duoduo->no_pay_trade($r["pay_time"],$r["fxje"])==1){?>
                        <td><span style="color:#F00">未结算</span></td>
                        <?php }elseif($r["pay_time"]>=$webset['baobei']['shai_s_time']){?>
                        <td trade_id='<?=$r["id"]?>' iid='<?=$r["num_iid"]?>'><?=$shai_tip[$r["baobei_id"]?1:0]?></td>
                        <?php }else{?>
                        <td>--</td>
                        <?php }?>
                      </tr>
                      <?php }?>
                    <?php }?>
                    
                    <?php if($do=='lost'){?>
                      <tr>
                        <th width="120" height="26">订单号</th>
                        <th>宝贝名称</th>
                        <th width="60">金额</th>
                        <th width="60">返现</th>
                        <th width="80">成交时间</th>
                        <th width="80">找回订单</th>
                      </tr>
                      <?php foreach ($dingdan as $r){?>
                      <tr>
                        <td height="33"><?=$r["trade_id"]?></td>
                        <td><?=$r["item_title"]?></td>
                        <td><?=$r["pay_price"]?></td>
                        <td><?=round($r["fxje"],2)?></td>
                        <td><?=date('Y-m-d',strtotime($r["pay_time"]))?></td>
                        <td><a href="<?=u('user','confirm',array('do'=>'tao',id=>$r["id"]))?>"><img src="images/queren.gif" width="86" height="20" title="我要确认这份订单" border=0 /></a></td>
                      </tr>
                      <?php }?>
                    <?php }?>
                    
                    <?php if($do=='checked'){?>
                      <tr>
                        <th width="120" height="26">订单号</th>
                        <th>宝贝名称</th>
                        <th width="60">金额</th>
                        <th width="60">返现</th>
                        <th width="80">成交时间</th>
                      </tr>
                      <?php foreach ($dingdan as $r){?>
                      <tr>
                        <td height="33"><?=$r["trade_id"]?></td>
                        <td><?=$r["item_title"]?></td>
                        <td><?=$r["pay_price"]?></td>
                        <td><?=round($r["fxje"],2)?></td>
                        <td><?=date('Y-m-d',strtotime($r["pay_time"]))?></td>
                      </tr>
                      <?php }?>
                    <?php }?>
                    
                    <?php if($do=='paipai'){?>
                      <tr>
                        <th width="120" height="26">订单号</th>
                        <th>宝贝名称</th>
                        <th width="73">金额</th>
                        <th width="43">数量</th>
                        <th width="59">返现</th>
                        <th width="80">成交时间</th>
                        
                      </tr>
                      <?php foreach ($dingdan as $r){?>
                      <tr>
                        <td height="33"><?=$r["dealId"]?></td>
                        <td><?=$r["commName"]?></td>
                        <td><?=$r["careAmount"]?></td>
                        <td><?=$r["commNum"]?></td>
                        <td><?=$r["fxje"]?></td>
                        <td><?=date('Y-m-d',$r["chargeTime"])?></td>
                      </tr>
                      <?php }?>
                    <?php }?>
                    
                    <?php if($do=='paipailost'){?>
                      <tr>
                        <th width="120" height="26">订单号</th>
                        <th>宝贝名称</th>
                        <th width="60">金额</th>
                        <th width="60">返现</th>
                        <th width="80">成交时间</th>
                        <th width="80">找回订单</th>
                      </tr>
                      <?php foreach ($dingdan as $r){?>
                      <tr>
                        <td height="33"><?=$r["dealId"]?></td>
                        <td><?=$r["commName"]?></td>
                        <td><?=$r["careAmount"]?></td>
                        <td><?=$r["fxje"]?></td>
                        <td><?=date('Y-m-d',$r["chargeTime"])?></td>
                        <td><a href="<?=u('user','confirm',array('do'=>'paipai',id=>$r["id"]))?>"><img src="images/queren.gif" width="86" height="20" title="我要确认这份订单" border=0 /></a></td>
                      </tr>
                      <?php }?>
                    <?php }?>
                    
                    <?php if($do=='mall'){?>
                      <tr>
                        <th height="26">订货号</th>
                        <th width="120">下单商城</th>
                        <th width="80">成交数量</th>
                        <th width="60">单价</th>
                        <th width="120">返现</th>
                        <th width="150">成交时间</th>
                        <th width="100">交易状态</th>
                      </tr>
                      <?php foreach ($dingdan as $r){?>
                      <tr>
                        <td height="33"><?=$r["order_code"]?></td>
                        <td><?=$r["mall_name"]?></td>
                        <td><?=$r["item_count"]?></td>
                        <td><?=$r["item_price"]?></td>
                        <td><?=$r["fxje"]?></td>
                        <td><?=date('Y-m-d H:i:s',$r["order_time"])?></td>
                        <td><?=$status_arr[$r["status"]]?></td>
                      </tr>
                      <?php }?>
                    <?php }?>
                    
                    <?php if($do=='malllost'){?>
                      <tr>
                        <th height="26">订货号</th>
                        <th width="120">下单商城</th>
                        <th width="80">成交数量</th>
                        <th width="60">单价</th>
                        <th width="120">返现</th>
                        <th width="150">成交时间</th>
                        <th width="100">找回订单</th>
                      </tr>
                      <?php foreach ($dingdan as $r){?>
                      <tr>
                        <td height="33"><?=$r["order_code"]?></td>
                        <td><?=$r["mall_name"]?></td>
                        <td><?=$r["item_count"]?></td>
                        <td><?=$r["item_price"]?></td>
                        <td><?=$r["fxje"]?></td>
                        <td><?=date('Y-m-d H:i:s',$r["order_time"])?></td>
                        <td><a href="<?=u('user','confirm',array('do'=>'mall',id=>$r["id"]))?>"><img src="images/queren.gif" width="86" height="20" title="我要确认这份订单" border=0 /></a></td>
                      </tr>
                      <?php }?>
                    <?php }?>
                    </table>
                    <?php if($total==0){?>
                    <div style="margin-top:25px; text-align:center">暂无数据</div>
                    <?php }?>
                </div>
                <div class="megas512" style="clear:both"><?=pageft($total,$pagesize,u(MOD,ACT,array('do'=>$do)));?></div>
                
                <div class="adminright_yuye">
                    <div class="tishitubiao"></div>
                    <?php if($do=='taobao'){?>
                    <p>亲！淘宝订单需要确认收货后，<?=WEBNICK?>最晚隔天会收到数据反馈！</p>
                    <?php }elseif($do=='mall'){?>
                    <p>亲！商城订单大约需要2个月才会核对有效，请耐心等待！</p>
                    <?php }elseif($do=='paipai'){?>
                    <p>亲！拍拍订单需要确认收货后，<?=WEBNICK?>最晚隔天会收到数据反馈！</p>
                    <?php }?>
                </div>
                
                <?php if($do=='taobao' && ($webset['taoapi']['freeze']==2 || $webset['taoapi']['freeze']==1)){?>
                <?php if($webset['taoapi']['freeze_limit']>0){$w='返利大于'.$webset['taoapi']['freeze_limit'].'元';}?>
                <div class="adminright_yuye">
                    <div class="tishitubiao"></div>
                    <?php if($webset['taoapi']['freeze']==2){?>
                    <p>亲！16天内<?=$w?>的淘宝订单处于未核对状态。</p>
                    <?php }elseif($webset['taoapi']['freeze']==1){?>
                    <p>亲！每月<?=$webset['taoapi']['auto_jiesuan']?>日统一结算上个月<?=$w?>的淘宝订单！</p>
                    <?php }?>
                </div>
                <?php }?>
            </div>
    	</div>
  </div>
</div>
<?php
include(TPLPATH."/baobei/share.tpl.php");
include(TPLPATH."/footer.tpl.php");
?>