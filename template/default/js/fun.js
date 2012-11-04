function postForm(action,input){
	var postForm = document.createElement("form");
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
    postForm.submit() ;
    document.body.removeChild(postForm) ;
}

function u(mod,act,arr){
	if(!arguments[2]){
	    var arr = new Array()
	}
	var mod_act_url='';
	if(act=='' && mod=='index'){
	    mod_act_url='?';
	}
	else if(act==''){
	    mod_act_url="?mod="+mod+"&act=index";
	}
	else{
	    mod_act_url="?mod="+mod+"&act="+act+arr2param(arr);
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

function getCookie(name){
 var str=document.cookie.split(";")
 alert(str[0]);
 for(var i=0;i<str.length;i++){
 var str2=str[i].split("=");
  if(str2[0]==name)return unescape(str2[1]);
 }
}

function AddFavorite(sURL, sTitle){
 try{
  window.external.addFavorite(sURL, sTitle);
  }
 catch (e){
  try{
   window.sidebar.addPanel(sTitle, sURL, "");
   }
  catch (e)
  {
   alert("加入收藏失败，您的浏览器不允许，请使用Ctrl+D进行添加");
  }
 }
}

$(function(){
	var input="#s-txt";
	$('.s-nav a').click(function(){
		$('.s-nav a').removeClass().addClass('n');
		$(this).removeClass().addClass('y');
		var mod=$(this).attr('mod');
		var act=$(this).attr('act');
		var $form=$(input).parents('.box');
		$form.find('#mod').val(mod);
		$form.find('#act').val(act);
		$(input).val($(this).attr('value'));
		$(input).attr('name',$(this).attr('name'));
	});
});

function showLogin()
{
    $('#menu_weibo_login').toggle();
}

function showHide(id)
{
    $('#'+id).toggle();
}