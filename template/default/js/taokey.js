$(function(){
	var word = '';
	var timeoutid = null;
	dataUrl="http://suggest.taobao.com/sug?q=";
	screenWidth=document.body.clientWidth;
	addOffset=0;
	bodyWidth=950; //页面宽度
	if(screenWidth>bodyWidth){
	    addOffset=(screenWidth-bodyWidth)/2;
	}
	width=414;  //搜索框长度
	var left=345+addOffset;  //左偏移
	var top=117;  //上偏移
	inputId='s-txt'; //输入框ID
	taobaokeytips='taobaokeytips'; //提示层id
	$('#'+inputId).attr('autocomplete','off');
	$("body").append('<div id="'+taobaokeytips+'"></div>'); //添加容器
    $('#'+taobaokeytips).css('left',left+'px').css('top',top+'px').css('width',width+'px');
	$('body').keydown(function(){
	    if(event.keyCode==13){
		    if($('#'+taobaokeytips).css('display')=='block'){
			    return false;
			}
			else{
			    return true;
			}
		}
	});
	
	$("#"+inputId).keyup(function(event){
		var mod=$('#mod').val();
		var act=$('#act').val();
		if(mod!='tao' || act!='view') return false;
		var neword = $(this).attr("value");
		var myEvent = event || window.event; 
		var keyCode = myEvent.keyCode;                //获得键值
		switch(keyCode){
			case 38 : //按了上键  
				if($("#"+taobaokeytips).css("display") == "block"){       
					var arr = $("#"+taobaokeytips+" li").filter(".current");
					if(arr.length != 0){
						var index = $("#"+taobaokeytips+" li").index(arr[0]);
						switch(index){
							case 0:
								$("#"+inputId).attr("value",word);
								$("#"+taobaokeytips+" li").eq(index).removeClass("current");
							break;
							default:
								$("#"+taobaokeytips+" li").eq(index).removeClass("current");
								$("#"+inputId).attr("value",$("#"+taobaokeytips+" li").eq(index-1).children().eq(0).text());
								$("#"+taobaokeytips+" li").eq(index-1).addClass("current");	
						}
					}
					else{
						$("#"+inputId).attr("value",$("#"+taobaokeytips+" li").eq($("#"+taobaokeytips+" li").length-1).children().eq(0).text());
						$("#"+taobaokeytips+" li").eq($("#"+taobaokeytips+" li").length-1).addClass("current");
					}
				}else{autocomplete()};
				break;
			case 40 : //按了下键
				if($("#"+taobaokeytips).css("display") == "block"){ 
					var arr = $("#"+taobaokeytips+" li").filter(".current");
					if(arr.length != 0){
						var index = $("#"+taobaokeytips+" li").index(arr[0]);
						switch(index){
							case $("#"+taobaokeytips+" li").length-1:
								$("#"+inputId).attr("value",word);
								$("#"+taobaokeytips+" li").eq(index).removeClass("current");
							break;
							default:
								$("#"+taobaokeytips+" li").eq(index).removeClass("current");
								$("#"+inputId).attr("value",$("#"+taobaokeytips+" li").eq(index+1).children().eq(0).text());
								$("#"+taobaokeytips+" li").eq(index+1).addClass("current");	
						}
					}
					else{
						$("#"+inputId).attr("value",$("#"+taobaokeytips+" li").eq(0).children().eq(0).text());
						$("#"+taobaokeytips+" li").eq(0).addClass("current");
					}
				} else { autocomplete() };
				break;
			case 13 : //按了回车
				if($('#'+taobaokeytips).css("display") == "block"){ 
					var arr = $("#"+taobaokeytips+" li").filter(".current");
					if(arr.length != 0){
						var index = $("#"+taobaokeytips+" li").index(arr[0]);
						$("#"+inputId).attr("value",$("#"+taobaokeytips+" li").eq(index).children().eq(0).text());
						$('#'+taobaokeytips).css("display","none");
					};
				}else{if(neword != word)autocomplete()}
				break;
			default:
				if (neword != "" && neword != word) {
					clearTimeout(timeoutid); //取消上次未完成的延时操作					
					//500ms后执行，执行一次
					timeoutid = setTimeout(function(){
						var url = dataUrl + neword + "&code=utf-8&callback=callback"
						var s = document.createElement("script"); 
						s.setAttribute("src", url);
						s.setAttribute("id", "GetOrder");
						document.getElementsByTagName("head")[0].appendChild(s);
						word = neword;
					},300)
				} else { $('#'+taobaokeytips).css("display","none");word = neword; }
		}
	})
	//---------------------------------------------------------------------------------------------
	
	$("body").click(function(){
		setTimeout(function(){$('#'+taobaokeytips).css("display","none")},100)
	})
	function autocomplete(){
		var neword = $("#"+inputId).attr("value");
		var url = dataUrl + neword + "&code=utf-8&callback=callback"
		var s = document.createElement("script"); 
		s.setAttribute("src", url);
		s.setAttribute("id", "GetOrder");
		document.getElementsByTagName("head")[0].appendChild(s);
		word = neword;
		var children = document.getElementById("GetOrder");
		var parent = children.parentNode;
		parent.removeChild(children);
	}
});

function callback(a){
	var key = a.result;
	var keynum = key.length;
	var str = "";
	for (i=0; i<keynum; i++) {
		str += "<li><span>" + key[i][0] + "</span><em>约" + key[i][1] + "件商品</em></li>";
	}
	$('#'+taobaokeytips).html('<ul>'+str+'</ul>');
	if (keynum>0) {
		$('#'+taobaokeytips).css("display","block")
	} else {
		$('#'+taobaokeytips).css("display","none");
	}
	$("#"+taobaokeytips+" li").hover(
		function(){
			$("#"+inputId).focus();
			var arr = $("#"+taobaokeytips+" li").filter(".current");
			if(arr.length != 0){
				var index = $("#"+taobaokeytips+" li").index(arr[0]);
				$("#"+taobaokeytips+" li").eq(index).removeClass("current");
			}
			$(this).addClass("current");	
		},
		function(){
			$(this).removeClass("current");
		}
	);
	$("#"+taobaokeytips+" li").click(function(){
		var th = $(this).children().eq(0).text();
		$("#"+inputId).attr("value",th);
		$('#'+taobaokeytips).css("display","none");
	})
}