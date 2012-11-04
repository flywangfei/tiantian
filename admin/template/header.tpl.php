<?php
no_cache();
$mod_act_name=$duoduo->select('menu','title','`mod`="'.MOD.'" and act="'.ACT.'"');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?=$mod_act_name?></title>
<link href="images/skin.css" rel="stylesheet" type="text/css" />
<link rel=stylesheet type=text/css href="../css/jumpbox.css" />
<link href="../css/lhgcalendar.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../data/error.js"></script>
<script type="text/javascript" src="../js/fun.js"></script>
<script src="../js/jumpbox.js"></script>
<script type="text/javascript" src="../js/lhgcalendar.js"></script>
<script charset="utf-8" src="../kindeditor/kindeditor.js"></script>
<script>
function openpic(url,name,w,h)
{
    window.open(url,name,"top=100,left=400,width=" + w + ",height=" + h + ",toolbar=no,menubar=no,scrollbars=yes,resizable=no,location=no,status=no");
}

//全选/取消
function checkAll(o,checkBoxName){
	var oc = document.getElementsByName(checkBoxName);
	for(var i=0; i<oc.length; i++) {
		if(oc[i].disabled==false){
		    if(o.checked){
				oc[i].checked=true;	
			}else{
				oc[i].checked=false;	
			}
		}
	}
}

function copy(mytext) { 
    window.clipboardData.setData("Text",mytext);
    alert("复制成功");
} 

$(function(){
	
	$('#sday').calendar({format:'yyyyMMdd'}); 
	$('#eday').calendar({format:'yyyyMMdd'});
	
	$('#sdate').calendar({format:'yyyy-MM-dd'}); 
	$('#edate').calendar({format:'yyyy-MM-dd'});
	
	$('#sdatetime').calendar({format:'yyyy-MM-dd HH:mm:ss'});
	$('#edatetime').calendar({format:'yyyy-MM-dd HH:mm:ss'}); 

	if($('#content').length>0){   
		KindEditor.options.filterMode = false;
	    editor = KindEditor.create('#content');
	}
	
    $('#listtable tr').hover(function(){
	    $(this).addClass('trbg');
	},function(){
        $(this).removeClass('trbg');
	});
	$('input[type=text],input[type=password]').addClass('input-text');
	
	$('.showpic').hover(function(){
		var pic=http_pic($(this).attr('pic'));
		$(this).css('position','relative');
	    $(this).html('<img style="position:absolute;display:none;top:-50px;*top:0px; right:0px" src="'+pic+'" onload="imgAuto(this,300,300)"/>' );
	},function(){
		$(this).css('position','static');
	    $(this).html('查看');
	});
	
	$('form[name=form1]').not('.myself').submit(function(){
		var token='<?=$_SESSION['token']?>';
		var method=$(this).attr('method');
		if(method.toLowerCase()=='post'){
			var action=$(this).attr('action');
			if(action=='') action='index.php';
			$(this).attr('action',action+'&token='+token);
		}
		var $sub=$(this).find('input[type=submit]');
	    $sub.attr('disabled','true');
		$sub.val('提交中...');
		$sub.after('<input type="hidden" name="sub" value="1" />');
		return true;
	});
	
})
</script>
</head>
<body style=" min-height:500px">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="17" valign="top" background="images/mail_leftbg.gif"><img src="images/left-top-right.gif" width="17" height="29" /></td>
    <td valign="top" background="images/content-bg.gif"><span class="autol"><span><b><?=$mod_act_name?></b></span><i></i></span></td>
    <td width="16" valign="top" background="images/mail_rightbg.gif"><img src="images/nav-right-bg.gif" width="16" height="29" /></td>
  </tr>
  <tr>
    <td valign="middle" background="images/mail_leftbg.gif">&nbsp;</td>
    <td valign="top" bgcolor="#F7F8F9">