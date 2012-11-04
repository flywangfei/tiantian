<table class="tb tb2 ">
  <tr class="header">
    <td class="red">程序已经升级到版本<?php echo $release?></td>
  </tr> 
</table>
<?php
if(judge_empty_dir(DDROOT.'/admin')==1){
	rmdir(DDROOT.'/admin');
}

dd_file_put(DDROOT.'/data/banben.php','<?php return '.$release.';?>');
$url=u(MOD,ACT,array('release'=>$release,'step'=>1));
$redtime=5000;
?>
<script type="text/javascript">
setTimeout("redirect('<?php echo $url?>')", <?php echo $redtime?>);
function redirect(url) {
	window.location.replace(url);
}
</script>