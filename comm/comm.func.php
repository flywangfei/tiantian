<?php
/*数组相关函数*/
function logout_key($a, $b) {
	foreach ($b as $v) {
		unset ($a[$v]);
	}
	return $a;
}

function arr_diff($arr1, $arr, $xs = 1) { //xs=0，arr是键值  xs=1，arr是键名
	if ($xs == 1) {
		foreach ($arr as $k => $v) {
		    $arr1[$v] = '%$%^@#$asdsfsdf355432';
		}
		$arr3 = array_diff($arr1, array('%$%^@#$asdsfsdf355432'));
	} 
	else {
		$arr3 = array_diff($arr1, $arr);
	}
	return $arr3;
}

function empty2zero(&$arr,$keyarr){ //指定键值空转0
    foreach ($arr as $key => $value) {
        if (is_array($value)) {
            empty2zero($arr[$key]);
        } else {
            $value = trim($value);
            if ($value == '' and in_array($key,$keyarr)) {
                $arr[$key] = 0;
            }
        }
    }
}

function arr2param($arr){
	$param='';
    foreach($arr as $k=>$v){
		$param.='&'.$k.'='.rawurlencode($v);
	}
	return $param;
}

function diguiFilter(&$p, $ArrFiltrate,$c) {
	for ($i=0;$i<$c;$i++) {
		$sql = $ArrFiltrate[$i];
		if (strpos(strtolower($p), $sql)!==false) {
			$p = preg_replace('#' . $sql . '#i', '', $p);
			diguiFilter($p, $ArrFiltrate,$c);
		} else {
			if($i==$c-1){return false;}
		}
	}
}

function filter(&$array,$ArrFiltrate,$c=0)
{
	if($c==0){
		$c=count($ArrFiltrate);
	}
	if (is_array($array))
	{
		foreach ($array as $key => $value)
		{
			if (is_array($value))
				filter($array[$key],$ArrFiltrate,$c);
			else
				diguiFilter($array[$key], $ArrFiltrate,$c);
		}
	}
}

function arr_replace($arr,$key,$val){
    $arr[$key]=$val;
	return $arr;
}

function arr_get_key($arr,$v){
	foreach($arr as $key=>$val){
	    if($v==$val){
			return $key;
		}
	}
}

/*function dd_float($arr){ //数字格式化
	if(is_array($arr)){
		foreach ($arr as $key => $value) {
			if(is_array($value)){print_r($value);exit;}
            $value = trim($value);
            if(is_numeric($value) && strlen($value)<11){
		        $arr[$key] = (float)$value;
	        }
        }
	}
	else{
		if(is_numeric($arr) && strlen($arr)<=11){
		    $arr = (float)$arr;
	    }
	}
	return $arr;
}

function dd_string($arr){ //字符格式化
	if(is_array($arr)){
		foreach ($arr as $key => $value) {
            $value = trim($value);
		    $arr[$key] = (string)$value;
        }
    }
	else{
		$arr=(string)$value;
	}
	return $arr;
}*/

function dd_float(&$arr){ //数字格式化
	foreach ($arr as $key => $value) {
        if (is_array($value)) {
            dd_float($arr[$key]);
        } else {
            $value = trim($value);
            if(!preg_match('/^0.*/',$value) && is_numeric($value) && strlen($value)<11){
		        $arr[$key] = (float)$value;
	        }
        }
    }
}

function dd_string(&$arr){ //字符格式化
	foreach ($arr as $key => $value) {
        if (is_array($value)) {
            dd_float($arr[$key]);
        } else {
            $value = trim($value);
		    $arr[$key] = (string)$value;
        }
    }
}

function dd_addslashes(&$v,$do=0) {
	if (get_magic_quotes_gpc() == 0 || $do==1) {
		if (is_array($v)) {
			foreach ($v as $key => $value) {
				if (is_array($value)) {
					dd_addslashes($v[$key]);
				} else {
					$value = addslashes(trim($value));
					$v[$key] = $value;
				}
			}
		}
		else {
			$v = addslashes($v);
		}
	}
	return $v;
}

function trim_arr(&$arr){
	if (is_array($arr)) {
		foreach($arr as $k=>$v){
			if (is_array($v)) {
				 trim_arr($v);
			}
			else{
				$arr[$k]=trim($v);
			}
		}
	}
	else{
		$arr=trim($arr);
	}
}

/*html相关函数*/
function select($array, $id = 10000, $name) {
	$i = 0;
	echo '<select name="'.$name.'" id="'.$name.'" class="'.$name.'">';
	foreach ($array as $key => $val) {
		if ($id == $key && isset($id)){
		    $select = 'selected';
		}
		else{
			$select = '';
		}
		echo "<option value='$key' $select style='background:$bg'>$val</option>";
		$i++;
	}
	echo "</select>";
}

function html_radio($array,$id,$name){
    foreach ($array as $key => $val) {
		if ($id == $key)
			$checked = 'checked="checked"';
		else
			$checked = '';
		echo "<label><input ".$checked." name='".$name."' type='radio' value='".$key."' /> ".$val."</label>&nbsp;&nbsp;";
	}
}

function html_img($pic_url,$type='',$alt='',$class='',$width='',$height='',$onerror_pic=''){ //type大于10为不给图片进行js加密，类型再去个位数
	if($onerror_pic==''){
		$onerror_pic='images/dian.png';
	}
	if($type>=10){$img_type=$type%10;}
	else{$img_type=$type;}
	switch($img_type){
	    case 1:
		    $pic_url=$pic_url."_100x100.jpg";
		break;
		case 2:
		    $pic_url=$pic_url."_b.jpg";
		break;
		case 3:
		    $pic_url=$pic_url."_310x310.jpg";
		break;
	}
	$pic_url=base64_encode($pic_url);
	if($type>=10){
		if($alt!=''){$alt='alt="'.$alt.'"';}
	    if($class!=''){$class='class="'.$class.'"';}
	    if($width>0){$width='width:'.$width.'px';}else{$width='';}
	    if($height>0){$height=';height:'.$height.'px';}else{$height='';}
		$onerror='onerror="this.src=\''.$onerror_pic.'\'"';
		$re= "<img src='".base64_decode($pic_url)."' ".$alt." ".$class." style='".$width." ".$height."' ".$onerror."/>";
	}
	elseif(PICJM==0){
		if(strpos($alt,"'")!==false){
			$alt=str_replace("'",'',$alt);
		}
		
	    $re= "<SCRIPT language=javascript>setPic('".$pic_url."','".$width."','".$height."','".$alt."','".$class."','".$onerror_pic."');</SCRIPT>";
	}
	elseif(PICJM==1){
		$pic_url=urlencode($pic_url);
	    if($alt!=''){$alt='alt="'.$alt.'"';}
	    if($class!=''){$class='class="'.$class.'"';}
	    if($width>0){$width='width:'.$width.'px';}else{$width='';}
	    if($height>0){$height=';height:'.$height.'px';}else{$height='';}
		$onerror='onerror="this.src=\''.$onerror_pic.'\'"';
		if(PICWJT==0){
		    $re= "<img src='comm/showpic.php?pic=".$pic_url."' ".$alt." ".$class." style='".$width." ".$height."' ".$onerror."/>";
		}
	    else{
		    $re= "<img src='tbimg/".$pic_url.".jpg' ".$alt." ".$class." style='".$width." ".$height."' ".$onerror."/>";
		}
	}
	return $re;
}

function script($str){
    return '<script language="javascript" type="text/javascript">'.$str.'</script>';
}

function wangwang($nick,$type=1){
	$nick=urlencode($nick);
	switch($type){
	    case 1:
		    return '<a target="_blank" href="http://amos.im.alisoft.com/msg.aw?v=2&uid='.$nick.'&site=cntaobao&s=2&charset=utf-8" ><img style="width:77px; height:19px" src="http://amos.im.alisoft.com/online.aw?v=2&uid='.$nick.'&site=cntaobao&s=1&charset=utf-8" alert="点击这里给我发消息" /></a>';
		break;   
		case 2:
		    return '<a target="_blank" href="http://amos.im.alisoft.com/msg.aw?v=2&uid='.$nick.'&site=cntaobao&s=2&charset=utf-8" ><img style="width:16px; height:16px" border="0" src="http://amos.im.alisoft.com/online.aw?v=2&uid='.$nick.'&site=cntaobao&s=2&charset=utf-8" alt="点击这里给我发消息" /></a>';
		break;
	}
}

function qq($qq,$type=1){
	switch($type){
		case 1:
			return '<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin='.$qq.'&site=qq&menu=yes"><img style="height:16px" border="0" src="http://wpa.qq.com/pa?p=2:'.$qq.':46" alt="点击这里给我发消息" title="点击这里给我发消息"></a>';
		break;
		case 2:
			return '<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin='.$qq.'&site=qq&menu=yes"><img style="width:21px; height:21px" border="0" src="http://wpa.qq.com/pa?p=2:'.$qq.':45" alt="点击这里给我发消息" title="点击这里给我发消息"></a>';
		break;
	}
    
}

function a($uid, $size = '', $type = '') {
	$size = in_array($size, array (
		'big',
		'middle',
		'small'
	)) ? $size : 'middle';
	$uid = abs(intval($uid));
	$uid = sprintf("%010d", $uid);
	$dir1 = substr($uid, 0, 4);
	$dir2 = substr($uid, 4, 4);
	//$dir3 = substr($uid, 5, 2);
	$typeadd = $type == 'real' ? '_real' : '';
	$avatar_path='upload/avatar/'.$dir1 . '/' . $dir2 . '/' . substr($uid, -2) . $typeadd . "_avatar_$size.jpg";
	if(file_exists(DDROOT.'/'.$avatar_path)) return $avatar_path;
	else return 'upload/noavatar_'.$size.'.jpg';
}

function postform($action,$param){
	$authcode_arr=array('webid');
	$f='<form name="form" method="post" action="'.$action.'">';
	foreach($param as $k=>$v){
		if(in_array($k,$authcode_arr)){
			$v=authcode($v,'ENCODE',DDKEY);
		}
		$f.='<input type="hidden" name="'.$k.'" value="'.$v.'" />';
	}
    $f.="<input type='submit' style='width:0px; height:0px;filter:alpha(opacity=0);opacity:0' value='' /></form><script>document.form.submit();</script>";
	return $f;
}

function limit_input($name,$value=DEFAULTPWD,$width='150',$pwd=1){
    if(strpos($name,'[')!==false){
	    preg_match('/\[(.*)\]/',$name,$a);
		$b=str_replace('['.$a[1].']','',$name);
		$id=$b.$a[1];
	}
	else{
	    $id=$name;
	}
	if($pwd==1){
	    $type='password';
	}
	else{
	    $type='text';
	}
	return $s='<input style="width:'.$width.'px" type="'.$type.'" name="'.$name.'" id="'.$id.'" readonly="readonly" class="disabled" value="'.$value.'"/><input type="checkbox" title="激活修改" onClick="if($(this).attr(\'checked\')==true){$(\'#'.$id.'\').attr(\'readonly\',\'\').removeClass(\'disabled\');}else{$(\'#'.$id.'\').attr(\'readonly\',\'readonly\').addClass(\'disabled\');}"  />';
}


/*文件操作相关函数*/
function make_arr_cache($arr, $name,$root=0) {
	$data = "<?php\n return " . var_export($arr, true) . ";\n?>";
	if($root==0){
	    dd_file_put(DDROOT .'/' . $name . '.php', $data);
	}
	else{
	    dd_file_put($name . '.php', $data);
	}
}

function create_dir($dir) {
	if ($dir!='/' && !is_dir($dir)) {
		$d=str_replace(DDROOT.'/','',$dir);
		$d_arr=explode('/',$d);
		$di='';
		foreach($d_arr as $v){
			$di.='/'.$v;
			if(is_dir(DDROOT.$di)){
				if(iswriteable(DDROOT.$di)==0){
					return $di.'目录不可写';
				}
			}
			else{
				mkdir(DDROOT.$di);
			}
		}
	}
}

function create_file($file,$data='',$add=0,$detect=1,$original=0){
	$file=str_replace("\\", '/', $file);
    if($detect==1){
		$dir_arr=explode('/',$file);
	    $c=count($dir_arr);
		unset($dir_arr[$c-1]);
		$dir=implode('/',$dir_arr);
		create_dir($dir);
	}
	if($add==0){
		if($original==0){
			return dd_file_put($file,$data);
		}
		else{
			return file_put_contents($file,$data);
		}
	}
	else{
		return dd_file_put($file,$data,FILE_APPEND);
	}
}

function iswriteable($file){
	if(!file_exists($file)){
		return 0;
	}
	$writeable = 0;
    if(is_dir($file)){  
	    $dir=$file;  
		file_put_contents($dir.'/test.txt',1);
		if(file_exists($dir.'/test.txt')){
			if(unlink($dir.'/test.txt')){
				$writeable = 1; 
			}
		}
	}
	else{  
		if(file_exists($file)){
			$rename=rename($file,$file.'.duoduo');
			if($rename==1){
				rename($file.'.duoduo',$file);
			}
			file_put_contents($file,'duoduo_test_file_exists',FILE_APPEND);
			$a=file_get_contents($file);
			if(preg_match('/duoduo_test_file_exists$/',$a)){
				$a=preg_replace('/duoduo_test_file_exists$/','',$a);
				if(file_put_contents($file,$a)>0){
					$update = 1;
				}
			}
		}
		$writeable=$rename*$update;
	} 
	return $writeable;
}

function directory_size($directory) {
	$directorySize = 0;
	if(!file_exists($directory)){return 0;}
	if ($dh =  opendir($directory)) {
		while (($filename = readdir($dh))) {
			if ($filename != "." && $filename != "..") {
				if (is_file($directory . "/" . $filename))
					$directorySize += filesize($directory . "/" . $filename);
				if (is_dir($directory . "/" . $filename))
					$directorySize += directory_size($directory . "/" . $filename);
			}
		} 
	} 
    closedir($dh);
	return $directorySize;
}

function deldir($dir) {
	if (!file_exists($dir)) {
		return false;
	} 
	if($dh = opendir($dir)){
		while ($file = readdir($dh)) {
			if ($file != "." && $file != "..") {
				$fullpath = $dir . "/" . $file;
				if (!is_dir($fullpath)) {
					unlink($fullpath);
				} else {
					deldir($fullpath);
				}
			}
		}
	closedir($dh);
	}
	if (rmdir($dir)) {
		return true;
	} else {
		return false;
	} 
}

function MkdirAll($truepath) {
	if (!file_exists($truepath)) {
		mkdir($truepath, 0777);
		chmod($truepath, 0777);
		return true;
	} else {
		return true;
	}
}

function judge_empty_dir($directory){      
    $handle = opendir($directory);      
    while (($file = readdir($handle)) !== false){          
        if ($file != "." && $file != ".."){              
            closedir($handle);              
            return 0;          
        }      
    }     
    closedir($handle);     
    return 1;  
}


/*文字字符串相关函数*/
function utf_substr($str, $len) {
	for ($i = 0; $i < $len; $i++) {
		$temp_str = substr($str, 0, 1);
		if (ord($temp_str) > 127) {
			$i++;
			if ($i < $len) {
				$new_str[] = substr($str, 0, 3);
				$str = substr($str, 3);
			}
		} else {
			$new_str[] = substr($str, 0, 1);
			$str = substr($str, 1);
		}
	}
	return join($new_str);
}

function str_del_last($str){
	$newstr = substr($str,0,strlen($str)-1);
	return $newstr;
}

/*验证相关函数*/
function reg_name($name,$min=3,$max=15,$shield_arr=array()){
	$strl=str_utf8_chinese_word_count($name)*2+str_utf8_english_count($name);
	if($strl<$min or $strl>$max){
	    return -1; //用户名不合法
	}
	if(!empty($shield_arr)){
	    foreach($shield_arr as $v=>$k){
	        if(strpos($name,$v)!==false){
			    return -2; //包含非法词汇
	        }
	    }
	}
	$pcre_name = "/^[a-zA-Z0-9_\.\-@\x80-\xff]+$/"; //utf-8
	//$pcre_name = "/^[a-z0-9_".chr(0xa1)."-".chr(0xff)."]+$/"; //gbk
    if(preg_match($pcre_name,$name)){
        return 1;
    }else{
        return -1;  //用户名不合法
    }
}

function reg_password($pwd){
	$pcre_pwd = '/.{6,20}/';
    if(preg_match($pcre_pwd,$pwd)){
        return 1;
    }else{
        return 0;
    }
}

function reg_email($email){
	$pcre_email = '/^[-0-9a-zA-Z_.]+@([0-9a-zA-Z][_\-0-9a-zA-Z.]{0,30}\.)[a-zA-Z]{2,10}$/';
    if(preg_match($pcre_email,$email)){
        return 1;
    }else{
        return 0;
    }
}

function reg_qq($qq){
	$pcre_qq = '/^[0-9]{4,20}$/';
    if(preg_match($pcre_qq,$qq) || reg_email($qq)==1){
        return 1;
    }else{
        return 0;
    }
}

function reg_mobile($mobile){
	$pcre_mobile = '/^1[0-9]{10}$/';
    if(preg_match($pcre_mobile,$mobile)){
        return 1;
    }else{
        return 0;
    }
}

function is_url($url){
	$pcre_url = '/^http:\/\/[\w-]+\.[\w-]+[\.[\w-]|]+[\/=\?%\-&~`@[\]\':+!\w]+$/';
    if(preg_match($pcre_url,$url)){
        return 1;
    }else{
        return 0;
    }
}

function reg_taobao_url($url){
    if(preg_match('/(taobao\.com|tmall\.com)/',$url)==1){
		return 1;
	}
	else{
	    return 0;
	}
}

function reg_alipay($alipay){
	$is_email=reg_email($alipay);
	if($is_email==1){
	    return 1;
	}
	else{
		$is_mobile=reg_mobile($alipay);
	    if($is_mobile==1){
		    return 1;
		}
		else{
		    return 0;
		}
	}
}

function reg_content($content,$type=0){ //type为1，替换；type为2，提示错误
	$pattern='/[\w]+?[\.]?(。)?\w+(\.|。)(com|net|org|gov|cc|biz|info|cn|tk|mobi|co|so|tel|tv|name|asia|me|中国|公司|网络)(\.(cn|hk))*/i';
	if($type==0){
		$type=REPLACE;
	}
    $shield_arr = dd_get_cache('no_words'); //屏蔽词语
	if($type==1){
		$content=strtr($content,$shield_arr);
		$content=preg_replace($pattern,'',$content);
	}
	else{
		foreach($shield_arr as $v){
			if(strpos($content,$v)!==false){
				return ''; //包含非法词汇
	    	}
		} 
		if(preg_match($pattern,$content)){
	    	return '';
		}
	}
	return htmlspecialchars($content);
}

function reg_time($time){
	if($time==''){return 0;}
    $unixTime = strtotime($time);
    if (!is_numeric($unixTime)){
		return 0;
	}
	return 1;
}

function reg_captcha($yzm,$code='captcha'){
	if($yzm==''){return 0;}
	else{$yzm=strtolower($yzm);}
    if(!defined('ADMIN')){
		dd_session_start();
	}
	$captcha=strtolower($_SESSION[$code]);
	unset($_SESSION[$code]);
	if($captcha=='' || $yzm!=$captcha){
	    return 0;
	}
	return 1;
}


function show_shop_cat($text){
	switch ($text){
		case "11": $str="电脑硬件/台式机/网络设备"; break;
		case "12": $str="MP3/MP4/iPod/录音笔"; break;
		case "13": $str="手机"; break;
		case "14": $str="女装/流行女装"; break;
		case "15": $str="彩妆/香水/护肤/美体"; break;
		case "16": $str="电玩/配件/游戏/攻略"; break;
		case "17": $str="数码相机/摄像机/图形冲印"; break;
		case "18": $str="运动/瑜伽/健身/球迷用品"; break;
		case "20": $str="古董/邮币/字画/收藏"; break;
		case "21": $str="办公设备/文具/耗材"; break;
		case "22": $str="汽车/配件/改装/摩托/自行车"; break;
		case "23": $str="珠宝/钻石/翡翠/黄金"; break;
		case "24": $str="居家日用/厨房餐饮/卫浴洗浴"; break;
		case "26": $str="装潢/灯具/五金/安防/卫浴"; break;
		case "27": $str="成人用品/避孕用品/情趣内衣"; break;
		case "29": $str="食品/茶叶/零食/特产"; break;
		case "30": $str="玩具/动漫/模型/卡通"; break;
		case "31": $str="箱包皮具/热销女包/男包"; break;
		case "32": $str="宠物/宠物食品及用品"; break;
		case "33": $str="音乐/影视/明星/乐器"; break;
		case "34": $str="书籍/杂志/报纸"; break;
		case "35": $str="网络游戏点卡"; break;
		case "36": $str="网络游戏装备/游戏币/帐号/代练"; break;
		case "37": $str="男装"; break;
		case "1020": $str="母婴用品/奶粉/孕妇装"; break;
		case "1040": $str="ZIPPO/瑞士军刀/饰品/眼镜"; break;
		case "1041": $str="移动联通充值中心/IP长途"; break;
		case "1042": $str="网店装修/物流快递/图片存储"; break;
		case "1043": $str="笔记本电脑"; break;
		case "1044": $str="品牌手表/流行手表"; break;
		case "1045": $str="户外/军品/旅游/机票"; break;
		case "1046": $str="家用电器/hifi音响/耳机"; break;
		case "1047": $str="鲜花速递/蛋糕配送/园艺花艺"; break;
		case "1048": $str="3C数码配件市场"; break;
		case "1049": $str="床上用品/靠垫/窗帘/布艺"; break;
		case "1050": $str="家具/家具定制/宜家代购"; break;
		case "1051": $str="保健品/滋补品"; break;
		case "1052": $str="网络服务/电脑软件"; break;
		case "1053": $str="演出/旅游/吃喝玩乐折扣券"; break;
		case "1054": $str="饰品/流行首饰/时尚饰品"; break;
		case "1055": $str="女士内衣/男士内衣/家居服"; break;
		case "1056": $str="女鞋"; break;
		case "1062": $str="童装/婴儿服/鞋帽"; break;
		case "1082": $str="流行男鞋/皮鞋"; break;
		case "1102": $str="腾讯QQ专区"; break;
		case "1103": $str="IP卡/网络电话/在线影音充值"; break;
		case "1104": $str="个人护理/保健/按摩器材"; break;
		case "1105": $str="闪存卡/U盘/移动存储"; break;
		case "1106": $str="运动鞋"; break;
		case "1122": $str="时尚家饰/工艺品/十字绣"; break;
		case "1153": $str="运动服"; break;
		case "1154": $str="服饰配件/皮带/帽子/围巾"; break;
		default: $str="全部店铺"; break; 
 	}
	return $str;
}

function dd_encrypt($val,$key){
    return base64_encode($key.$val);
}

function dd_decrypt($val,$key){
	$a=base64_decode($val);
    $a=preg_replace('/^'.$key.'/','',$a);
	return $a;
}

function fs($class)
{
	static $classes = array();
	if(!isset($classes[$class]) || $classes[$class] === NULL)
	{
		$classes[$class] = new $class();
		//unset($class);
	}
	return $classes[$class];
}

function compact_html($str) {
	$str = preg_replace("/\t/", "", $str);
	$str = preg_replace("/\r\n/", "", $str);
	$str = preg_replace("/\r/", "", $str);
	$str = preg_replace("/\n/", "", $str);
	$str = preg_replace("/\s/", "", $str);
	return $str;
}

function get_final_url($url) {
	$str = '';
	$url = parse_url($url);
	$fp = fsockopen($url['host'], 80, $errno, $errstr);
	if ($fp) {
		if (!array_key_exists('query', $url)) {
			$url['query'] = '';
		}

		$header = "GET " . $url['path'] . "?" . $url['query'] . " HTTP/1.1\r\n";
		$header .= "Host: " . $url['host'] . "\r\n";
		$header .= "User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.0; zh-CN; rv:1.9.0.1) Gecko/2008070208 Firefox/3.0.1\r\n";
		$header .= "Referer: http://" . $url['host'] . "\r\n";
		$header .= "Connection: Close\r\n\r\n";
		fwrite($fp, $header);
		while (!feof($fp)) {
			$s = fgets($fp, 128);
			$str .= $s;
		}
		fclose($fp);
		preg_match("|Location:(.*?)Content-Type|", compact_html($str), $arr);
		return $arr[1];
	}
}

function dsetcookie($var, $value = '', $life = 0,$cookie_path='/',$cookie_domain=SURL,  $http_only = false)
{
	$_COOKIE[$var] = $value;

	if($value == '' || $life < 0)
	{
		$value = '';
		$life = -1;
	}

	$life = $life > 0 ? TIME + $life : ($life < 0 ? TIME - 31536000 : 0);
	$path = $http_only && PHP_VERSION < '5.2.0' ? $cookie_path.'; HttpOnly' : $cookie_path;

	$secure = $_SERVER['SERVER_PORT'] == 443 ? 1 : 0;
	if(PHP_VERSION < '5.2.0')
	{
		setcookie($var, $value, $life, $path, $cookie_domain, $secure);
	}
	else
	{
		setcookie($var, $value, $life, $path, $cookie_domain, $secure, $http_only);
	}
}

function set_cookie($var, $value = '', $life = 1200,$encrypt=1){
	if($encrypt==1 && $life!=0){
	    $value=authcode($value, 'ENCODE');
	}
	
	if($life>0 && $value!=''){
		$life=TIME+$life;
	}
	else{
		$life=TIME-3153600000;
		$value='';
	}
	$_COOKIE[$var] = $value;
	setcookie($var, $value, $life,'/');
}

function get_cookie($var,$encrypt=1){
	if(isset($_COOKIE[$var])){
	    if($encrypt==1){
	       $value=authcode($_COOKIE[$var], 'DECODE');
	    }
        else{
	        $value=$_COOKIE[$var];
	    }
	    return $value;
	}
	else{
	    return '';
	}
}

function user_login($uid,$md5pwd,$life=''){
	if($life==''){$life=3600*24;}
	$userlogininfo=serialize(array('uid'=>$uid,'ddpassword'=>$md5pwd,'ddsavetime'=>$life));
	set_cookie("userlogininfo", $userlogininfo, $life);
}

function webtype($a,$b=''){
    if(WEBTYPE==0){
	    return $a;
	}
	else{
	    return $b;
	}
}

function extension($filename){  //求后缀名
	if(strpos($filename,'/')!==false){
		$arr= explode('/',$filename);
		$arr = array_reverse($arr);
		if(strpos($arr[0],'.')!==false){
			$row= explode('.',$arr[0]);
			$row = array_reverse($row);
			return $row[0];
		}
		else{
			return '';
		}
	}
	else{
		if(strpos($filename,'.')!==false){
			$row = array_reverse($row);
			return $row[0];
		}
		else{
			return '';
		}
	}
}

function get_client_ip()
{
	$ip = $_SERVER['REMOTE_ADDR'];
	if (isset($_SERVER['HTTP_CLIENT_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CLIENT_IP']))
	{
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	}
	elseif(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches))
	{
		foreach ($matches[0] AS $xip)
		{
			if (!preg_match('#^(10|172\.16|192\.168)\.#', $xip))
			{
				$ip = $xip;
				break;
			}
		}
	}
	return $ip;
}

function fuzzyTradeId($trade_id,$num=3){
	$len=strlen($trade_id);
    return substr($trade_id,0,$num).'*****'.substr($trade_id,-$num);
} 

function yzm($path=''){
    return '<img alt="验证码" src="'.$path.'comm/showpic.php" align="absmiddle" onClick="this.src=\''.$path.'comm/showpic.php?a=\'+Math.random()" title="点击更换" style="cursor:pointer;"/>';
}

function deep_jm($val,$key=DDKEY){
    return md5(md5($key.$val).$key);
}

function AD($id){
	$arr=dd_get_cache('ad/'.$id);
	if(!empty($arr)){
		$style='style="';
		if($arr['edate']>TIME && ($arr['img']==1 || $arr['content']==1)){
			if($arr['width']>0){
				$style.='width:'.$arr['width'].'px;';
			}
			if($arr['height']>0){
				$style.='height:'.$arr['height'].'px;';
			}
			$style.='"';
			if(isset($arr['ad_content'])){
				$c=$arr['ad_content'];
			}
			else{
				$c="<script src='".SITEURL."/data/ad/".$id.".js'></script>";
			}
			return "<div ".$style." id='ad".$id."'>".$c."</div>";
		}
	}
	return;
}

function http_pic($pic){
    if(preg_match('|^http://|',$pic)==0){
	    return SITEURL.'/'.$pic;
	}
	else{
	    return $pic;
	}
}

function del_pic($img){
	if($img==''){
		return;
	}
    if(preg_match('|^http://|',$pic)==0){
	    if(file_exists(DDROOT.'/'.$img)){
		    unlink(DDROOT.'/'.$img);
		}
	}
}

function mingxi_content($row,$mingxi_content){
	$mingxi_content=str_replace('{money}',abs($row['money']),$mingxi_content);
	$mingxi_content=str_replace('{jifen}',abs($row['jifen']),$mingxi_content);
    if(strpos($mingxi_content,'{source}')!==false){
	    $mingxi_content=str_replace('{source}',$row['source'],$mingxi_content);
	}
	return $mingxi_content;
}

function error_html($error_msg='缺少必要参数',$goto=0,$type=0){
	global $nav;
	global $duoduo;
	global $webset;
	global $dduser;
	global $no_words;
    include(TPLPATH.'/error.tpl.php');
	dd_exit();
}

function spider_limit($spider) {
	foreach ($spider as $k=>$val) {
		if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), $k) !== false) {
			$rand_num = rand(1, 100);
			if ($rand_num <= $val) {
				dd_file_put(DDROOT . '/data/spider/' . $k . '.txt', date('Y-m-d H:i:s') . "\r\n", FILE_APPEND);
				error_html('hello spider!');
			}
		}
	}
}

function mod_name($mod,$act){
	if($mod=='index'){
	    $mod_name=$mod;
	}
	elseif($mod=='ajax' || $mod=='jump'){
	    $mod_name=$mod;
	}
    else{
	    $mod_name=$mod.'/'.$act;
	}
	return $mod_name;
}

function addquote($var)
{
	return str_replace("\\\"", "\"", preg_replace("/\[([a-zA-Z0-9_\-\.\x7f-\xff]+)\]/s", "['\\1']", $var));
}

function sel_date($dir){
    $dh = dir($dir);
    $j=0;
    while(($filename=$dh->read()) !== false){
	    if ($filename != "." && $filename != ".."){
			$dp=$dir.'/'.$filename;
			if(judge_empty_dir($dp)!=1){
			    $arr=explode('_',$filename);
	            $time=date('Y-m-d',strtotime($arr[1]));
	            $option_arr[$j]="<option value='$arr[1]'>$time</option>";
		        $j++;
			}
	    }
    }
    for($i=$j;$i>=0;$i--){
        $option.=$option_arr[$i];
    }
    $dh->close();
	return $option;
}

function RpLine($str)
{
	$str = str_replace("\r","\\r",$str);
	$str = str_replace("\n","\\n",$str);
	return $str;
}



/*时间转换函数*/   
/*function tranTime($time) {       
    $rtime = date("m-d H:i",$time);       
    $htime = date("H:i",$time);       
    $timetime = TIME - $time;       
 
    if ($time < 60) {           
       $str = '刚刚';       
    }       
    else if ($time < 60 * 60) {           
       $min = floor($time/60);           
       $str = $min.'分钟前';       
    }       
    else if ($time < 60 * 60 * 24) {           
       $h = floor($time/(60*60));           
       $str = $h.'小时前 '.$htime;       
    }       
    else if ($time < 60 * 60 * 24 * 3) {           
       $d = floor($time/(60*60*24));           
       if($d==1)              
       $str = '昨天 '.$rtime;           
    else              
       $str = '前天 '.$rtime;       
    }       
    else {           
       $str = $rtime;       
    }       
    return $str;   
}*/

function tranTime($time){
	$str='';
	if(!is_numeric($time)){
		$time=strtotime($time);
	}
	
	$current_time = time();
	if ($time >= $current_time) {
        $time = $time - $current_time;
		if ($time < 60) {
			$str = '马上';
		}
		elseif ($time < 60 * 60) {
			$min = floor($time / 60);
			$str = $min . '分钟后';
		}
		elseif ($time < 60 * 60 * 24) {
			$h = floor($time / (60 * 60));
			$str = $h . '小时后';
		}
		elseif ($time < 60 * 60 * 24 * 30) {
			$d = floor($time / (60 * 60 * 24));
			$str='还有'.$d.'天';
		}
		elseif ($time < 60 * 60 * 24 * 30*12) {
			$d = floor($time / (60 * 60 * 24*30));
			$str='还有'.$d.'个月';
		}
		else{
			$d = floor($time / (60 * 60 * 24*30*12));
			$str='还有'.$d.'年';
		}
	}
	else{
	    $str='已过期'; 
	}
	return $str;
}

function browser() {
	if(!isset($_SERVER["HTTP_USER_AGENT"])){
		return '';
	}
	if (strpos($_SERVER["HTTP_USER_AGENT"], "MSIE")){
		$browser = "ie";
	}
	elseif (strpos($_SERVER["HTTP_USER_AGENT"], "Firefox")){
		$browser = "firefox";
	}
	elseif (strpos($_SERVER["HTTP_USER_AGENT"], "Chrome")){
		$browser = "chrome";
	}
	elseif (strpos($_SERVER["HTTP_USER_AGENT"], "Safari")){
		$browser = "safari";
	}
	elseif (strpos($_SERVER["HTTP_USER_AGENT"], "Opera")){
		$browser = "opera";
	}
	else{
		$browser='';
	}
	return $browser;
}

/*多多函数*/

function alert($word){
    echo script('alert("'.$word.'")');
}

function fenduan($val,$arr=array(),$level=0){
    foreach($arr as $k=>$v){
       if($level>=$k) return round($val*$v,2);
    }
    return round($val*$v,2);
}

function rep($str){
    $re="/[^\d]/";
    return preg_replace($re,"",$str);
}

function StrCode($string,$key,$action='ENCODE'){
	$key	= substr(md5($_SERVER["HTTP_USER_AGENT"].$key),8,18);
	$string	= $action == 'ENCODE' ? $string : base64_decode($string);
	$len	= strlen($key);
	$code	= '';
	for($i=0; $i<strlen($string); $i++)
	{
		$k		= $i % $len;
		$code  .= $string[$i] ^ $key[$k];
	}
	$code = $action == 'DECODE' ? $code : base64_encode($code);
	return $code;
}

//签名函数
	function createSign ($paramArr) { 
	    global $appSecret; 
	    $sign = $appSecret; 
	    ksort($paramArr); 
	    foreach ($paramArr as $key => $val) { 
	       if ($key !='' && $val !='') { 
	           $sign .= $key.$val; 
	       } 
	    } 
	    $sign = strtoupper(md5($sign.$appSecret));
	    return $sign; 
	}

	//组参函数 
	function createStrParam ($paramArr) { 
	    $strParam = ''; 
	    foreach ($paramArr as $key => $val) { 
	       if ($key != '' && $val !='') { 
	           $strParam .= $key.'='.urlencode($val).'&'; 
	       } 
	    } 
	    return $strParam; 
	}

function dd_session_start(){
	create_dir(DDROOT.'/data/temp/session/'.date('Ymd'));
	ini_set('session.save_handler', 'files');
    session_save_path(DDROOT.'/data/temp/session/'.date('Ymd')); 
	session_set_cookie_params(0, '/', '');
	session_start();
}

function param2str($parame) {
	$parame_str = '';
	if (!empty ($parame)) {
		foreach ($parame as $k => $v) {
			if ($k != '') {
				$parame_str .= $k . '=' . urlencode($v) . '&';
			}
		}
		$parame_str = preg_replace('/&$/', '', $parame_str);
	}
	return $parame_str;
}

function filename(){ 
	$dir_file = $_SERVER['SCRIPT_NAME']; 
	$filename = basename($dir_file); 
	return $filename; 
} 

function dd_strip_tags($html,$tags=''){
    $default_tags='<a>,<b>,<br>,<div>,<p>,<table>,<tr>,<td>,<th>,<i>,<font>,<dl>,<dt>,<h1>,<h2>,<h3>,<h4>,<h5>,<h6>,<hr>,<ul>,<li>,<ol>';
	if($tags!=''){$default_tags=','.$default_tags;}
	return $html=strip_tags($html,$default_tags);
}

/**
 * 字符串截取，支持中文和其他编码
 *
 * @param string $str 需要转换的字符串
 * @param string $start 开始位置
 * @param string $length 截取长度
 * @param string $charset 编码格式
 * @param string $suffix 截断字符串后缀
 * @return string
 */
function substr_ext($str, $start=0, $length, $charset="utf-8", $suffix="")
{
    if(function_exists("mb_substr")){
         return mb_substr($str, $start, $length, $charset).$suffix;
	}
    elseif(function_exists('iconv_substr')){
         return iconv_substr($str,$start,$length,$charset).$suffix;
    }
    $re['utf-8']  = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
    $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
    $re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
    $re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
    preg_match_all($re[$charset], $str, $match);
    $slice = join("",array_slice($match[0], $start, $length));
    return $slice.$suffix;
}

function dd_replace($str,$arr=array()){
	if(REPLACE==0){
		return $str;
	}
	if(empty($arr)){
		$arr=dd_get_cache('no_words');
	}
	if(REPLACE==1){
	    $str=strtr($str,$arr);
	}
	elseif(REPLACE==2){
	    foreach($arr as $a=>$b){
		    if(strpos($str,(string)$a)!==false){
				if(MOD=='ajax'){
					$re=array('s'=>0,'id'=>55);
					dd_exit(json_encode($re));
				}
				else{
					error_html('包含敏感词！',-1);
				}
			}
		}
	}
	return $str;
}

function dd_exit($str=''){
    global $duoduo;
	if(isset($duoduo)){$duoduo->close();}
	echo $str;
	unset($duoduo);
	exit;
}

function ajax_exit($str=''){
	echo $str;
	continue;
}

function ob_gzip($content)
{    
    if(!headers_sent() &&  extension_loaded("zlib") && strpos($_SERVER["HTTP_ACCEPT_ENCODING"],"gzip")!==false)
    {
        $content = gzencode($content,9);
        header("Content-Encoding: gzip");
        header("Vary: Accept-Encoding");
        header("Content-Length: ".strlen($content));
    }
    return $content;
}

function strtoarray($str){
	$str=str_replace('，',',',$str);
	$str=preg_replace('/[\n\r\t\s]+/i',',',$str);
	$arr=explode(',',$str);
	return $arr;
}

function limit_ip($name,$ip=''){
	if($ip=='')	{
		$ip=get_client_ip();
	}
	$limit_ip=dd_get_cache($name);
	if($limit_ip[0]=='') return 0;
	$ips=implode('|',$limit_ip);
	if(preg_match('/'.$ips.'/',$ip)==1){
		return 1;
	}
	return 0;
}

function dd_tag_replace($str){
	global $webset;
	$arr=array('{WEBNICK}'=>WEBNICK,'{WEBNAME}'=>WEBNAME,'{QQ}'=>$webset['qq'],'{EMAIL}'=>$webset['email'],'{URL}'=>URL);
	$str=strtr($str,$arr);
	return $str;
}

function no_cache(){
	//设置此页面的过期时间(用格林威治时间表示)，只要是已经过去的日期即可。    
	header("Expires: Mon, 26 Jul 1970 05:00:00 GMT");      
   
	//设置此页面的最后更新日期(用格林威治时间表示)为当天，可以强制浏览器获取最新资料     
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");      
   
	//告诉客户端浏览器不使用缓存，HTTP 1.1 协议     
	header("Cache-Control: no-cache, must-revalidate");      
   
	//告诉客户端浏览器不使用缓存，兼容HTTP 1.0 协议     
	header("Pragma: no-cache");
}

/*function gbk2utf8($q) {
	echo $encode=mb_detect_encoding($q,array('ASCII','GB2312','GBK','UTF-8','BIG5'));
	if($encode!='UTF-8' && $encode!='CP936'){
		$q=iconv($encode,'utf-8',$q);
	}
	return $q;
}*/

function gbk2utf8($string, $encoding = 'utf8') {
	$is_utf8 = preg_match('%^(?:[\x09\x0A\x0D\x20-\x7E]| [\xC2-\xDF][\x80-\xBF]|  \xE0[\xA0-\xBF][\x80-\xBF] | [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}    |  \xED[\x80-\x9F][\x80-\xBF] |  \xF0[\x90-\xBF][\x80-\xBF]{2}  | [\xF1-\xF3][\x80-\xBF]{3}  |  \xF4[\x80-\x8F][\x80-\xBF]{2} )*$%xs', $string);
	if ($is_utf8 && $encoding == 'utf8') {
		return $string;
	}
	elseif ($is_utf8) {
		return mb_convert_encoding($string, $encoding, "UTF-8");
	} else {
		return mb_convert_encoding($string, $encoding, 'gbk,gb2312,big5');
	}
}

function u($mod,$act='',$arr=array()){
	$wjt=0;
	
	if(defined('INDEX')==1){
		if($act=='' && $mod=='index'){
			return SITEURL;
		}
	    global $wjt_mod_act_arr;  //伪静态数组
		
		if(!isset($wjt_mod_act_arr)){
			$wjt_mod_act_arr=dd_get_cache('wjt');
		}
	    if(WJT==1 && array_key_exists($mod,$wjt_mod_act_arr) && array_key_exists($act,$wjt_mod_act_arr[$mod]) && $wjt_mod_act_arr[$mod][$act]==1){
		    $wjt=1;
	    }
		unset($wjt_mod_act_arr);
		
		if($mod=='tao' && ($act=='list' || $act=='view') && URLENCRYPT!=''){
	        if(isset($arr['cid']) && $arr['cid']>0){
		        $arr['cid']=dd_encrypt($arr['cid'],URLENCRYPT);
		    }
		    elseif(isset($arr['iid']) && $arr['iid']>0){
		        $arr['iid']=dd_encrypt($arr['iid'],URLENCRYPT);
		    }
	    }
	}

	if($wjt==0){
		if($act==''){
	        $mod_act_url="index.php?mod=".$mod."&act=index";
	    }
	    elseif(empty($arr)){
	        $mod_act_url="index.php?mod=".$mod."&act=".$act;
	    }
	    else{
	        $mod_act_url="index.php?mod=".$mod."&act=".$act.arr2param($arr);
	    }
	}
	elseif($wjt==1){
		global $alias_mod_act_arr;  //链接别名数组
		if(!isset($alias_mod_act_arr)){
			$alias_mod_act_arr=dd_get_cache('alias');
		}
		$dir=$mod.'/'.$act;
		if(is_array($alias_mod_act_arr[$dir])){
		    $mod=$alias_mod_act_arr[$dir][0];
			$act=$alias_mod_act_arr[$dir][1];
		}
		unset($alias_mod_act_arr);
		if($act==''){
	        $mod_act_url=$mod."/index.html";
	    }
	    elseif(empty($arr)){
	        $mod_act_url=$mod.'/'.$act.'.html';
	    }
	    else{
			$mod_act_url='';
			$url='';
			foreach($arr as $k=>$v){
			    $url.=rawurlencode($v).'-';
			}
		    $mod_act_url=$mod.'/'.$act.'-'.$url;
		    $mod_act_url=str_del_last($mod_act_url).'.html';
	    }
	}
	if(defined('INDEX') && $mod=='index' && $act=='index'){
		$mod_act_url='';
	}
	
	/*if(strpos($mod_act_url,'%23')!==false){
		$mod_act_url=str_replace('%23','#',$mod_act_url);
	}*/
    return $mod_act_url;
}

function jump($url = '',$word='') {
	if(defined('AJAX') && AJAX==1) {
		if($word!=''){
		    $arr=array('s'=>0,'id'=>$word);
		}
		else{
		    $arr=array('s'=>1);
		}
		echo json_encode($arr);
		dd_exit();
    }
    else{
	    if($word!=''){
		    if(is_numeric($word)){
				global $errorData;
			    $alert="alert('" . $errorData[$word] . "');";
			}
			else{
			    $alert="alert('" . $word . "');";
			}
		}
	    else {
			$alert='';
		}
        if($url==-1){
        	$url=$_SERVER["HTTP_REFERER"];
        }
	    if (is_numeric($url)) {
		    echo script($alert.'history.go('.$url.');');
	    } else {
            echo script($alert.'window.location.href="' . $url . '";');
			//echo '<meta http-equiv="Refresh" content="0; url='.$url.'" />';
	    }
	    dd_exit();
	}
}

function def($tag,$data=array(),$parame=array()){
	$default_data=dd_get_cache('tao_goods','array');
	switch($tag){
		case 'dingdaning':
			$default_data=$default_data[$tag];
			foreach($default_data as $row){
				$data[$row['wz']]['num_iid']=$row['num_iid'];
				$data[$row['wz']]['item_title']=$row['title'];
				$data[$row['wz']]['fxje']=$row['fxje'];
				$data[$row['wz']]['gourl']=u('tao','view',array('iid'=>$row['num_iid']));
			}
		break;
		
		case 'tao_hot_goods':
			$default_data=$default_data[$tag];
			if(is_array($default_data) && !empty($default_data)){
				foreach($default_data as $row){
					$data[$row['wz']]['num_iid']=$row['num_iid'];
					$data[$row['wz']]['title']=$row['title'];
					$data[$row['wz']]['pic_url']=$row['pic_url'];
					$data[$row['wz']]['price']=$row['price'];
					$data[$row['wz']]['fxje']=fenduan($row['commission'],$parame['fxbl'],$parame['user_level']);
					$data[$row['wz']]['gourl']=u('tao','view',array('iid'=>$row['num_iid']));
				}
			}
		break;
		
		case 'tao_zhe_goods':
			$default_data=$default_data[$tag];
			if(is_array($default_data) && !empty($default_data)){
				foreach($default_data as $row){
					$data[$row['wz']]['num_iid']=$row['num_iid'];
					$data[$row['wz']]['title']=$row['title'];
					$data[$row['wz']]['pic_url']=$row['pic_url'];
					$data[$row['wz']]['price']=$row['price'];
					$data[$row['wz']]['coupon_price']=$row['coupon_price'];
					$data[$row['wz']]['coupon_end_time']=$row['coupon_end_time'];
					$data[$row['wz']]['coupon_fxje']=fenduan($row['coupon_commission'],$parame['fxbl'],$parame['user_level']);
					$data[$row['wz']]['gourl']=u('tao','view',array('iid'=>$row['num_iid']));
				}
			}
		break;
	}
	return $data;
}

function dd_glob($dir){
	if(!preg_match('/.*\/$/',$dir)){
		$dir.='/';
	}
	$a=array();
	$b=array();
	$a=glob($dir.'*');
	$b=glob($dir.'.*');
	foreach($b as $k=>$v){
		if($v==$dir.'.' || $v==$dir.'..'){
			unset($b[$k]);
		}
	}
	if(empty($a)){
		return $b;
	}
	elseif(empty($b)){
		return $a;
	}
	else{
		return array_merge($a,$b);
	}
}

function dd_set_cache($name,$arr,$type='json'){
	switch($type){
		case 'json':
			$data=PHP_EXIT.json_encode($arr);
			dd_file_put(DDROOT .'/data/json/' . $name . '.php', $data);
		break;
		case 'array':
			$data = "<?php\n return " . var_export($arr, true) . ";\n?>";
			dd_file_put(DDROOT .'/data/array/' . $name . '.php', $data);
		break;
	}
}

function dd_get_cache($name,$type='json'){
	switch($type){
		case 'json':
			$data=file_get_contents(DDROOT .'/data/json/' . $name . '.php');
			$data=preg_replace('/^'.PHP_EXIT_PREG.'/','',$data);
			$data=json_decode($data,1);
		break;
		case 'array':
			$data = include(DDROOT .'/data/array/' . $name . '.php');
		break;
	}
	return $data;
}

function in_tao_cat($cid){
	$tao_cat=include(DDROOT.'/data/tao_cat.php');
    foreach($tao_cat as $k=>$v){
	    if(in_array($cid,$v)){
		    return $k;
	    }
    }
	return 999;
}

function get2var(){
	foreach($_GET as $k=>$v){
		global $$k;
		$$k=$v;
	}
}

function post2var($arr=array(),$strict=0){
	$re=1;
	foreach($_POST as $k=>$v){
		if($v==='' && $strict==1){ //严格检测post，不准有空
			$re=0;
			break;
		}
		global $$k;
		$$k=htmlspecialchars($v);
		if(!empty($arr)){
			$arr=array_diff($arr,array($k));
		}

	}
	if(!empty($arr)){  //严格检测post，不准不存在
		if(count($arr)>0){
		    $re=0;
	    }
	}
	return $re;
}

function dd_file_put($file,$data,$mode=FILE_USE_INCLUDE_PATH){
	if($mode!=FILE_APPEND && is_file($file)) unlink($file);
	return file_put_contents($file,$data,$mode);
}
?>