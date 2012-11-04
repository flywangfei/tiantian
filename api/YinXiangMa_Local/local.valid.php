<?php
require_once './modules/securimage/' . '/securimage.php';

$InputYzm=$i;

$message_yzm_success="success";
$message_yzm_wrong="yzm_wrong";

$securimage = new Securimage();

if ($securimage->check($InputYzm) == false) {
	$valid_result="false"; 
	$message=$message_yzm_wrong; 
	echo $valid_result.'+'.$message; 
}
else {
	$valid_result="true"; 
	$message=$message_yzm_success; 
	echo $valid_result.'+'.$message; 
}

exit;
?>