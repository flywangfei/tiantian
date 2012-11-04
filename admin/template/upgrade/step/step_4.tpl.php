<table class="tb tb2 ">
    <tr class="header">
      <td colspan="3">版本<?php echo $release?>的本地文件列表</td>
    </tr>
    <tr>
      <td colspan="3"><input type="button" class="btn" onclick="confirm('覆盖更新前请您先备份程序及数据库(数据库请手动备份)，确定开始升级吗？') ? window.location.href='<?=u(MOD,ACT,array('release'=>$updaterelease,'step'=>5))?>' : '';" value="覆盖更新"></td>
    </tr>
    <?php foreach($updatefilelist as $key=>$vo){
		$file=UPGRADEROOT.'/'.$updaterelease."/uploads".$vo;
		?>
    <tr>
     <?php if(file_exists(iconv('utf-8','gbk',$file))){?>
      <td width="50px;">已经下载</td>
      <?php }else{?>
       <td width="50px;"><a title="多次尝试下载不了可以手动下载" href="<?=u(MOD,ACT,array('release'=>$release,'step'=>3,'fileseq'=>($key+1),'refurl'=>true))?>">重新下载</a></td>
       <?php }?>
        <?php if(file_exists(iconv('utf-8','gbk',$file))){?>
      <td width="39"><a title="不想更新本文件就删除" href="<?=u(MOD,ACT,array('release'=>$release,'step'=>4,'del'=>($key+1)))?>">删除</a></td>
      <?php }else{?>
      <td width="50" title="不想更新本文件、服务器上没本文件、网络、文件权限等原因下载不了">[未下载]</td>
       <?php }?>
      <td><em class="files bold"><?php echo $vo?></em></td>
    </tr>
    <?php }?>
    <tr>
      <td colspan="3"><b>文件存放目录:</b><?=UPGRADEROOT.'/'.$updaterelease?></td>
    </tr>
    <tr>
      <td colspan="3"><input type="button" class="btn" onclick="confirm('覆盖更新前请您先备份程序及数据库(数据库请手动备份)，确定开始升级吗？') ? window.location.href='<?=u(MOD,ACT,array('release'=>$updaterelease,'step'=>5))?>' : '';" value="覆盖更新"></td>
    </tr>
  </table>