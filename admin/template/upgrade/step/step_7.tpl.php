<table class="tb tb2 ">
  <tr class="header">
    <td class="red">
    <?php
	include(DDROOT.'/update.php');
	unlink(DDROOT.'/update.php');
	?>
    <ol>
    <?php foreach($msg as $v){?>
      <li><?=$v?></li>
    <?php }?>
    </ol>
    </td>
  </tr> 
</table>
<?php
$url=u(MOD,ACT,array('release'=>$release,'step'=>8));
$redtime=5000;
?>
<script type="text/javascript">
setTimeout("redirect('<?php echo $url?>')", <?php echo $redtime?>);
function redirect(url) {
	window.location.replace(url);
}
</script>