<?php
/*
 * Copyright (c) 2011 by YinXiangMa.com
 * Author: HongXiang Duan
 * Created: 2011-5-5
 * Function: YinXiangMa API php code
 * Version: v1.0
 *
 * PHP library for YinXiangMa - 印象码 - 流媒体视频广告验证码云服务平台.
 *    - Documentation and latest version
 *          http://www.YinXiangMa.com/
 *    - Get a YinXiangMa API Keys
 *          http://www.YinXiangMa.com/server/signup
 */


/********************************************************************************************
 * 以下内容，不需要进行改动。并且，请不要改动。如果改动，可能会有错误发生。
 * "印象码 - 流媒体视频广告验证码云服务平台"。
 ********************************************************************************************
 */

/**
 * The YinXiangMa server URL's。
 */
require_once ("YinXiangMaLocalConfig.php");
define("YinXiangMa_API_SERVER",        "http://www.yinxiangma.com");
define("YinXiangMa_API_SECURE_SERVER", "https://www.yinxiangma.com/");
define("YinXiangMa_REGISTER",          "http://www.yinxiangma.com/server/register.php");
define("YinXiangMa_Version",		   "YinXiangMaVERSION1.0");

dd_session_start(); // this MUST be called prior to any output including whitespaces and line breaks!

/**
 * Encodes the given data into a query string format
 * @param $data - array of string elements to be encoded
 * @return string - encoded requestuest
 */
function YinXiangMa_qsencode ($data) {
	$request = "";
	foreach ( $data as $key => $value )
			$request .= $key . '=' . urlencode( stripslashes($value) ) . '&';

	// Cut the last '&'
	$request=substr($request,0,strlen($request)-1);
	return $request;
}

/**
 * Submits an HTTP POST to a YinXiangMa server
 * @param string $host
 * @param string $path
 * @param array $data
 * @param int port
 * @return array response
 */
function YinXiangMa_http_post($host, $path, $data, $port = 80) {
	$request = YinXiangMa_qsencode ($data);

	$http_request  = "POST $path HTTP/1.0\r\n";
	$http_request .= "Host: $host\r\n";
	$http_request .= "Content-Type: application/x-www-form-urlencoded;\r\n";
	$http_request .= "Content-Length: " . strlen($request) . "\r\n";
	$http_request .= "User-Agent: YinXiangMa/PHP\r\n";
	$http_request .= "\r\n";
	$http_request .= $request;

	$response = '';
	if( false == ( $fs = @fsockopen($host, $port, $errno, $errstr, 5) ) ) {
			return ('socket_unavailable'); exit;
	}

	fwrite($fs, $http_request);

	while ( !feof($fs) )
			$response .= fgets($fs, 1024); // One TCP-IP packet [sic]
	fclose($fs);
	$response = explode("\r\n\r\n", $response, 2);

	return $response;
}

/**
  * Calls an HTTP POST function to retrieve token from YinXiangMa server
  * @param boolean $use_ssl Should the requestuest be made over ssl? (optional, default is false)
  * @return the retrieved token from YinXiangMa server
  */
function YinXiangMa_tokenRequest($use_ssl = false)
{
	if (!defined('PUBLISHER_KEY') || PUBLISHER_KEY == "") {
		die ("为了使用 印象码 视频验证码广告系统， 你必须注册并拥有一个 KEY，请注册： <a href='" . YinXiangMa_REGISTER . "'>" . YinXiangMa_REGISTER . "</a>");
	}

	if ($use_ssl) {
                $server = YinXiangMa_API_SECURE_SERVER;
				$protocol = "https";
    } else {
                $server = YinXiangMa_API_SERVER;
				$protocol = "http";
    }
	
	YinXiangMaSetcookie($_SERVER['HTTP_HOST'],$_SERVER['REQUEST_URI']);
	
	$publisher_id=PUBLISHER_KEY;
	$userAgent=$_SERVER['HTTP_USER_AGENT'];
	$ip=$_SERVER['REMOTE_ADDR'];
	$page="$protocol://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	$cookie=$_COOKIE['YinXiangMaCookie'];
	$version=YinXiangMa_Version; 
	$mode=YinXiangMa_MODE;
		
	$YinXiangMa_token_parameters=array ( 
									's' => $publisher_id,
									'u' => $userAgent,		
									'i' => $ip,
									'p' => $page,
									'o' => $cookie,
									'v' => $version,
									'm' => $mode,
									);
					  
	$token_array=YinXiangMa_http_post("www.yinxiangma.com","/api/yzm.token.php",$YinXiangMa_token_parameters);
	if(($token_array=="") || ($token_array=="socket_unavailable") || (strstr($token_array[1],"apiserver") == false))
	{
		$YinXiangMa_LocalYzmToken=MD5(mktime(date("G"), date("i"), date("s"), date("m")  , date("d"), date("Y")));
		$LocalYzmTokenString='{"token":"'.$YinXiangMa_LocalYzmToken.'","refresh_time":"'."120".'","theme":"'."white".'","size":"'."300x168".'","lang":"'."chinese".'","type":"'."local".'","apiserver":"'.YinXiangMa_API_LOCAL_YZM_SERVER.'","mediaserver":"'.YinXiangMa_API_LOCAL_YZM_PATH.'"}';
		
		$_SESSION["YinXiangMa_LocalYzmToken"]=$YinXiangMa_LocalYzmToken;
		return $LocalYzmTokenString;
		exit;
	}
		  
	return $token_array[1];
}

/**
 * set cookie to have the accurate advertising targetting
 */
function YinXiangMaSetcookie($domain = '', $path = '/') {
	if (empty($_COOKIE['YinXiangMaCookie'])) {    
		$value = md5(uniqid(rand(), true));
		if (!empty($domain) && $domain[0] != '.') {
			$domain = ".$domain";
		}
		
		if (setcookie('YinXiangMaCookie', $value, mktime(0, 0, 0, 1, 1, 2038), $path, $domain)) {
		  $_COOKIE['YinXiangMaCookie'] = $value;
		} 
	}
}

/**
 * A YinXiangMaResponse is returned from YinXiangMa_validRequest()
 */
class YinXiangMaResponse {
	var $is_valid;
	var $error;
}

/**
 * Calls an HTTP POST function to verify if the user's YzmInput was correct
 * @param string $YzmInput, the user's YzmInput for the yzm
 * @return YinXiangMaResponse
 */
function YinXiangMa_validRequest($YzmInput,$YinXiangMaToken)
{
	if($YzmInput == null || $YzmInput == "" || strlen($YzmInput) == 0)
	{
		$YinXiangMa_response = new YinXiangMaResponse();
		
		$YinXiangMa_response->is_valid = false;
		$YinXiangMa_response->error = 'NULL YzmInput';
		
		return $YinXiangMa_response;
	}
	
	if($YinXiangMaToken==$_SESSION["YinXiangMa_LocalYzmToken"]){
		$YinXiangMa_valid_host=YinXiangMa_API_LOCAL_YZM_SERVER;
		$YinXiangMa_valid_api=YinXiangMa_API_LOCAL_YZM_VALID_PATH;
	} else {
		$YinXiangMa_valid_host="www.yinxiangma.com";
		$YinXiangMa_valid_api="/api/yzm.valid.php";
	}
	
	$YinXiangMa_valid_parameters=array (
									 's' => PUBLISHER_KEY,
									 't' => $YinXiangMaToken,
									 'i' => $YzmInput,
									 );
	
	$valid_response_array=YinXiangMa_http_post($YinXiangMa_valid_host,$YinXiangMa_valid_api,$YinXiangMa_valid_parameters);		
	$valid_response = explode ("+", $valid_response_array[1]);
	$YinXiangMa_response = new YinXiangMaResponse();	
	
	if (trim ($valid_response[0]) == 'true') {
			$YinXiangMa_response->is_valid = true;
	}
	else {
			$YinXiangMa_response->is_valid = false;
			$YinXiangMa_response->error = $valid_response[1];
	}
	return $YinXiangMa_response;
}
	
/**
 * Display YinXiangMa Widget
 */
function YinXiangMa_GetYinXiangMaWidget()
{
	$YinXiangMaDataString = YinXiangMa_tokenRequest();
	
	$YinXiangMaWidgetHtml="\n<script type='text/javascript'>\nvar YinXiangMaDataString ='".$YinXiangMaDataString."';\n</script>\n";
				
	$YinXiangMaWidgetHtml.="<script type='text/javascript' charset='gbk' src='".YinXiangMa_API_SERVER."/widget/"."YinXiangMa.php'></script>\n";
	
	$YinXiangMaWidgetHtml.=
	"<noscript>
		您的浏览器不支持或者禁用了Javascript，验证码将不能正常显示。<br/>
		点击这里，教您如何调整您的浏览器设置。<br/>
	</noscript>";
	
	return $YinXiangMaWidgetHtml;
}
 
?>