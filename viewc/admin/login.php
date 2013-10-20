<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="<?php echo $data['rootUrl']; ?>css/reset.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $data['rootUrl']; ?>css/common.css" type="text/css" />
<link href="<?php echo $data['rootUrl']; ?>css/bootstrap.min.css" type="text/css" rel="stylesheet" />
<link rel="stylesheet" href="<?php echo $data['rootUrl']; ?>css/css-login.css" type="text/css" media="screen" /> 
<title>登录</title>
</head>
<body>
<form name="f" method="post" action="<?php echo $data['rootUrl']; ?>admin/loging">
<fieldset class="br">
	
	<legend><img src="<?php echo $data['rootUrl']; ?>img/lock_48.png" style="margin-left:10px;"></legend>
	
	<table cellspacing="0" cellpadding="0">
	<tr>
		<td><label for="user">用户名</label></td>
		<td><input type="text" name="user" id="user" autofocus="autofocus" /></td>
	</tr>
	<tr>
		<td><label for="pw">密码</label></td>
		<td><input type="password" name="pw" id="pw" /></td>
	</tr></table>
	 <!--label><input class="l" type="checkbox" name="ispersis" id="ispersis" value="1" />记住我</label-->
	 <br class="cl" />
	<input class="btn btn-primary r" type="submit" value=" 登 录">
	
	
	<br class="cr" />
	
	<div class="back"><a href="<?php echo $data['rootUrl']; ?>">&laquo;返回首页</a></div>
	
</fieldset>
</form>
</body>
</html>
