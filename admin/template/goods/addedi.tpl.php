<?php 
include(ADMINTPL.'/header.tpl.php');
$type=array(1=>1,2,3,4,5,6,7,8,9);
?>
<script src="http://a.tbcdn.cn/apps/top/x/sdk.js?appkey=<?=$webset['taoapi']['jssdk_key']?>"></script>
<script src="../comm/jssdk.php"></script>
<script src="../js/md5.js"></script>
<script>
regTaobaoUrl = /(.*\.?taobao.com(\/|$))|(.*\.?tmall.com(\/|$))/i;
function getTaoItem(url){
    if(url==''){
		alert('网址不能为空！');
		return false;
	}
	if (!url.match(regTaobaoUrl)){
		alert('这不是一个淘宝网址！');
		return false;
	}

	$('#shareContain #J_ImgBooth').attr('src','images/wait.gif');
	$.ajax({
	    url: "../<?=u('ajax','getTaoItem')?>",
		type: "POST",
		data:{'url':url,'admin':1},
		dataType: "json",
		success: function(data){
			if(data.s==0){
			    alert(errorArr[data.id]);
			}
			else if(data.s==1){
			    $('#radio'+data.re.cid).attr("checked",true);
	            $('#title').val(data.re.title);
				$('#nick').val(data.re.nick);
	            $('#price').val(data.re.price);
	            $('#pic_url').val(data.re.pic_url);
				$('#iid').val(data.re.tao_id);
				$('#click_url').val(data.re.click_url);
				
				var parame=new Array();
				parame['num_iids']=data.re.num_iid;
				parame['onlyComm']=1;
				taobaoTaobaokeWidgetItemsConvert(parame);
			}
		 }
	});
}
commission=0;
function showCommission(){
	if(commission>0){
		$('#commission').val(commission);
		clearInterval(intervalProcess);
	} 
}
intervalProcess = setInterval("showCommission()", 100);
</script>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<div class="explain-col"> 获取淘宝商品信息，只需填写淘宝网址，点击“获取商品详情”，系统便可自动采集商品信息
  </div>
<br />
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115px" align="right">分类：</td>
    <td>&nbsp;<?=select($type,$row['cid'],'cid')?> 商品分类，用于不同模板的调用</td>
  </tr>
  <tr>
    <td width="115px" align="right">淘宝网址：</td>
    <td>&nbsp;<input type="text" id="url" value="<?=$row['iid']?'http://item.taobao.com/item.htm?id='.$row['iid']:''?>" style="width:300px" /> <input onClick="getTaoItem($('#url').val())" class="sub" type="button" value="获取商品详情" /></td>
  </tr>
  <tr>
    <td width="115px" align="right">标题：</td>
    <td>&nbsp;<input name="title" type="text" id="title" value="<?=$row['title']?>" style="width:300px" /></td>
  </tr>
  <tr>
    <td align="right">图片：</td>
    <td>&nbsp;<input name="pic_url" type="text" id="pic_url" value="<?=$row['pic_url']?>" style="width:300px" /> <input class="sub" type="button" value="上传图片" onclick="javascript:openpic('<?=u('fun','upload',array('uploadtext'=>'pic_url','sid'=>session_id()))?>','upload','450','350')" /> 可直接添加网络地址</td>
  </tr>
  <tr>
    <td align="right">商品id：</td>
    <td>&nbsp;<input name="iid" type="text" id="iid" value="<?=$row['iid']?>" /></td>
  </tr>
  <tr>
    <td align="right">价格：</td>
    <td>&nbsp;<input name="price" type="text" id="price" value="<?=$row['price']?>" /></td>
  </tr>
  <tr>
    <td align="right">佣金：</td>
    <td>&nbsp;<input name="commission" type="text" id="commission" value="<?=$row['commission']?>" /></td>
  </tr>
  <tr>
    <td align="right">掌柜：</td>
    <td>&nbsp;<input name="nick" type="text" id="nick" value="<?=$row['nick']?>" /></td>
  </tr>
  <tr>
    <td align="right">商品推广链接：</td>
    <td>&nbsp;<input name="click_url" type="text" id="click_url" value="<?=$row['click_url']?>" style="width:300px" /></td>
  </tr>
  <tr>
    <td align="right">关联会员：</td>
    <td>&nbsp;<input name="uname" type="text" id="uname" value="<?=$row['uid']?$duoduo->select('user','ddusername','id="'.$row['uid'].'"'):''?>"  /> 会员名</td>
  </tr>
  <tr>
    <td align="right">排序：</td>
    <td>&nbsp;<input name="sort" type="text" id="sort" value="<?=$row['sort']?$row['sort']:0?>"  /> 数字越大越靠前</td>
  </tr>
  <!--<tr>
    <td align="right">持续时间：</td>
    <td>&nbsp;<select><?php for($i=1;$i<=30;$i++){?><option value="<?=$i?>"><?=$i?>天<?php }?></select> </td>
  </tr>-->
  <?php if($_POST['sub']!=''){?>
  <tr>
    <td align="right">发布时间：</td>
    <td>&nbsp;<input name="addtime" type="text" id="addtime" value="<?=date('Y-m-d H:i:s',$row['addtime'])?>"  /></td>
  </tr>
  <?php }?>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="id" value="<?=$row['id']?>" /><input type="submit" class="sub" name="sub" value=" 保 存 " /></td>
  </tr>
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>