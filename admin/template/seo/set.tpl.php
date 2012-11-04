<?php include(ADMINTPL.'/header.tpl.php');?>
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
  <tr>
    <td width="150px" align="right">url加密字符：</td>
    <td>&nbsp;<input name="urlencrypt" value="<?=URLENCRYPT?>"/> 为空表示不加密(设置后建议不要修改，适用于淘宝模块的list和view页面)</td>
  </tr>
  <tr>
                        <td align="right">伪静态开关：</td>
                        <td>&nbsp;
                          <label>
                          <select name="wjt">
                            <option value="1" <?php if(WJT=="1") echo "selected";?>>开启</option>
                            <option value="0" <?php if(WJT=="0") echo "selected";?>>关闭</option>
                          </select>
                          请确认您的主机支持伪静态，否则不要开启。
                          </label>
                        </td>
                      </tr>
                      <tr>
                        <td align="right">图片加密开关：</td>
                        <td>&nbsp;
                          <label>
                          <select name="picjm">
                            <option value="1" <?php if(PICJM=="1") echo "selected";?>>开启</option>
                            <option value="0" <?php if(PICJM=="0") echo "selected";?>>关闭</option>
                          </select>
                         </label><span style="color:#FF6600">图片加密会增加图片收录，同时损耗系统资源。</span>
                        </td>
                      </tr>
                      
                      <tr>
                        <td align="right">图片伪静态开关：</td>
                        <td>&nbsp;
                          <label>
                          <select name="picwjt">
                            <option value="1" <?php if(PICWJT=="1") echo "selected";?>>开启</option>
                            <option value="0" <?php if(PICWJT=="0") echo "selected";?>>关闭</option>
                          </select>
                         </label><span style="color:#FF6600">图片伪静态会耗费系统资源，虚拟主机禁止开启，服务器用户按需开启。</span>
                        </td>
                      </tr>
  <tr>
     <td align="right">&nbsp;</td>
     <td>&nbsp;<input type="submit" name="sub" value=" 保 存 设 置 " /></td>
  </tr>
  </form>
</table>

<?php include(ADMINTPL.'/footer.tpl.php');?>