<?php include(ADMINTPL.'/header.tpl.php');?>
<style>
ul{ list-style:none; padding:0px; margin:0px; margin-top:20px}
ul li{ margin-bottom:5px; font-size:14px}
</style>
<div class="explain-col">如果您修改过程序文件，需要从新更新文件记录，然后在 <a href="<?=u('data','list')?>">数据库管理</a> 中备份表<?=BIAOTOU?>file，下载到本地留存。</div>
<div style="width:100%; padding-left:20px">
<div style="width:420px; margin-top:20px; font-size:20px; font-weight:bold; color:#990000; ">多多返利系统文件校对器 V1.0</div>
<form action="" method="get" >
<input type="hidden" name="mod" value="<?=MOD?>" />
<input type="hidden" name="act" value="<?=ACT?>" />
<div>
<ul>
<?php if($_GET['sub']!=''){?>
  <?php if(empty($record_arr )){echo '<b>当前所查文件夹文件没有变化！</b>';}?>
  <?php foreach($record_arr as $row){?>
  <li><span style="font-size:12px;font-family:wingdings">2</span>&nbsp;<?=$row['path']?> &nbsp;&nbsp;<?=$row['msg']?> &nbsp;&nbsp;&nbsp;&nbsp; <a onclick='return confirm("确定要删除?")' href="<?=u('scan','do',array('del'=>1,'filename'=>DDROOT.'/'.$row['path']))?>">删除</a> <a href="<?=u('scan','do',array('see'=>1,'filename'=>DDROOT.'/'.$row['path']))?>">查看</a></li>
  <?php }?>
<?php }else{?>
  <li><input type="checkbox" onClick="checkAll(this,'dir[]')" /> 选择（选择您要校对的文件夹，不支持中文）</li>
  <?php foreach($filelists1 as $filename){?>
  <li><input type="checkbox" name="dir[]" value="<?=DDROOT.'/'.$filename?>" /><span style="font-size:12px;font-family:wingdings">1</span>&nbsp;<?=$filename?></li>
  <?php }?>
  <?php foreach($filelists2 as $filename){?>
  <li><input type="checkbox" name="dir[]" value="<?=DDROOT.'/'.$filename?>" /><span style="font-size:12px;font-family:wingdings">2</span>&nbsp;<?=$filename?></li>
  <?php }?>
  <input type="submit" name="sub" value="提交" /> <label><input type="checkbox" value="1" name="update" /> 更新文件记录</label>
<?php }?>

</ul>
</div>
</form>
</div>
<?php include(ADMINTPL.'/footer.tpl.php');?>