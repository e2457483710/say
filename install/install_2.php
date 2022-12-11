<?php
if(file_exists("install.lock")){
	header('Location:http://lsoft.com/php_demo/new/install/install.html');
}
?>
<!doctype html>
<html class="no-js">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>LiRecord - 安装 - 第二步</title><meta name="renderer" content="webkit">
  <meta http-equiv="Cache-Control" content="no-siteapp"/>
  <link rel="icon" type="icon" href="../assets/i/favicon.ico">
  <meta name="mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">
  <link rel="stylesheet" href="../assets/css/amazeui.min.css">
  <link rel="stylesheet" href="../assets/css/app.css">
  <link rel="stylesheet" href="../assets/css/main.css">
</head>
<?php include("nav.php") ?>
<div id="content">
	<form action="" class="am-form" id="doc-vld-msg" method="post">
  <fieldset>
    <legend>安装 - LiRecord</legend>
    <div class="am-form-group">
      <label for="doc-vld-name-2-1">站点名称</label>
      <input type="text" name="sitename" id="doc-vld-name-2-1" maxlength="20" placeholder="输入站点名称(最长20个汉字)" data-validation-message="输入站点名称" required/>
    </div>
    
    <div class="am-form-group">
      <label for="doc-vld-name-2-1">站点域名</label>
      <input type="text" name="sitedomain" id="doc-vld-name-2-1" placeholder="输入站点域名(请不要添加http://)" data-validation-message="请输入站点域名" required/>
    </div>
    
    <div class="am-form-group">
      <label for="doc-vld-name-2-1">用户名</label>
      <input type="text" name="username" id="doc-vld-name-2-1" minlength="5" placeholder="输入用户名" data-validation-message="请输入至少5位字符的用户名" required/>
    </div>
    
    <div class="am-form-group">
      <label for="doc-vld-name-2-1">站长QQ</label>
      <input type="number" name="siteqq" id="doc-vld-name-2-1" minlength="5" maxlength="12" placeholder="输入QQ" data-validation-message="请输入5~12位数的QQ" required/>
    </div>
    
      <div class="am-form-group">
      <label for="doc-vld-email-2-1">邮箱</label>
      <input type="email" name="useremail" id="doc-vld-email-2-1" data-validation-message="请输入邮箱" placeholder="输入邮箱" required/>
    </div>
    
    <div class="am-form-group">
      <label for="doc-vld-age-2-1">密码</label>
      <input type="password" name="userpswd" id="doc-vld-age-2-1" placeholder="请输入8~18位非纯数字密码" min="8" max="18" required data-validation-message="请输入8~18位非纯数字密码"/>
    </div>	
	<input name="siteini" class="am-btn  am-btn-secondary" type="submit"/>
  </fieldset>
</form>
</div>
<!--[if (gte IE 9)|!(IE)]><!-->
<script src="../assets/js/jquery.min.js"></script>
<!--<![endif]-->
<!--[if lte IE 8 ]>
<script src="http://libs.baidu.com/jquery/1.11.3/jquery.min.js"></script>
<script src="http://cdn.staticfile.org/modernizr/2.8.3/modernizr.js"></script>
<script src="assets/js/amazeui.ie8polyfill.min.js"></script>
<![endif]-->
<script src="../assets/js/amazeui.min.js"></script>
	<script type="text/javascript">
	$(function() {
  $('#doc-vld-msg').validator({
    onValid: function(validity) {
      $(validity.field).closest('.am-form-group').find('.am-alert').hide();
    },

    onInValid: function(validity) {
      var $field = $(validity.field);
      var $group = $field.closest('.am-form-group');
      var $alert = $group.find('.am-alert');
      // 使用自定义的提示信息 或 插件内置的提示信息
      var msg = $field.data('validationMessage') || this.getValidationMessage(validity);

      if (!$alert.length) {
        $alert = $('<div class="am-alert am-alert-danger"></div>').hide().
          appendTo($group);
      }

      $alert.html(msg).show();
    }
  });
});
</script>
<?php //include("../footer.php") ?>
<footer>
	<center>©2015-2016 安装程序 基于<a href="https://www.licoy.cn">LiRecord</a>强力驱动</center>
</footer>
</body>
</html>
<?php
	include("../functions.php");
 if(@$_POST['siteini']){
	$sqlstr='<?php
	define("SITENAME", "'.strval($_POST['sitename']).'");
	define("SITEDOMAIN", "'.strval($_POST['sitedomain']).'");
	define("SITEQQ", "'.strval($_POST['siteqq']).'");
	?>';
	saveFile("../config/ini.php",$sqlstr);
	include_once("../config/config.php");
	$link=@mysqli_connect(MYSQLIP,MYSQLUSER,MYSQLPSWD);
	if(!$link){
		echo "<script language='javascript'>alert('数据库信息错误');</script>";
	}
	else{
		//echo "成功！";
		mysqli_select_db($link,MYSQLBASE);
		$sql_1="INSERT INTO `user` (`id`, `username`, `userpswd`, `useremail`) VALUES
		(1,	'".$_POST['username']."','".$_POST['userpswd']."','".$_POST['useremail']."');
		INSERT INTO `site` (`sitename`, `sitedomain`,`siteqq`) VALUES
		('".$_POST['sitename']."','".$_POST['sitedomain']."','".$_POST['siteqq']."');";
		$strsql=explode(";",$sql_1);
		$sqlsum=0;
		foreach($strsql as $value){
			if(empty($value))continue;
			mysqli_query($link, $value);
			$sqlsum++;
		}
		if($sqlsum==2){
			echo '<script language="JavaScript">alert("程序安装成功，执行了'.$sqlsum.'条SQL语句");</script>';
		}
		
//		if(!mysqli_query($link, $sql_2)){
//			echo "失败！";
//		}
//		else{
			@file_put_contents('install.lock','安装文件已经锁定');
			@file_put_contents('install.html', '<!DOCTYPE html><html><head>
<meta charset="UTF-8"><title>程序已经安装</title></head><body><p>程序已经安装，再次安装请删除install/install.lock！</p></body></html>
');
			echo "<meta charset='utf-8'><script>window.location='../index.php';</script>";
	//	}
	}
 }
?>
</script>
</body>
</html>