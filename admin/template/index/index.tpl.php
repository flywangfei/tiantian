<html>
<head>
<title>管理中心</title>
<meta http-equiv=Content-Type content=text/html;charset=utf-8>
</head>
<frameset rows="64,*" id="father"  frameborder="NO" border="0" framespacing="0">
  <frame src="<?=u('index','top')?>" noresize="noresize" frameborder="no" name="topFrame" scrolling="no" marginwidth="0" marginheight="0" target="main" />
  <frameset cols="200,*"  id="frame">
    <frame src="<?=u('index','left')?>" name="leftFrame" noresize="noresize" marginwidth="0" marginheight="0" frameborder="no" scrolling="yes" target="main" />
    <frame src="<?=u($_GET['go_mod'],$_GET['go_act'])?>" name="main" noresize="noresize" marginwidth="0" marginheight="0" frameborder="no" scrolling="yes" target="_self" />
  </frameset>
</frameset>
<noframes></noframes>
</html>