<?php include(ADMINTPL.'/header.tpl.php');?>
<style>
* {
	font-size: 12px;
	font-family: "宋体";
}

td { line-height: 1.5; }

body {
	font-size: 12px;
	line-height: 1.5;
	font-family: "宋体";
}
.dlg {
	border: 2px solid #749F4D;
	background-color: #F0FAEB;
	padding: 2px;
	width: 360px;
	line-height:160%;
}
</style>
<script language="javascript">
var myajax;
var newobj;
var posLeft = 300;
var posTop = 80;
function LoadUrl(surl){
  $.get("<?=u('data','list')?>&"+surl,function(data){
    $('#_mydatainfo').html(data).show();
  })
}
function HideObj(objname){
   var obj = document.getElementById(objname);
   obj.style.display = "none";
}

//获得选中文件的数据表

function getCheckboxItem(){
	 var myform = document.form2;
	 var allSel="";
	 if(myform.tables.value) return myform.tables.value;
	 for(i=0;i<myform.tables.length;i++)
	 {
		 if(myform.tables[i].checked){
			 if(allSel=="")
				 allSel=myform.tables[i].value;
			 else
				 allSel=allSel+","+myform.tables[i].value;
		 }
	 }
	 return allSel;
}

//反选
function ReSel(){
	var myform = document.form2;
	for(i=0;i<myform.tables.length;i++){
		if(myform.tables[i].checked) myform.tables[i].checked = false;
		else myform.tables[i].checked = true;
	}
}

//全选
function SelAll(){
	var myform = document.form2;
	for(i=0;i<myform.tables.length;i++){
		myform.tables[i].checked = true;
	}
}

//取消
function NoneSel(){
	var myform = document.form2;
	for(i=0;i<myform.tables.length;i++){
		myform.tables[i].checked = false;
	}
}

function checkSubmit()
{
	var myform = document.form2;
	myform.tablearr.value = getCheckboxItem();
	return true;
}

</script>
<div id="waiwei" style="position:relative"><div class="dlg" id="_mydatainfo" style="position:absolute;top:80px; left:300px; display:none"></div></div>
<table width="99%" border="0" cellpadding="3" cellspacing="1" bgcolor="#D1DDAA">
  <tr>
    <td height="19" colspan="8" background="img/tbg.gif" bgcolor="#E7E7E7">
    	<table width="96%" border="0" cellspacing="1" cellpadding="1">
        <tr>
          <td width="24%"><strong>数据库管理</strong></td>
          <td width="76%" align="right">
          <form action="ReData.php" method="get">
          	<b>数据还原</b>
            <select name="date"><?=$options?></select>
            <input type="submit" value="提交" class="coolbg np" />
            </form>
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <form name="form2" onSubmit="checkSubmit()" action="index.php?mod=data&act=list&dopost=bak&token=<?=$_SESSION['token']?>" method="post" target="stafrm">
  <input type='hidden' name='tablearr' value='' />
  <tr bgcolor="#F7F8ED">
    <td height="24" colspan="8"><strong>duoduo默认系统表：</strong></td>
  </tr>
  <tr bgcolor="#F2FFB5" align="center">
    <td height="24" width="5%">选择</td>
    <td width="20%">表名</td>
    <td width="8%">记录数</td>
    <td width="17%">操作</td>
    <td width="5%">选择</td>
    <td width="20%">表名</td>
    <td width="8%">记录数</td>
    <td width="17%">操作</td>
  </tr>
  <?php
  for($i=0; isset($duoduoSysTables[$i]); $i++)
  {
    $t = $duoduoSysTables[$i];
	$tablename=str_replace(BIAOTOU,'',$t);
    echo "<tr align='center'  bgcolor='#FFFFFF' height='24'>\r\n";
  ?>
    <td>
    	<input type="checkbox" name="tables" value="<?php echo $t; ?>" class="np" checked />
    </td>
    <td>
      <?php echo $t; ?>
    </td>
    <td>
      <?=$duoduo->count($tablename)?>
    </td>
    <td>
    <a href="javascript:" onClick="LoadUrl('dopost=opimize&tablename=<?php echo $t; ?>');">优化</a> |
    <a href="javascript:" onClick="LoadUrl('dopost=repair&tablename=<?php echo $t; ?>');">修复</a> |
    <a href="javascript:" onClick="LoadUrl('dopost=viewinfo&tablename=<?php echo $t; ?>');">结构</a>
    </td>
  <?php
   $i++;
   if(isset($duoduoSysTables[$i])) {
   	$t = $duoduoSysTables[$i];
	$tablename=str_replace(BIAOTOU,'',$t);
  ?>
    <td>
    	<input type="checkbox" name="tables" value="<?php echo $t; ?>" class="np" checked />
    </td>
    <td>
      <?php echo $t; ?>
    </td>
    <td>
      <?=$duoduo->count($tablename)?>
    </td>
    <td>
    <a href="javascript:" onClick="LoadUrl('dopost=opimize&tablename=<?php echo $t; ?>');">优化</a> |
    <a href="javascript:" onClick="LoadUrl('dopost=repair&tablename=<?php echo $t; ?>');">修复</a> |
    <a href="javascript:" onClick="LoadUrl('dopost=viewinfo&tablename=<?php echo $t; ?>');">结构</a>
  </td>
  <?php
   }
   else
   {
   	  echo "<td></td><td></td><td></td><td></td>\r\n";
   }
   echo "</tr>\r\n";
  }
  ?>
  <tr bgcolor="#F7F8ED">
    <td height="24" colspan="8"><strong>其它数据表：</strong></td>
  </tr>
  <tr bgcolor="#F9FEE2" align="center">
    <td height="24" width="5%">选择</td>
    <td width="20%">表名</td>
    <td width="8%">记录数</td>
    <td width="17%">操作</td>
    <td width="5%">选择</td>
    <td width="20%">表名</td>
    <td width="8%">记录数</td>
    <td width="17%">操作</td>
  </tr>
 <?php
  for($i=0; isset($otherTables[$i]); $i++)
  {
    $t = $otherTables[$i];
	$tablename=str_replace(BIAOTOU,'',$t);
    echo "<tr align='center'  bgcolor='#FFFFFF' height='24'>\r\n";
  ?>
    <td>
    	<input type="checkbox" name="tables" value="<?php echo $t; ?>" class="np" />
    </td>
    <td>
      <?php echo $t; ?>
    </td>
    <td>
      <?=$duoduo->count_orther($tablename)?>
    </td>
    <td>
    <a href="javascript:" onClick="LoadUrl('dopost=opimize&tablename=<?php echo $t; ?>');">优化</a> |
    <a href="javascript:" onClick="LoadUrl('dopost=repair&tablename=<?php echo $t; ?>');">修复</a> |
    <a href="javascript:" onClick="LoadUrl('dopost=viewinfo&tablename=<?php echo $t; ?>');">结构</a>
    </td>
  <?php
   $i++;
   if(isset($otherTables[$i])) {
   	$t = $otherTables[$i];
	$tablename=str_replace(BIAOTOU,'',$t);
  ?>
   <td>
    	<input type="checkbox" name="tables" value="<?php echo $t; ?>" class="np" />
    </td>
    <td>
      <?php echo $t; ?>
    </td>
    <td>
      <?=$duoduo->count_orther($tablename)?>
    </td>
    <td>
    <a href="javascript:" onClick="LoadUrl('dopost=opimize&tablename=<?php echo $t; ?>');">优化</a> |
    <a href="javascript:" onClick="LoadUrl('dopost=repair&tablename=<?php echo $t; ?>');">修复</a> |
    <a href="javascript:" onClick="LoadUrl('dopost=viewinfo&tablename=<?php echo $t; ?>');">结构</a>
  </td>
  <?php
   }else{
   	  echo "<td></td><td></td><td></td><td></td>\r\n";
   }
   echo "</tr>\r\n";
  }
  ?>
    <tr bgcolor="#FDFDEA">
      <td height="24" colspan="8">
      	&nbsp;
        <input name="b1" type="button" id="b1" class="coolbg np" onClick="SelAll()" value="全选" />
        &nbsp;
        <input name="b2" type="button" id="b2" class="coolbg np" onClick="ReSel()" value="反选" />
        &nbsp;
        <input name="b3" type="button" id="b3" class="coolbg np" onClick="NoneSel()" value="取消" />
      </td>
  </tr>
  <tr bgcolor="#F7F8ED">
    <td height="24" colspan="8"><strong>数据备份选项：</strong></td>
  </tr>
  <tr align="center" bgcolor="#FFFFFF">
    <td height="50" colspan="8">
    	  <table width="90%" border="0" cellspacing="0" cellpadding="0">
          <tr align="left">
            <td height="30">当前数据库版本： <?php echo $mysql_version?></td>
          </tr>
          <tr align="left">
            <td height="30">
            	指定备份数据格式：
              <input name="datatype" type="radio" class="np" value="4.0"<?php if($mysql_version<4.1) echo " checked='1'";?> />
              MySQL3.x/4.0.x 版本
              <input type="radio" name="datatype" value="4.1" class="np"<?php if($mysql_version>=4.1) echo " checked='1'";?> />
              MySQL4.1.x/5.x 版本
              </td>
          </tr>
          <tr align="left">
            <td height="30">
            	分卷大小：
              <input name="fsize" type="text" id="fsize" value="1024" size="6" />
              K&nbsp;，
              <input name="isstruct" type="checkbox" class="np" id="isstruct" value="1" checked='1' />
              备份表结构信息
              <?php  if(@function_exists('gzcompress') && false) {  ?>
              <input name="iszip" type="checkbox" class="np" id="iszip" value="1" checked='1' />
              完成后压缩成ZIP
              <?php } ?>
              <input type="hidden" name="date" value="<?=date('Ymd')?>" />
              <input type="submit" name="sub" value="提交" class="coolbg np myself" />
             </td>
          </tr>
        </table>
      </td>
   </tr>
   </form>
  <tr bgcolor="#F7F8ED">
    <td height="24" colspan="8"><strong>进行状态：</strong></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="180" colspan="8">
	<iframe name="stafrm" frameborder="0" id="stafrm" width="100%" height="100%"></iframe>
	</td>
  </tr>
</table>
<?php include(ADMINTPL.'/footer.tpl.php');?>