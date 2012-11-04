<?php include(ADMINTPL.'/header.tpl.php');?>
<style>
.tuan{ display:none}
</style>
<script>
lmArr=new Array();
<?php foreach($lianmeng as $k=>$arr){?>
lmArr[<?=$k?>]=new Array();
lmArr[<?=$k?>]['title']='<?=$arr['title']?>';
lmArr[<?=$k?>]['code']='<?=$arr['code']?>';
lmArr[<?=$k?>]['helpurl']='<?=$arr['helpurl']?>';
<?php }?>
function getPinyin(){
    var title=$('#title').val();
	$.post('../<?=u('ajax','pinyin')?>',{title:title},function(data){
	    $('#pinyin').val(data);
	});
}

function openwinx(url,name,w,h)
{
	api_city=$('#api_city').val();
	id=$('#id').val();
	if(api_city==''){
	    alert('城市api连接不能为空');
	}
	else if(id==''){
	    alert('保存商城后从新打开再生成城市api');
	}
	else{
	    window.open(url,name,"top=100,left=400,width=" + w + ",height=" + h + ",toolbar=no,menubar=no,scrollbars=yes,resizable=no,location=no,status=no");
	}
}

function b(){
	<?php foreach($lianmeng as $k=>$arr){?>
    $('.<?=$arr['code']?>_tr').hide();
	<?php }?>
}

function c(lm){
    b();
	$('.'+lmArr[lm]['code']+'_tr').show();
	if(lm=='1'){
		$('#chanetfun').show();
	}
	else{
		$('#chanetfun').hide();
	}
}

$(function(){
	var lm = $('#lm').val();
	var catname = $('#cid').find("option:selected").text();
	if(catname.indexOf("团购")>=0){
		$('.tuan').show();
	}
	c(lm);
    $('#lm').change(function(){
	    var lm = $(this).val();
		$(this).next('a').attr('href',lmArr[lm]['helpurl']);
		c(lm);
	});
	$('#cid').change(function(){
	    catname=$(this).find("option:selected").text();
		if(catname.indexOf("团购")>=0){
		    $('.tuan').show();
		}
		else{
		    $('.tuan').hide();
		}
	});
	$('#tiqu').click(function(){
	    var url=$('#yiqifaurl').val();
		if(url==''){
		    alert('亿起发推广链接还未填写');
		}
		else{
		    var a= url.match(/&c=(\d+)&/);
		    $('#yiqifaid').val(a[1]);
		}
		return false;
	});
	
	$('#chanet_draftid_button').click(function(){
	    var url=$('#url').val();
		if(url==''){
			alert('网址必须填写');
			$('#url').focus();
		}
		else if($('#lm').val()!='1'){
		    alert('请选择成果联盟');
		}
		else{
			$(this).attr('disabled','disabled');
			var button=$(this);
			$.ajax({
                url: '../<?=u('ajax','chanet',array('do'=>'get_info'))?>',
				data:{url:url},
                type: 'POST',
                dataType: 'json',
                error: function(XMLHttpRequest,textStatus, errorThrown){
                    alert('链接不通');
					//alert(XMLHttpRequest.status);
                 //alert(XMLHttpRequest.readyState);
				 //alert(textStatus);
					$('#showmall a').html('<b style=" font-weight:blod; color:red">查看全部</b>');
					return false;
                },
                success: function(data){
					button.attr('disabled','');
					if (typeof  data.url=='undefined' || data==null){
					    alert('无此商城信息');
					    $('#showmall a').html('<b style=" font-weight:blod; color:red">查看全部</b>');
					    return false;
					}
					else{
					    $('#url').val(data.url);
						$('#title').val(data.title);
						getPinyin();
						$('#fan').val(data.fan);
						$('#chanet_draftid').val(data.chanet_draftid);
						$('#chanetid').val(data.chanetid);
						$('#img').val(data.img);
						$('#edate').val(data.edate);
						$('#cid').val(data.cid);
						if($('#des').val()==''){
						    $('#des').val(data.des);
						}
						var c=editor.html().replace('<p>','').replace('</p>','').replace('&nbsp;',''); //编辑器人为清空还会有残留代码
						c=$.trim(c);
						if(c==''){
						    editor.html(data.content);
						}
					}
                }
            });
		}
	});
});

function tSubmit(form){
	var lm = $('#lm').val();
	if(form.name.value==''){
		alert('请填写商城名！');
		form.name.focus();
		return false;
	}
	if(form.fan.value==''){
		alert('请填写最高返现额度！');
		form.fan.focus();
		return false;
	}
	if(form.logo.value==''){
		alert('请上传商城logo！');
		form.logo.focus();
		return false;
	}
	if(form.url.value==''){
		alert('请填写商城官网！');
		form.url.focus();
		return false;
	}
	if(lm=='linktech'){
	    if(form.merchant.value==''){
		    alert('请填写广告主账号！');
		    form.merchant.focus();
		    return false;
	    }
	}
	else if(lm=='yiqifa'){
	    if(form.yilink.value==''){
		    alert('请填写推广链接！');
		    form.yilink.focus();
		    return false;
	    }
        var a= form.yilink.value.match(pattern);
        if(a[1]>0){
		    form.yiqifaid.value=a[1];
		}
		if(form.yiqifaid.value=='' || form.yiqifaid.value==0){
		    alert('请填写亿起发广告id！');
		    form.yiqifaid.focus();
		    return false;
	    }
	}
	else if(lm=='duomai'){
	    if(form.duomaiid.value=='' || form.duomaiid.value==0){
		    alert('请填写多麦广告id！');
		    form.duomaiid.focus();
		    return false;
	    }
	}
	else if(lm=='chanet'){
	    if(form.chanetid.value=='' || form.chanetid.value==0){
		    alert('请填写成果广告id！');
		    form.chanetid.focus();
		    return false;
	    }
		if(form.chanet_draftid.value=='' || form.chanet_draftid.value==0){
		    alert('请填写成果原稿id！');
		    form.chanet_draftid.focus();
		    return false;
	    }
	}
	return true;
}
pattern = /(\w+)=(\w+)/ig;
</script>

<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115px" align="right">名称：</td>
    <td>&nbsp;<input name="title" type="text" onblur="getPinyin()" id="title" value="<?=$row['title']?>"/></td>
  </tr>
  <tr>
    <td align="right">拼音：</td>
    <td>&nbsp;<input name="pinyin" type="text" id="pinyin" value="<?=$row['pinyin']?>"/>&nbsp;<input  class="sub" type="button" value="获取拼音" onclick="getPinyin()" /></td>
  </tr>
  <tr>
    <td align="right">类别：</td>
    <td>&nbsp;<select id="cid" name="cid"><?php getCategorySelect($row['cid']?$row['cid']:$_GET['cid']);?></select></td>
  </tr>
  <tr>
    <td align="right">联盟：</td>
    <td>&nbsp;<?=select($lm,$row['lm'],'lm')?>&nbsp;&nbsp;&nbsp; <a target="_blank" href="<?=$lianmeng[$row['lm']]['helpurl']?>">教程</a></td>
  </tr>
  <tr>
    <td align="right">官网：</td>
    <td>&nbsp;<input name="url" type="text" id="url" value="<?=$row['url']?>" /> <span style="display:none" id="chanetfun"><input type="button" value="获取信息" id="chanet_draftid_button" style="cursor:pointer" />(填写后点击可直接获取商城信息)</span></td>
  </tr>
  <tr>
    <td align="right">最高返：</td>
    <td>&nbsp;<input name="fan" type="text" id="fan" value="<?=$row['fan']?>" /> 前台显示，不参与返利计算</td>
  </tr>
  <tr>
    <td align="right">返利形式：</td>
    <td>&nbsp;<?=html_radio(array(1=>'金额',2=>'积分'),$row['type']==''?1:$row['type'],'type')?> </td>
  </tr>
  <tr>
    <td align="right">排序：</td>
    <td>&nbsp;<input name="sort" type="text" id="sort" value="<?=$row['sort']?>" /> 数字越大越靠前</td>
  </tr>
  
  <tr class="duomai_tr">
    <td align="right">多麦广告主id：</td>
    <td>&nbsp;<input name="duomaiid" type="text" value="<?=$row['duomaiid']?>" id="duomaiid" /> 如选择多麦网，此项必填</td>
  </tr>
  
  <tr class="yiqifa_tr">
    <td align="right">亿起发推广网址：</td>
    <td>&nbsp;<input onblur="if(this.value==''){return false;}var a= this.value.match(pattern);if(a[1]>0){form.yiqifaid.value=a[1];}" name="yiqifaurl" type="text" style="width:300px" id="yiqifaurl" value="<?=$row['yiqifaurl']?>" /> 如选择亿起发网，此项必填</td>
  </tr>
  <tr class="yiqifa_tr">
    <td align="right">亿起发广告主id：</td>
    <td>&nbsp;<input name="yiqifaid" type="text" value="<?=$row['yiqifaid']?>" id="yiqifaid" /> <button id="tiqu">提取广告主id</button> 如选择亿起发，此项必填</td>
  </tr>
  <tr class="yiqifa_tr">
    <td align="right">亿起发商家分类id：</td>
    <td>&nbsp;<input name="merchantId" type="text" value="<?=$row['merchantId']?>" id="merchantId" /> 亿起发api使用</td>
  </tr>
  
  <tr class="linktech_tr">
    <td align="right">领客特广告主账号：</td>
    <td>&nbsp;<input name="merchant" type="text" value="<?=$row['merchant']?>" id="merchant" /> 如选择领克特，此项必填</td>
  </tr>
  
  <tr class="chanet_tr">
    <td align="right">成果原稿id：</td>
    <td>&nbsp;<input name="chanet_draftid" type="text" value="<?=$row['chanet_draftid']?>" id="chanet_draftid" /> 如选择成果网，此项必填 <span id='showmall'><a href="http://v8.duoduo123.com/getchanet.php?act=all" target="_blank">查看全部</a></span></td>
  </tr>
  <tr class="chanet_tr">
    <td align="right">成果广告主id：</td>
    <td>&nbsp;<input name="chanetid" type="text" value="<?=$row['chanetid']?>"  id="chanetid" /> 如选择成果网，此项必填</td>
  </tr>
  <tr class="chanet_tr">
    <td align="right">成果广告主链接：</td>
    <td>&nbsp;<input name="chaneturl" type="text" value="<?=$row['chaneturl']?>" id="chanetid" /> 选填，如果此商城为团购网站并且采集团购商品，此项必填</td>
  </tr>
  
  <tr>
    <td align="right">logo：</td>
    <td>&nbsp;<input name="img" type="text" id="img" value="<?=$row['img']?>" style="width:300px" /> <input class="sub" type="button" value="上传图片" onclick="javascript:openpic('<?=u('fun','upload',array('uploadtext'=>'img','sid'=>session_id()))?>','upload','450','350')" /> 可直接添加网络地址</td>
  </tr>
  <tr>
    <td align="right">简介：</td>
    <td>&nbsp;<input name="des" type="text" id="des" value="<?=$row['des']?>" style="width:300px" /></td>
  </tr>
  <tr>
    <td align="right">服务：</td>
    <td>&nbsp;<input name="fuwu" type="text" id="fuwu" value="<?=$row['fuwu']?>" style="width:300px" /></td>
  </tr>
  <tr>
    <td align="right">到期时间：</td>
    <td>&nbsp;<input name="edate" type="text" id="edate" style="width:100px" value="<?=$row['edate']?>" /> </td>
  </tr>
  
  <tr>
    <td align="right">网站认证：</td>
    <td>&nbsp;<label><input type="radio" name="renzheng" value="1" <?php if($row['renzheng']==='1' || $row['renzheng']==''){?> checked="checked" <?php }?> />是</label> <label><input type="radio" name="renzheng" value="0" <?php if($row['renzheng']==='0'){?> checked="checked" <?php }?> />否</label></td>
  </tr>
  <tr>
    <td align="right">网站活动：</td>
    <td>&nbsp;<a href="<?=u('huodong','list',array('mall_id'=>$id))?>">查看活动</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?=u('huodong','addedi',array('mall_id'=>$id))?>">添加活动</a></td>
  </tr>
  
  <tr class="tuan">
    <td align="right">商品api规则：</td>
    <td>&nbsp;<input name="api_rule" type="text" id="api_rule" value="<?=$row['api_rule']?>"/> 如：baidu/hao123（baidu和hao123是一样的），360</td>
  </tr>
  <tr class="tuan">
    <td align="right">商品api：</td>
    <td>&nbsp;<input name="api_url" type="text" id="api_url" value="<?=$row['api_url']?>" style="width:300px" /></td>
  </tr>
  <tr class="tuan">
    <td align="right">城市api：</td>
    <td>&nbsp;<input name="api_city" type="text" id="api_city" value="<?=$row['api_city']?>" style="width:300px" />&nbsp;<a style="color:#F30" href="javascript:openwinx('index.php?mod=mall&act=addedi&mallid=<?=$row['id']?>&rule=<?=$row['api_rule']?>&api_city=<?=urlencode($row['api_city'])?>','upload','450','350')">生成城市缓存</a></td>
  </tr>
  
  <tr>
    <td align="right">介绍：</td>
    <td>&nbsp;<textarea id="content" name="content"><?=$row['content']?></textarea></td>
  </tr>
  
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="id" value="<?=$row['id']?>" /><input type="submit" class="sub" name="sub" value=" 保 存 " /></td>
  </tr>
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>