<h3>信息提示</h3>
<div class="infobox">
<?php if($state==3){ $redtime=0;?>
  <h4 class="infotitle1"><?php echo $download_file?>正在更新到程序中</h4>
<?php }elseif($state==1){$redtime=5000;?>
  <h4 class="infotitle1">源程序中的<?php echo $download_file?>文件备份失败</h4>
<?php }elseif($state==2){$redtime=5000;?>
  <h4 class="infotitle1">备份成功,但是<?php echo $download_file?>文件更新覆盖失败</h4>
<?php }elseif($state==4){$redtime=5000;?>
  <h4 class="infotitle1"><?php echo $download_file?>文件的MD5不一致可能文件改动过，但是仍然覆盖成功了</h4>
<?php }elseif($state==5){$redtime=5000;?>
  <h4 class="infotitle1">要更新的<?php echo $download_file?>文件不存在</h4>
<?php }?>
  <img src="images/ajax_loader.gif" class="marginbot" />
  <p class="marginbot"><a href="<?php echo $url?>" class="lightlink">如果您的浏览器没有自动跳转，请点击这里</a></p>
  
</div>
<script type="text/javascript">
setTimeout("redirect('<?php echo $url?>')", <?php echo $redtime?>);
function redirect(url) {
	window.location.replace(url);
}
</script>