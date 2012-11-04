// JavaScript Document

function setPic(pic,width,height,alt,classname,onerrorPic){
	pic =  decode64(pic);
	writestr = "<img src='"+pic+"' ";
	if(width!=0){
		writestr+=" width="+width;
	}
	if(height!=0){
		writestr+=" height="+height;
	}
	writestr = writestr+" alt='"+alt+"' onerror='this.src=\""+onerrorPic+"\"' class='"+classname+"' />";
	document.write(writestr);
}

function selAll(obj){
    $(obj).attr("checked",'true');//全选
}
function selNone(obj){
    $(obj).removeAttr("checked");//取消全选
}
function selfan(obj){
    $(obj).each(function(){
		if($(this).attr("checked")){
			$(this).removeAttr("checked");
		}
		else{
		    $(this).attr("checked",'true');
		}
	})
}

function parse_str(url){
    if(url.indexOf('?')>-1){
        u=url.split("?");
		var param1 = u[1];
    }else{
        var param1 = url;
    }
	var s = param1.split("&");
    var param2 = {};
    for(var i=0;i<s.length;i++){
       var d=s[i].split("=");
       eval("param2."+d[0]+" = '"+d[1]+"';");
    }
	return param2;
}

/*var arr = [];  
for(i in param2){  
   arr.push( i + "=" + param2[i]); //根据需要这里可以考虑escape之类的操作  
}  
alert(arr.join("&")) */ 

function postForm(action,input){
	var postForm = document.createElement("form");//表单对象
    postForm.method="post" ;
    postForm.action = action ;
	var k;
    for(k in input){
		if(input[k]!=''){
			var htmlInput = document.createElement("input");
			htmlInput.setAttribute("name", k) ;
            htmlInput.setAttribute("value", input[k]);
            postForm.appendChild(htmlInput) ;
		}
	}
	document.body.appendChild(postForm) ;
	//alert(document.body.innerHTML)
    postForm.submit() ;
    document.body.removeChild(postForm) ;
}

function u(mod,act,arr,wjt){
	if(!arguments[2]){
	    var arr = new Array();
	}
	if(!arguments[3]){
	    wjt=0;
	}
	var mod_act_url='';
	if(act=='' && mod=='index'){
	    mod_act_url='?';
	}
	else if(act==''){
	    mod_act_url="index.php?mod="+mod+"&act=index";
	}
	else{
		if(wjt==1){
			var str='';
			for(k in arr){
			    str+='-'+arr[k];
			}
		    mod_act_url=mod+'/'+act+str+'.html';
		}
		else{
		    mod_act_url="index.php?mod="+mod+"&act="+act+arr2param(arr);
		}
	}
    return mod_act_url;
}

function arr2param(arr){
	var param='';
	var k;
    for(k in arr){
		if(arr[k]!=''){
		    param+='&'+k+'='+arr[k];
		}
	}
	return param;
}


function getClientHeight()
{
  var clientHeight=0;
  if(document.body.clientHeight&&document.documentElement.clientHeight)
  {
  var clientHeight = (document.body.clientHeight<document.documentElement.clientHeight)?document.body.clientHeight:document.documentElement.clientHeight;   
  }
  else
  {
  var clientHeight = (document.body.clientHeight>document.documentElement.clientHeight)?document.body.clientHeight:document.documentElement.clientHeight;   
  }
  return clientHeight;
}


function like(id,htmlId){
	var $t=$("#"+htmlId);
	var user_hart=parseInt($t.text());
	$.ajax({
	    url: u('ajax','like'),
		type: "POST",
		data:{'id':id},
		dataType: "json",
		success: function(data){
			if(data.s==0){
			    alert(errorArr[data.id]);
			}
			else if(data.s==1){
			    $t.text(user_hart+1);
			}
		 }
	});
}


String.prototype.Trim = function() 
{ 
    return this.replace(/(^\s*)|(\s*$)/g, ""); 
} 


//////右下角帮助
function miaovAddEvent(oEle, sEventName, fnHandler)
{
	if(oEle.attachEvent)
	{
		oEle.attachEvent('on'+sEventName, fnHandler);
	}
	else
	{
		oEle.addEventListener(sEventName, fnHandler, false);
	}
}
function helpWindows(word,title)
{
	$('#miaov_float_layer').remove();
	$("body").append('<div class="float_layer" id="miaov_float_layer"><h2><strong>'+title+'</strong><a id="btn_min" href="javascript:;" class="min"></a><a id="btn_close" href="javascript:;" class="close"></a></h2><div class="content"><div class="wrap">'+word+'</address></div></div></div>');
	var oDiv=document.getElementById('miaov_float_layer');
	var oBtnMin=document.getElementById('btn_min');
	var oBtnClose=document.getElementById('btn_close');
	var oDivContent=oDiv.getElementsByTagName('div')[0];
	
	var iMaxHeight=0;
	
	var isIE6=window.navigator.userAgent.match(/MSIE 6/ig) && !window.navigator.userAgent.match(/MSIE 7|8/ig);
	
	oDiv.style.display='block';
	iMaxHeight=oDivContent.offsetHeight;
	
	if(isIE6)
	{
		oDiv.style.position='absolute';
		repositionAbsolute();
		miaovAddEvent(window, 'scroll', repositionAbsolute);
		miaovAddEvent(window, 'resize', repositionAbsolute);
	}
	else
	{
		oDiv.style.position='fixed';
		repositionFixed();
		miaovAddEvent(window, 'resize', repositionFixed);
	}
	
	oBtnMin.timer=null;
	oBtnMin.isMax=true;
	oBtnMin.onclick=function ()
	{
		startMove
		(
			oDivContent, (this.isMax=!this.isMax)?iMaxHeight:0,
			function ()
			{
				oBtnMin.className=oBtnMin.className=='min'?'max':'min';
			}
		);
	};
	
	oBtnClose.onclick=function ()
	{
		oDiv.style.display='none';
	};
};

function startMove(obj, iTarget, fnCallBackEnd)
{
	if(obj.timer)
	{
		clearInterval(obj.timer);
	}
	obj.timer=setInterval
	(
		function ()
		{
			doMove(obj, iTarget, fnCallBackEnd);
		},30
	);
}

function doMove(obj, iTarget, fnCallBackEnd)
{
	var iSpeed=(iTarget-obj.offsetHeight)/8;
	
	if(obj.offsetHeight==iTarget)
	{
		clearInterval(obj.timer);
		obj.timer=null;
		if(fnCallBackEnd)
		{
			fnCallBackEnd();
		}
	}
	else
	{
		iSpeed=iSpeed>0?Math.ceil(iSpeed):Math.floor(iSpeed);
		obj.style.height=obj.offsetHeight+iSpeed+'px';
		
		((window.navigator.userAgent.match(/MSIE 6/ig) && window.navigator.userAgent.match(/MSIE 6/ig).length==2)?repositionAbsolute:repositionFixed)()
	}
}

function repositionAbsolute()
{
	var oDiv=document.getElementById('miaov_float_layer');
	var left=document.body.scrollLeft||document.documentElement.scrollLeft;
	var top=document.body.scrollTop||document.documentElement.scrollTop;
	var width=document.documentElement.clientWidth;
	var height=document.documentElement.clientHeight;
	
	oDiv.style.left=left+width-oDiv.offsetWidth+'px';
	oDiv.style.top=top+height-oDiv.offsetHeight+'px';
}

function repositionFixed()
{
	var oDiv=document.getElementById('miaov_float_layer');
	var width=document.documentElement.clientWidth;
	var height=document.documentElement.clientHeight;
	
	oDiv.style.left=width-oDiv.offsetWidth+'px';
	oDiv.style.top=height-oDiv.offsetHeight+'px';
}

//操作cookie

function addCookie(name,value,expires,path,domain){
 var str=name+"="+escape(value);
 if(expires!=""){
  var date=new Date();
  date.setTime(date.getTime()+expires);//expires单位为秒
  str+=";expires="+date.toGMTString();
 }
 if(path!=""){
  str+=";path="+path;//指定可访问cookie的目录
 }
 if(domain!=""){
  str+=";domain="+domain;//指定可访问cookie的域
 }
 document.cookie=str;
}
//取得cookie
function getCookie(name){
    var str=document.cookie.split(";")
    for(var i=0;i<str.length;i++){
        var str2=str[i].split("=");
		str2[0]=str2[0].Trim();
        if(str2[0]==name){
		    return unescape(str2[1]);
	    }
    }
}
//删除cookie
function delCookie(name){
 var date=new Date();
 date.setTime(date.getTime()-10000);
 document.cookie=name+"=n;expire="+date.toGMTString();
}

//图片自适应大小
function imgAuto(img, maxW, maxH) {
	var oriImg = document.createElement("img");
	oriImg.onload = function(){oriImg.height
		if (oriImg.width == 0 || oriImg.height == 0)
			return;
		var oriW$H = oriImg.width / oriImg.height;
		//var maxW$H = maxW / maxH;

		if (oriImg.height > maxH) {
			img.style.height = maxH;
			// img.removeAttribute("width");
			img.style.width = maxH * oriW$H;
		}
		if (img.width > maxW) {
			img.style.width = maxW;
			// img.removeAttribute("height");
			img.style.height = maxW / oriW$H;
		}

		if (maxH) {// if it defined the maxH argument
			if (img.height > 0)
				img.style.marginTop = (maxH - img.height) / 2 + "px";
		}
	};
	oriImg.src = img.src;
	img.style.display="block";
}


function ajaxPost(url,query){
	var type='json';
	if(arguments[2] ==1){
	    type='post';
	}
	var test=arguments[2];
	$.ajax({
	    url: url,
		type: "POST",
		data:query,
		dataType:type,
		success: function(data){
			if(test ==1){
			    alert(data);
			}
			
		    if(data.s==0){
			    alert(errorArr[data.id]);
			}
			else if(data.s==1){
			    alert('保存成功');
				location.replace(location.href);
			}
		}
	});
}

function ajaxPostForm(form){
	var query=$(form).serialize();
	var url=$(form).attr('action');
	var type='json';
	var word=arguments[2];
	var goto=arguments[1];
	if(typeof word=='undefined') word='';
	if(typeof goto=='undefined') goto='';
	$.ajax({
	    url: url,
		type: "POST",
		data:query,
		dataType:'json',
		success: function(data){//alert(data);
		    if(data.s==0){
			    alert(errorArr[data.id]);
			}
			else if(data.s==1){
				if(word!=''){
				    alert(word);
				}
				if(goto !=''){
	                window.location.href=goto;
					return false;
	            }
				
				if(typeof data.g=='undefined' || data.g=='' || data.g==0){
				    location.replace(location.href);
				}
				else{
				    window.location.href=data.g;
				}
			}
		},
		error: function(XMLHttpRequest,textStatus, errorThrown){
			//alert(XMLHttpRequest.status);
            //alert(XMLHttpRequest.readyState);
			//alert(textStatus);
        }
	});
}

function checkForm(t){
    var subm=1;
	$(t).find('.required').each(function(){
		var word=$(this).attr('word');
		var num=$(this).attr('num');
		var val=$(this).val();
		if(typeof word=='undefined'){word='';}
		if(val=='' || val==word){
			$(this).focus().css('border','1px #F00 dotted');
			if(word!=''){
			    alert(word);
			}
		    else{
			    alert('此字段必填');
			}
			subm=0;
			return false;
		}
		if(num=='y' && isNaN(val)){
			$(this).focus().css('border','1px #F00 dotted');
			alert('这不是一个数字');
			subm=0;
			return false;
		}
    }).blur(function(){
	    if($(this).val()!=''){
		    $(this).removeClass('red_border');
		}
	}); 
	if(subm==0){
		return false;
	}
	else{
	    return true;
	}
}

function http_pic(pic){
    if(pic.indexOf("http://")>=0){
	    return pic;
	}
	else{
	    return '../'+pic;
	}
}

function inArray(val,array){
	for(var i in array){
	    if(array[i]==val){
		    return val;
		}
	}
	return '';
}

function backToTop(){
    var $backToTopTxt = "返回顶部";
	var $backToTopEle = $('<div class="backToTop"></div>').appendTo($("body")).text($backToTopTxt).attr("title", $backToTopTxt).click(function() {$("html, body").animate({ scrollTop: 0 }, 120);});
	var $backToTopFun = function() {
        var st = $(document).scrollTop(), winh = $(window).height();
        (st > 0)? $backToTopEle.show(): $backToTopEle.hide();
        //IE6下的定位
        if (!window.XMLHttpRequest) {
            $backToTopEle.css("top", st + winh - 166);
        }
    };
    $(window).bind("scroll", $backToTopFun);
    $backToTopFun();
}

function domStop(id) {  //id外围需要一个position:relative的元素定位，id最好不要有css，只起到单纯的定位作用
	var IO = document.getElementById(id),Y = IO,H = 0,IE6;
	IE6 = window.ActiveXObject && !window.XMLHttpRequest;
	while (Y) {
		H += Y.offsetTop;
		Y = Y.offsetParent
	};
	if (IE6) {
		IO.style.cssText = "position:absolute;top:expression(this.fix?(document" + ".documentElement.scrollTop-(this.javascript||" + H + ")):0)";
	} else {
		IO.style.cssText = "top:0px";
	}

	window.onscroll = function() {
		var d = document,
		s = Math.max(d.documentElement.scrollTop, document.body.scrollTop);
		if (s > H && IO.fix || s <= H && !IO.fix) return;
		if (!IE6) IO.style.position = IO.fix ? "": "fixed";
		IO.fix = !IO.fix;
	};
	try {
		document.execCommand("BackgroundImageCache", false, true)
	} catch(e) {};
}

function regEmail(email){
    var reg = /^[-_A-Za-z0-9\.]+@([_A-Za-z0-9]+\.)+[A-Za-z0-9]{2,3}$/;
    if(reg.test(email)){
	    return true;
	}else{    
        return false;    
    } 
}

function regMobile(str){    
    if(/^1\d{10}$/g.test(str)){      
        return true;    
    }else{    
        return false;    
    }    
} 

function regAlipay(str){
    if(regMobile(str) || regEmail(str)){
	    return true;
	}else{    
        return false;    
    }
}

function regQQ(qq){
    if((!isNaN(str) && str.length.length>4 && str.length.length<15) || regEmail(str)){
	    return true;
	}else{    
        return false;    
    }
}

function fixDiv(div_id,offsetTop){
	var offset=arguments[1]?arguments[1]:0;
    var Obj=$('#'+div_id);
	var w=Obj.width();
    var ObjTop=Obj.offset().top;
    var isIE6=$.browser.msie && $.browser.version == '6.0';
    if(isIE6){
        $(window).scroll(function(){
			if($(window).scrollTop()<=ObjTop){
                    Obj.css({
                        'position':'relative',
                        'top':0
                    });
            }else{
                Obj.css({
                    'position':'absolute',
                    'top':$(window).scrollTop()+offsetTop+'px',
                    'z-index':1
                });
            }
        });
    }else{
        $(window).scroll(function(){
            if($(window).scrollTop()<=ObjTop){
                Obj.css({
                    'position':'relative',
					'top':0
                });
            }else{
                Obj.css({
                    'position':'fixed',
                    'top':0+offsetTop+'px',
					'z-index':1,
					'width':w+'px',
					'overflow':'hidden'
                });
            }
        });
    }
}

function debugObjectInfo(obj) {
    traceObject(obj);

    function traceObject(obj) {
        var str = '';
        if (obj.tagName && obj.name && obj.id) str = "<table border='1' width='100%'><tr><td colspan='2' bgcolor='#ffff99'>traceObject 　　tag: &lt;" + obj.tagName + "&gt;　　 name = \"" + obj.name + "\" 　　id = \"" + obj.id + "\" </td></tr>";
        else {
            str = "<table border='1' width='100%'>";
        }
        var key = [];
        for (var i in obj) {
            key.push(i);
        }
        key.sort();
        for (var i = 0; i < key.length; i++) {
            var v = new String(obj[key[i]]).replace(/</g, "&lt;").replace(/>/g, "&gt;");
            str += "<tr><td valign='top'>" + key[i] + "</td><td>" + v + "</td></tr>";
        }
        str = str + "</table>";
        writeMsg(str);
    }
    function trace(v) {
        var str = "<table border='1' width='100%'><tr><td bgcolor='#ffff99'>";
        str += String(v).replace(/</g, "&lt;").replace(/>/g, "&gt;");
        str += "</td></tr></table>";
        writeMsg(str);
    }
    function writeMsg(s) {
        traceWin = window.open("", "traceWindow", "height=600, width=800,scrollbars=yes");
        traceWin.document.write(s);
    }
}

function fenduan(val,arr,level){
    for(var k in arr){
        if(level>=k){
			return Math.round(val*arr[k] * 100) / 100;
		}
    }
    return Math.round(val*arr[k] * 100) / 100;
}