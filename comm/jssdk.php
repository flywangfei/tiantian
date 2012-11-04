<?php
/**
 * ============================================================================
 * 版权所有 2008-2012 多多网络，并保留所有权利。
 * 网站地址: http://soft.duoduo123.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/

header("Content-type: text/html; charset=utf-8");
error_reporting(0);
define('DDROOT', str_replace(DIRECTORY_SEPARATOR,'/',dirname(dirname(__FILE__))));
include(DDROOT.'/comm/lib.php');

$webset=dd_get_cache('jssdk_set');
$constant=dd_get_cache('constant');
foreach($constant as $k=>$v){
    define($k,$v);
}
define('TIME',$_SERVER['REQUEST_TIME']+$webset['corrent_time']);

$app_key = $webset['key'];/*填写appkey */
$secret=$webset['secret'];/*填入Appsecret'*/
$jssdk_time=TIME."000";
$message = $secret.'app_key'.$app_key.'timestamp'.$jssdk_time.$secret;
$jssdk_sign=strtoupper(hash_hmac("md5",$message,$secret));
set_cookie("timestamp",$jssdk_time);
set_cookie("sign",$jssdk_sign);
?>
JSSDKTIME='<?=$jssdk_time?>';
JSSDKSIGN='<?=$jssdk_sign?>';

GETAGAINTIME=3000; //二次加载时间

CACHEURL='http://<?=$_SERVER['HTTP_HOST'].URLMULU?>/data/temp/taoapi';
SHOPOPEN=<?=$webset['shop_open']?>;
SHOPSLEVEL=<?=$webset['shop_slevel']?>;
SHOPELEVEL=<?=$webset['shop_elevel']?>;
CACHETIME=<?=$webset['cache_time']?>;
ERRORLOG=<?=$webset['errorlog']?>;
SITEURL="http://<?=$_SERVER['HTTP_HOST'].URLMULU?>/";
CHECKCODE='<?=urlencode(authcode($_SERVER['REQUEST_TIME'],'ENCODE'))?>';

function fenduan(val,level){
	<?php
	foreach($webset['fxbl'] as $k=>$v){
		$webset['fxbl'][$k.'a']=$v;
		unset($webset['fxbl'][$k]);
	}
	?>
	<?=php2js_object($webset['fxbl'],'arr');?>
	var re=0;
    for(var k in arr){
    	k=parseInt(k);
        if(level>=k){
        	re=val*arr[k+'a'];
            re=re*100;
  			re=re.toFixed(1);
  			re=Math.round(re)/100; //本来直接用toFixed函数就可以，但是火狐浏览器不行
            break;
		}
    }
    if(re==0){
    	re=val*arr[k];
    	re=re.toFixed(2);
    }
    return re;
}

//小发泄：谷歌（火狐）不支持数组的for in 的形式，只支持对象。如果索引是数字，还会强制从最小的数字开始算第一个，不管你当初是怎么设置的，在IE中这些都不会存在。
//IE显示的js错误随便比较简单，但是很方便，谷歌虽然有控制台，但还是麻烦。毕竟很多人只是需要看一些定义方面的错误提示。
//在IE中，看一个A标签的链接，右键一下很简单，谷歌就费老劲了，由于网速慢图片没显示，IE可以手动二次加载，谷歌就没有。
//一个页面如果是post产生的，谷歌就不能查看其源码了（完全不懂为什么这个都做不到），IE好好的。
//还有好多就不说了，支持IE，虽然你们的第六代儿子给我造成了很多麻烦，虽然你们的第12胎都不一定完全支持css3，但相信你们会越做越好。

net = new Object();
net.READY_STATE_UNINITIALIZED = 0;
net.READY_STATE_LOADING = 1;
net.READY_STATE_LOADED = 2;
net.READY_STATE_INTERACTIVE = 3;
net.READY_STATE_COMPLETE = 4;

net.ContentLoader = function(url, onload, method, params,onerror, contentType) {
	this.req = null;
	this.onload = onload;
	this.onerror = (onerror) ? onerror: this.defaultError;
	this.loadXMLDoc(url, method, params, contentType);
}

net.ContentLoader.prototype = {
	onReadyState: function() {
		var req = this.req;
		var ready = req.readyState;
		if (ready == net.READY_STATE_COMPLETE) {
			var httpStatus = req.status;
			if (httpStatus == 200 || httpStatus == 0) this.onload.call(this);
			else this.onerror.call(this);
		}
	},
	defaultError: function() {
		//alert("error in fetching data!! readyState==" + this.req.readyState + "\n\nstatus=" + this.req.status + " \n\nheaders" + this.req.getAllResponseHeaders());
	}
}

net.ContentLoader.prototype.loadXMLDoc = function(url, method, params, contentType) {
	if (!method) //如果没有传入method 参数值，则默认为GET
	{
		method = "GET";
	}
	if (!contentType && method == "POST") {
		contentType = "application/x-www-form-urlencoded;";
	}

	if (window.XMLHttpRequest) {
		this.req = new XMLHttpRequest();
	} else if (window.ActiveXObject) {
		this.req = new ActiveXObject("Microsoft.XMLHTTP");
	}
	if (this.req) {

		try {
			var loader = this;
			this.req.onreadystatechange = function() {
				loader.onReadyState.call(loader);
			}
			this.req.open(method, url, true);
			//POST方法需要设置的属性
			if (contentType) {
				this.req.setRequestHeader("Content-Type", contentType);
			}
			this.req.send(params);

		} catch(err) {
			this.onerror.call(this);
		}
	}
}

function getMessage(){
	//alert(this.req.responseText);  //简单的输出返回结果的字符串形式
	//alert(this.req.responseXML);   //XML形式，后面就根据你的需要解析这个XML了
}

function getType(o) {
    var _t;
    return ((_t = typeof(o)) == "object" ? o == null && "null" || Object.prototype.toString.call(o).slice(8, -1) : _t).toLowerCase();
}
function extend(destination, source) {
    for (var p in source) {
        if (getType(source[p]) == "array" || getType(source[p]) == "object") {
            destination[p] = getType(source[p]) == "array" ? [] : {};
            arguments.callee(destination[p], source[p]);
        } else {
            destination[p] = source[p];
        }
    }
}

function arrToParam(array){
	var arr=new Array();
	extend(arr,array);
	var param='';
	var k;
    for(k in arr){
		if(arr[k]!=''){
        	arr[k]=encodeURIComponent(arr[k]);
        	if(param!=''){
            	param+='&'+k+'='+arr[k];
            }
		    else{
            	param+=k+'='+arr[k];
            }
		}
	}
	return param;
}

function ErrorLog(method,error_response){
	if(ERRORLOG==1){
    	var errorParame=new Array();
    	errorParame['method']=method;
    	errorParame['code']=error_response.code;
    	errorParame['msg']=error_response.msg;
    	errorParame['url']=document.URL;
		url="comm/jssdk.error.php?"+arrToParam(errorParame);
		js_send(url,1);
    }
}

function js_send(url){
	url=SITEURL+url+'&check='+CHECKCODE;
    var type=arguments[1];
    var method=arguments[2];
    if(type==1){
    	if(method=='POST'){
        	var a=url.split('?');
        	new net.ContentLoader(url,getMessage,'POST',a[1]);
        }
        else{
        	new net.ContentLoader(url,getMessage);
        }
    }
    else{
    	document.write('<s'+'cript src="'+url+'"></script>');
    }
}

function json2str(o) {
	var arr = [];
	var fmt = function(s) {
		if (typeof s == 'object' && s != null) return json2str(s);
		return /^(string|number)$/.test(typeof s) ? "'" + s + "'" : s;
	}
	for (var i in o) arr.push("'" + i + "':" + fmt(o[i]));
	return '{' + arr.join(',') + '}';
}

function getCacheurl(method,parame){
	var temp=new Array();
    switch(method){
    	case 'taobao.taobaoke.widget.items.convert':
        	temp['method']='taobao.taobaoke.widget.items.convert';
            temp['fields']=parame['fields'];
            temp['num_iids']=parame['num_iids'];
        break;
        
        case 'taobao.taobaoke.widget.shops.convert':
        	temp['method']='taobao.taobaoke.widget.shops.convert';
            temp['fields']=parame['fields'];
            temp['seller_nicks']=parame['seller_nicks'];
        break;
    }
    var cacheKey=hex_md5(arrToParam(temp));
    var cacheUrl=CACHEURL+'/'+method+'/'+cacheKey.substr(0,2)+'/'+cacheKey+'.json';
    return cacheUrl;
}

function saveCache(resp,cacheUrl){
	if(CACHETIME>0){
    	var saveCacheUrl='index.php?mod=ajax&act=jssdk_cache&json='+encodeURIComponent(json2str(resp).replace(/'/g,'’‘'))+'&dir='+encodeURIComponent(cacheUrl);
    	js_send(saveCacheUrl,1,'POST'); //缓存文件的url比较长，用post传输
    }
}

/* 
 * 检测对象是否是空对象(不包含任何可读属性)。 //如你上面的那个对象就是不含任何可读属性
 * 方法只既检测对象本身的属性，不检测从原型继承的属性。 
 */
function isOwnEmpty(obj) 
{ 
    for(var name in obj) 
    { 
        if(obj.hasOwnProperty(name)) 
        { 
            return false; 
        } 
    } 
    return true; 
}; 

/* 
 * 检测对象是否是空对象(不包含任何可读属性)。 
 * 方法既检测对象本身的属性，也检测从原型继承的属性(因此没有使hasOwnProperty)。 
 */
function isEmpty(obj) 
{ 
    for (var name in obj)  
    { 
        return false; 
    } 
    return true; 
};

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function taobaoTaobaokeWidgetItemsConvert(parame){
	var method='taobao.taobaoke.widget.items.convert';
    var fields='commission'; //可选字段num_iid,title,nick,pic_url,price,click_url,commission,commission_rate,commission_num,commission_volume,shop_click_url,seller_credit_score,item_location,volume
	var cacheUrl=getCacheurl(method,parame);
    if(typeof parame['fields']!='undefined'){
    	fields=parame['fields'];
    }
    else{
    	parame['fields']=fields;
    }
    
    if(typeof parame['get_num']=='undefined'){
    	parame['get_num']=2;
    }

    if(typeof parame['outer_code']=='undefined'){
    	parame['outer_code']=0;
    }
	
    <?php if($webset['cache_time']>0){?>
    $.ajax({
	   	url: cacheUrl,
		type: "GET",
		dataType:'json',
		success: function(resp){
	    	doItemsConvert(resp,parame);
		},
		error: function(XMLHttpRequest,textStatus, errorThrown){
    <?php }?>
           	var apiParame={method:method, fields:fields,outer_code :parame['outer_code'],num_iids :parame['num_iids'],timestamp:'<?=$jssdk_time?>',sign:'<?=$jssdk_sign?>'};
           	getTopApi(apiParame,parame,cacheUrl);
    <?php if($webset['cache_time']>0){?>
       	}
	});
    <?php }?>
}

function getAgain(apiParame,parame,cacheUrl){
	function foo(){
    	getTopApi(apiParame,parame,cacheUrl);
    	//alert('5秒到时，二次加载');
    };
    if(typeof parame['get_num_error']=='undefined'){
    	parame['get_num_error']=parame['get_num']+1;
    }
    parame['get_num_error']--;
    if(parame['get_num_error']>0){
    	againProcess=setTimeout(foo, GETAGAINTIME);
    	return againProcess;
    }
}

function getTopApi(apiParame,parame,cacheUrl){
    againProcess=getAgain(apiParame,parame,cacheUrl);
	TOP.api('rest','get',apiParame,function(resp){
    	clearInterval(againProcess);
		if(resp){
			if(resp.total_results==0 && parame['get_num']>0){ //增加命中率
            	parame['get_num']--;
            	getTopApi(apiParame,parame,cacheUrl);
                return true; //退出函数，停止以下代码运行
            }
			doItemsConvert(resp,parame);
            if(resp.total_results>0){
            	saveCache(resp,cacheUrl);
            }
        }
		else{
			var error_response={'code':1,'msg':'get fail'}
			ErrorLog(method,error_response);
		}
	});
}

function doItemsConvert(resp,parame){
	if(resp.error_response){
		ErrorLog(parame['method'],resp.error_response);
	}
	else{//debugObjectInfo(resp);
    	if(resp.total_results==0){
        	if(parame['tmall_fxje']>0){
        		ddFxje=parame['tmall_fxje'];
    		}
    		else if(parame['ju_fxje']>0){
        		ddFxje=parame['ju_fxje'];
   			}
            else{
            	ddFxje=0;
            }
        }
        else if(resp.total_results==1){
        	var item=resp.taobaoke_items.taobaoke_item[0];
        	ddClickUrl=item.click_url;
    		commission=item.commission;
        	if(parame['onlyComm']==1){//只获取佣金即可
        	}
    		else{
            	if(parame['ju_fxje']>0){
        			ddFxje=parame['ju_fxje'];
   				}
        		else if(commission>0){
    				commission=commission*parame['promotion_bl'];
					ddFxje=fenduan(commission,parame['user_level']);
    			}
				else if(parame['tmall_fxje']>0){
        			ddFxje=parame['tmall_fxje'];
    			}
        	}
        }
        if(typeof items=='object'){
        	items=resp.taobaoke_items.taobaoke_item;
        }
	}
}

function taobaoTaobaokeWidgetShopsConvert(parame){
	if(typeof parame['admin']=='undefined'){
    	parame['admin']=0;
    }
	if(parame['seller_nicks']=='' || typeof parame['seller_nicks']=='undefined'){
    	return 'miss nick';
    }
	else{
    	var method='taobao.taobaoke.widget.shops.convert';
    	var fields='shop_id,seller_nick,user_id,shop_title,click_url,commission_rate,seller_credit,shop_type,total_auction,auction_count';
    	var cacheUrl=getCacheurl(method,parame);
    	if(typeof parame['fields']!=='undefined'){
    		fields=parame['fields'];
    	}
    	else{
    		parame['fields']=fields;
    	}
    	
        <?php if($webset['cache_time']>0){?>
    	$.ajax({
	    	url: cacheUrl,
			type: "GET",
			dataType:'json',
			success: function(resp){
		    	doShopsConvert(resp,parame);
			},
			error: function(XMLHttpRequest,textStatus, errorThrown){
        <?php }?>
            	var apiParame={method:method, fields:fields,outer_code :parame['outer_code'],seller_nicks :parame['seller_nicks'],timestamp:'<?=$jssdk_time?>',sign:'<?=$jssdk_sign?>'};
            	TOP.api('rest','get',apiParame,function(resp){
                	if(isEmpty(resp)==false){
						doShopsConvert(resp,parame);
                    	saveCache(resp,cacheUrl);
                    }
                    else{
                    	shopsInfo['level']=-1;
                    }
				});
        <?php if($webset['cache_time']>0){?>
        	}
		});
        <?php }?>
    }
}

function doShopsConvert(resp,parame){
	if(resp.error_response){
    	if(parame['admin']==1){
        	alert(resp.error_response.msg);
        }
		ErrorLog(parame['method'],resp.error_response);
	}
    else if(resp.total_results==0){
        
    }
	else{
		var shops=resp.taobaoke_shops.taobaoke_shop;
        //debugObjectInfo(shops[0]);
		for(var i in shops){
    		shopInfo=new Array();
    		shopInfo['seller_nick']=shops[i].seller_nick;
        	shopInfo['user_id']=shops[i].user_id;
    		shopInfo['seller_credit']=shops[i].seller_credit;
    		shopInfo['shop_type']=shops[i].shop_type;
                    
        	if(shopInfo['shop_type']=='B'){
        		shopInfo['level']=21;
        	}
        	else{
            	shopInfo['level']=shopInfo['seller_credit'];
        	}
    
    		if(parame['from']=='list'){
        	}
        	else{
        		shopInfo['auction_count']=shops[i].auction_count;
        		shopInfo['click_url']=shops[i].click_url;
        		shopInfo['commission_rate']=shops[i].commission_rate;
        		if(shopInfo['commission_rate']>0){
        			shopInfo['taoke']=1;
            		shopInfo['fanxianlv']=shopInfo['commission_rate'];
            		shopInfo['fxbl']=shopInfo['commission_rate'];
        		}
        		else{
            		shopInfo['taoke']=0;
            		shopInfo['fxbl']=0;
        		}
        
        		shopInfo['shop_id']=shops[i].shop_id;
        		shopInfo['shop_title']=shops[i].shop_title;
        		shopInfo['total_auction']=shops[i].total_auction;
        		//shopInfo['jump']="index.php?mod=jump&act=shop&url="+encodeURIComponent(encode64(shopInfo['click_url']))+"&pic="+encodeURIComponent(encode64(parame['logo']))+"&fan="+encodeURIComponent(shopInfo['fxbl'])+"&name="+encodeURIComponent(shopInfo['shop_title'])+"&sid="+shopInfo['shop_id'];
        	}
    		shopsInfo[j]=shopInfo;
        	j++;
    	}
    	if(i==0){
    		var shopGet=new Array();
    		shopGet['pic_path']=parame['pic_path'];
            shopGet['logo']=parame['logo'];
        	shopGet['cid']=parame['cid'];
        	shopGet['sid']=parame['sid'];
        	shopGet['item_score']=parame['item_score'];
        	shopGet['service_score']=parame['service_score'];
        	shopGet['delivery_score']=parame['delivery_score'];
        	shopGet['created']=parame['created'];
        	shopGet['title']=parame['title'];
        
        	shopGet['auction_count']=shopInfo['auction_count'];
       		shopGet['click_url']=shopInfo['click_url'];
        	shopGet['taoke']=shopInfo['taoke'];
        	shopGet['fanxianlv']=shopInfo['fanxianlv'];
        	shopGet['seller_credit']=shopInfo['seller_credit'];
			shopGet['level']=shopInfo['seller_credit'];
        	shopGet['seller_nick']=shopInfo['seller_nick'];
        	shopGet['total_auction']=shopInfo['total_auction'];
        	shopGet['user_id']=shopInfo['user_id'];
        	shopGet['shop_type']=shopInfo['shop_type'];
            if(shopGet['shop_type']=='B'){
            	shopGet['level']=21;
            }
            shopInfo['sid']=parame['sid']; //taobao.taobaoke.widget.shops.convert 返回的店铺id是错误的，所以从新更正
            shopInfo['jump']="index.php?mod=jump&act=shop&url="+encodeURIComponent(encode64(shopGet['click_url']))+"&pic="+encodeURIComponent(encode64(shopGet['logo']))+"&fan="+encodeURIComponent(shopGet['fanxianlv'])+"&name="+encodeURIComponent(shopGet['title'])+"&sid="+shopGet['sid'];
            shopsInfo=shopInfo;
            if(parame['admin']==1 || (SHOPOPEN==1 && shopGet['fanxianlv']>0 && ((shopGet['level']>=SHOPSLEVEL && shopGet['level']<=SHOPELEVEL) || shopGet['level']==21))){
        		var url='index.php?mod=ajax&act=addshop&'+arrToParam(shopGet);
                if(parame['admin']==1){
                	url=url+'&admin=1';
                }
            	js_send(url,1);
            }
    	}
    	else{
    		//alert(shopsInfo[3]['seller_nick']);
    	}
	}
}

function taobaoTaobaokeWidgetUrlConvert(parame){
	var method='taobao.taobaoke.widget.url.convert';
    var cacheUrl=getCacheurl(method,parame);
    
    $.ajax({
	    url: cacheUrl,
		type: "GET",
		dataType:'json',
		success: function(resp){
		    doUrlConvert(resp,parame);
		},
		error: function(XMLHttpRequest,textStatus, errorThrown){
            var apiParame={method:method, fields:fields,outer_code :parame['outer_code'],url :parame['url'],timestamp:JSSDKTIME,sign:JSSDKSIGN};
            TOP.api('rest','get',apiParame,function(resp){
                if(resp){
					doUrlConvert(resp,parame);
                    saveCache(resp,cacheUrl);
                   }
			});
        }
	});
}

function doUrlConvert(resp,parame){
	if(resp.error_response){
		ErrorLog(parame['method'],resp.error_response);
	}
	else{
        theClickUrl=resp.taobaoke_item.click_url;$('#aaaa').val(theClickUrl);
	}
}