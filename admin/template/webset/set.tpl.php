<?php include(ADMINTPL.'/header.tpl.php');?>
<script>
$(function(){
	KindEditor.options.filterMode = false;
	editor = KindEditor.create('#banquan');
});

</script>
<form action="index.php?mod=webset&act=set" style="font-size:12px" method="post" name="form1">
<table id="addeditable"  align="center" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="125px" align="right" bgcolor="#efefef">网站开关：</td>
   	<td bgcolor="#efefef">&nbsp;
      <label><input type="radio" name="webclose" value="0" <?php if($webset['webclose']=='0') echo "checked=\"checked\"";?> />正常</label> 
      <label><input type="radio" name="webclose" value="1" <?php if($webset['webclose']=='1') echo "checked=\"checked\"";?>/>关闭</label>
    </td>
  </tr>
  <tr>
    <td align="right" bgcolor="#efefef" >关闭时显示的信息：</td>
   	<td bgcolor="#efefef">&nbsp;
    <textarea name="webclosemsg" cols="40" rows="3" class="btn3" style="width:400px"><?php echo $webset['webclosemsg'];?></textarea></td>
  </tr>
  <tr>
    <td align="right">网站logo：</td>
    <td>&nbsp;
    <input name="logo" type="text" value="<?=LOGO?>" id="logo" class="btn3" style="width:400px" /> <input class="sub" type="button" value="上传logo" onclick="javascript:openpic('<?=u('fun','upload',array('uploadtext'=>'logo','sid'=>session_id()))?>','upload','450','350')" />
  默认模板logo大小：232*79</td>
  <tr>
    <td align="right">网站名称：</td>
    <td>&nbsp;
    <input name="webname" type="text" value="<?=WEBNAME?>" class="btn3" style="width:400px" />&nbsp;如：多多返现建站系统
  </td>
  </tr>
  <tr>
    <td align="right">网站昵称：</td>
    <td>&nbsp;
    <input name="webnick" type="text" value="<?=WEBNICK?>" class="btn3" style="width:400px" />&nbsp;如：多多
  </td>
  </tr>
  <tr>
    <td align="right">网站标题：</td>
    <td>&nbsp;
<input name="title" type="text" value="<?=TITLE?>" class="btn3" style="width:400px" />&nbsp;首页标题 【<a href="<?=u('seo','list')?>">SEO优化</a>】【<a href="http://bbs.duoduo123.com/read-htm-tid-69529-ds-1.html" target="_blank">问题排查</a>】</td>
                   	</tr>
					  <tr>
                        <td align="right">网站关键字：</td>
                        <td>&nbsp;
                        <input name="keyword" type="text" class="btn3" style="width:400px" value="<?=KEYWORD?>" size="40" maxlength="100" />&nbsp;采用半角 , 隔开【<a href="<?=u('seo','list')?>">SEO优化</a>】</td>
                      </tr>
					   <tr>
                        <td align="right">网站描述：</td>
<td>&nbsp;
                          <textarea name="description" rows="3" class="btn3" id="description" style="width:400px"><?=DESCRIPTION?></textarea></td>
                      </tr>
					  <tr>
                        <td align="right">网址（全）：</td>
						<td>&nbsp;
                          <input name="url" type="text" id="url" value="<?=URL?>" size="40" class="btn3" style="width:400px" />
                          如 www.duoduo123.com                          不带http:// 后面不带/
                        </td>
                      </tr>
                      <tr>
                        <td align="right">目录：</td>
						<td>&nbsp;
                          <input name="url_mulu" type="text" id="url_mulu" value="<?=defined('URLMULU')?URLMULU:str_replace($_SERVER['HTTP_HOST'],'',URL);?>" size="40" class="btn3" style="width:400px" />
                          假如您的网站使用二级目录，如http://www.baidu.com/fanli 这里填写“/fanli”，没有请留空
                        </td>
                      </tr>
					   <tr>
                        <td align="right">站长email：</td>
<td>&nbsp;
<input name="email" type="text" id="email" value="<?=$webset['email']?>"  class="btn3" style="width:400px" /></td>
                    </tr>
					   <tr>
                        <td align="right">站长qq：</td>
<td>&nbsp;
                          <input name="qq" type="text" id="qq" value="<?=$webset['qq']?>" class="btn3" style="width:400px" /></td>
                      </tr>
					  <tr>
					    <td align="right">网站域名：</td>
<td>&nbsp;
					      <input name="surl" type="text" id="surl" value="<?=SURL?>" class="btn3" style="width:400px" />
					      如 duoduo123.com 不带http://</td>
					    </tr>
                        
                        <tr>
					    <td align="right">推广地址：</td>
<td>&nbsp;
					      <input name="tgurl" type="text" id="tgurl" value="<?=$webset['tgurl']?>" class="btn3" style="width:400px" />
					      例：http://<?php echo URL;?>/index.php?</td>
					    </tr>
                      <tr>
                        <td align="right">网页压缩输出：</td>
                        <td>&nbsp;
                          <label>
                          <select name="gzip">
                            <option value="1" <?php if($webset['gzip']=="1") echo "selected";?>>开启</option>
                            <option value="0" <?php if($webset['gzip']=="0") echo "selected";?>>关闭</option>
                          </select>
                         </label><span style="color:#FF6600">先关闭此项，检测您的主机是否默认支持此功能，如果没有，再选择开启。<a target="_blank" href="http://gzip.zzbaike.com/">检测网站</a></span>
                        </td>
                      </tr>
                      
                      <tr>
                        <td align="right">提示登陆：</td>
                        <td>&nbsp;
                          <label>
                          <select name="login_tip">
                            <option value="1" <?php if($webset['login_tip']=="1") echo "selected";?>>开启</option>
                            <option value="0" <?php if($webset['login_tip']=="0") echo "selected";?>>关闭</option>
                          </select>
                         </label><span style="color:#FF6600">跳转到淘宝/商城前，如未登录状态，会提示会员登陆</span>
                        </td>
                      </tr>
                      <tr>
                        <td align="right">替换策略：</td>
                        <td>&nbsp;
                          <label>
                          <select name="replace">
                            <option value="0" <?php if(REPLACE=="0") echo "selected";?>>模式0</option>
                            <option value="1" <?php if(REPLACE=="1") echo "selected";?>>模式1</option>
                            <option value="2" <?php if(REPLACE=="2") echo "selected";?>>模式2</option>

                          </select>
                         </label><span style="color:#FF6600">模式0为不替换，模式1为替换敏感词，模式2为停止网页</span>
                        </td>
                      </tr>
                      <tr>
                        <td align="right">sql日志：</td>
                        <td>&nbsp;
                          <label>
                          <select name="sql_log">
                            <option value="0" <?php if($webset['sql_log']=="0") echo "selected";?>>关闭</option>
                            <option value="1" <?php if($webset['sql_log']=="1") echo "selected";?>>开启</option>
                          </select>
                         </label><span style="color:#FF6600">开启sql日志会对性能有影响。保存路径 /data/temp/sql</span>
                        </td>
                      </tr>
                      <tr>
                        <td align="right">sql调试：</td>
                        <td>&nbsp;
                          <label>
                          <select name="sql_debug">
                            <option value="0" <?php if($webset['sql_debug']=="0") echo "selected";?>>关闭</option>
                            <option value="1" <?php if($webset['sql_debug']=="1") echo "selected";?>>开启</option>
                          </select>
                         </label><span style="color:#FF6600">技术人员调试sql错误输出，普通站长不要开启</span>
                        </td>
                      </tr>
                      <tr>
                        <td align="right">评论间隔：</td>
						<td>&nbsp;&nbsp;<input name="comment_interval" type="text" id="comment_interval" value="<?=$webset['comment_interval']?>" class="btn3" /> 单位【秒】 会员对网站评价间隔时间（商城，分享）</td>
                      </tr>
					   <tr>
                        <td align="right">默认模板文件：</td>
                      <td>&nbsp;
                     <select name="moban">
<?php 
$dir = "../template/";  // 文件夹的名称 

if (is_dir($dir)){ 
    if ($dh = opendir($dir)){ 
        while (($file = readdir($dh)) !== false){ 
            if($file!="."&&$file!="..")
			{
				if(MOBAN==$file){
				echo "<option value=".$file." selected>$file</option>";}
				else
				{echo "<option value=".$file.">$file</option>";}
			}
        } 
        closedir($dh); 
    } 
} 
?>     
                          </select>
                     &nbsp;默认只提供一套 &nbsp;&nbsp;(请将模板文件夹放置到网站template文件夹下) <a href="http://union.zhubajie.com/?u=2371018" target="_blank">威客定制</a> <a href="http://soft.duoduo123.com/plus/view.php?aid=66" target="_blank">官方定制</a></td>
                      </tr>
                      <tr>
                        <td height="50" align="right">底部版权：</td>
                        <td height="50">&nbsp;
                          <textarea name="banquan" id="banquan" style="width:680px"><?=$webset['banquan']?></textarea></td>
                      </tr>
					   <tr>
                        <td height="50" align="right">统计代码申请：</td>
<td height="50">&nbsp;<a href="http://new.cnzz.com/user/reg.php?b951a832370420ba4a334e07b526d84a" target="_blank">CNZZ</a><a href="http://www.linezing.com/" target="_blank">&nbsp;&nbsp;&nbsp;量子</a>&nbsp;&nbsp;<a href="http://tongji.baidu.com/hm-web/welcome/login" target="_blank">百度</a></td>
                      </tr>
					  <tr>
					  <td align="right" bgcolor="#efefef">会员等级设置：</td>
                      <td bgcolor="#efefef">&nbsp;
                      <?php foreach($webset['level'] as $k=>$v){?>
                      <input type="text" name="level_name[]" value="<?=$v?>" style="width:60px; font-family:'宋体'" />：<input name="level_dengji[]" type="text"  value="<?=$k?>"  class="required" num="y" style="width:30px; font-family:'宋体'" />
                      <?php }?>
                     <span class="STYLE1">（一次成功的交易积1点等级）</span></td>
                      </tr><tr>
                        <td align="right" bgcolor="#efefef">淘宝返现比率：</td>
                      <td bgcolor="#efefef">&nbsp;
                      <?php foreach($webset['fxbl'] as $k=>$v){?>
                      <?=$webset['level'][$k]?><input name="fxbl[]" type="text" id="fxbl" value="<?php echo $v*100;?>" size="10"  class="required" num="y" style="width:50px" />&nbsp;%&nbsp;&nbsp;
                      <?php }?>
                      <a href="http://bbs.duoduo123.com/read.php?tid=4417" target="_blank" style="color:#FF6600" >什么是会员等级</a></td>
                      </tr>
					  <tr>
                        <td align="right" bgcolor="#efefef">商城返现比率：</td>
                      <td bgcolor="#efefef">&nbsp;
                      <?php foreach($webset['mallfxbl'] as $k=>$v){?>
                      <?=$webset['level'][$k]?$webset['level'][$k]:'普通会员'?><input name="mallfxbl[]" type="text" id="mallfxbl" value="<?php echo $v*100;?>" size="10"  class="required" num="y" style="width:50px" />&nbsp;%&nbsp;&nbsp;
                      <?php }?>
                      </td>
                      </tr>
                      <tr>
                        <td align="right" bgcolor="#efefef">拍拍返现比率：</td>
                      <td bgcolor="#efefef">&nbsp;
                      <?php foreach($webset['paipaifxbl'] as $k=>$v){?>
                      <?=$webset['level'][$k]?$webset['level'][$k]:'普通会员'?><input name="paipaifxbl[]" type="text" id="paipaifxbl" value="<?php echo $v*100;?>" size="10"  class="required" num="y" style="width:50px" />&nbsp;%&nbsp;&nbsp;
                      <?php }?>
                      </td>
                      </tr>
                      <tr>
                        <td align="right" bgcolor="#efefef">推广佣金比率：</td>
<td bgcolor="#efefef">&nbsp;
                          <input name="tgbl" type="text" id="tgbl" value="<?php echo $webset['tgbl']*100;?>"  class="required" num="y" style="width:100px" />
                          %
  （填写0-100）如 10% 表示给会员返利的10%，支付给推广人的部分</td>
                      </tr>
                      <tr>
                        <td align="right" bgcolor="#efefef">好友提现奖励：</td>
<td bgcolor="#efefef">&nbsp;
                          <input name="hytxjl" type="text" id="hytxjl" value="<?php echo $webset['hytxjl'];?>"  class="required" num="y" style="width:100px" /> 
                          元
  &nbsp;某会员第一次提现，给其推荐人的额外奖励（填写0为不奖励）</td>
                      </tr>
					   <tr>
                        <td align="right" bgcolor="#efefef">提现最低限额：</td>
<td bgcolor="#efefef">&nbsp;
                          <input name="tixian_limit" type="text" id="tixian_limit" value="<?=$webset['tixian_limit']?>"  class="required" num="y" style="width:100px" /> 
                        元</td>
                      </tr>
					   <tr>
                        <td align="right" bgcolor="#efefef">提现必须是：</td>
<td bgcolor="#efefef">&nbsp;
                          <input name="txxz" type="text" id="txxz" value="<?=$webset['txxz']?>"  class="required" num="y" style="width:100px" /> 
                        的整数倍（0 表示不限制）</td>
                      </tr>
                      <tr>
                        <td align="right" bgcolor="#efefef">返积分比例：</td>
<td bgcolor="#efefef">&nbsp;
                          <input name="jifenbl" type="text" id="jifenbl" value="<?php echo $webset['jifenbl']*100;?>"  class="required" num="y" style="width:50px" />% 返利同时赠送一定比例的积分，按照实际给会员的返利计算，取整。例如比例为1000%，返利0.1元，积分就是1
                        </td>
                      </tr>
                      <tr>
                        <td colspan="2" align="left" bgcolor="#efefef"><span style="padding-left:27px; color:#FF0000">友情提示：①推广佣金比例+返现比例&lt;=90%。②注册赠送金额建议填“0”。</span></td>                        
                        </tr>
                      <tr>
                        <td align="right">&nbsp;</td>
                  <td>&nbsp;
                          <input type="submit" class="myself" name="sub" value=" 保 存 设 置 " /> 
                          </td>
                      </tr>
                    </table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>