<?php include(ADMINTPL.'/header.tpl.php');
/*$dir = DDROOT; //当前目录
$no_write_dir=array();

function list_file($dir,&$no_write_dir){
	if($dir==DDROOT.'/data' || $dir==DDROOT.'/upload'){return true;}
	$list = scandir($dir); // 得到该文件下的所有文件和文件夹
	foreach($list as $file){//遍历
		$file_location=$dir."/".$file;//生成路径
		if(is_dir($file_location) && $file!="." &&$file!=".."){ //判断是不是文件夹
			if()
			$no_write_dir[]=$file_location;
			list_file($file_location,$no_write_dir); //继续遍历
		}
	}
}

list_file($dir,$no_write_dir);

print_r($no_write_dir);*/
?>
<link href="css/upgrade.css" rel="stylesheet" type="text/css" />
<div id="append_parent"></div>
<div id="ajaxwaitid"></div>
<div class="container" id="cpcontainer">
  <div class="itemtitle">
    <h3>在线升级</h3>
    <ul class="tab1" style="margin-right:10px">
    </ul>
    <ul class="stepstat">
      <li <?php if($step==1){?>class="current"<?php }?> id="step1">1.版本选择</li>
      <li <?php if($step==2){?>class="current"<?php }?> id="step2">2.获取待更新文件列表</li>
      <li <?php if($step==3){?>class="current"<?php }?> id="step3">3.下载更新</li>
      <li <?php if($step==4){?>class="current"<?php }?> id="step4">4.本地文件比对</li>
      <li <?php if($step==5){?>class="current"<?php }?> id="step5">5.正在覆盖更新</li>
      <li <?php if($step==6){?>class="current"<?php }?> id="step6">6.覆盖后文件校对</li>
      <li <?php if($step==7){?>class="current"<?php }?> id="step7">7.数据库更新</li>
      <li <?php if($step==8){?>class="current"<?php }?> id="step8">8.升级完成</li>
    </ul>
    <ul class="tab1">
    </ul>
  </div>
  <?php include(ADMINROOT.'/template/upgrade/step/step_'.$step.'.tpl.php');?>
</div>
<?php include(ADMINTPL.'/footer.tpl.php');?>