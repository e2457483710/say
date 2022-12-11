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
  <title>LiRecord - 安装 - 第一步</title><meta name="renderer" content="webkit">
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
      <label for="doc-vld-name-2-1">数据库地址</label>
      <input type="text" name="mysqlip" id="doc-vld-name-2-1" placeholder="输入数据库地址" data-validation-message="请输入数据库地址" required/>
    </div>
    
    <div class="am-form-group">
      <label for="doc-vld-name-2-1">数据库名</label>
      <input type="text" name="mysqlbase" id="doc-vld-name-2-1" placeholder="输入数据库名" data-validation-message="请输入数据库名称" required/>
    </div>
    
     <div class="am-form-group">
      <label for="doc-vld-name-2-1">数据库用户名</label>
      <input type="text" name="mysqluser" id="doc-vld-name-2-1" placeholder="输入数据库用户名" data-validation-message="请输入数据库用户名" required/>
    </div>

     <div class="am-form-group">
      <label for="doc-vld-age-2-1">密码：</label>
      <input type="password" name="mysqlpswd" id="doc-vld-age-2-1" placeholder="请输入密码" required data-validation-message="请输入数据库密码"/>
    </div>
	<input name="mysqlini" class="am-btn  am-btn-secondary" type="submit"/>
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
 if(@$_POST['mysqlini']){
	$sqlstr='<?php
	define("MYSQLIP", "'.strval($_POST['mysqlip']).'");
	define("MYSQLUSER", "'.strval($_POST['mysqluser']).'");
	define("MYSQLPSWD", "'.strval($_POST['mysqlpswd']).'");
	define("MYSQLBASE", "'.strval($_POST['mysqlbase']).'");
	?>';
	saveFile("../config/config.php",$sqlstr);
	include_once("../config/config.php");
	$link=@mysqli_connect(MYSQLIP,MYSQLUSER,MYSQLPSWD);
	if(!$link){
		echo "<script language='javascript'>alert('数据库信息错误');</script>";
	}
	else{
		//echo "成功！";
		mysqli_select_db($link,MYSQLBASE);
		$sql_1="
		DROP TABLE IF EXISTS `user`;
				CREATE TABLE `user`(
			  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			  `username` varchar(20) NOT NULL,
			  `userpswd` varchar(36) NOT NULL,
			  `useremail` varchar(30) NOT NULL,
			  `usercomm` int(11) NOT NULL DEFAULT '0',
			  PRIMARY KEY (`id`),
			  UNIQUE KEY `username` (`username`)
			)ENGINE=MyISAM DEFAULT CHARSET=utf8;
			DROP TABLE IF EXISTS `megs`;
			CREATE TABLE `megs` (
				`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			  `sid` int(11)  NOT NULL,
			  `content` varchar(300) NOT NULL,
			  `megtime` int NOT NULL,
			  `megip` varchar(60) NOT NULL,
			  PRIMARY KEY (`id`)
			)ENGINE=MyISAM DEFAULT CHARSET=utf8;
			DROP TABLE IF EXISTS `site`;
			CREATE TABLE `site` (
			  `sitename` varchar(100)  NOT NULL,
			  `sitedomain` varchar(25) NOT NULL,
			  `siteqq` int(12) NOT NULL,
			  `sitecmdate` int(20) NOT NULL,
			  PRIMARY KEY (`sitename`)
			)ENGINE=MyISAM DEFAULT CHARSET=utf8;
			DROP TABLE IF EXISTS `notice`;
			CREATE TABLE `notice` (
			 `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			  `content` varchar(400)  NOT NULL,
			  `condate` date NOT NULL,
			  PRIMARY KEY (`id`)
			)ENGINE=MyISAM DEFAULT CHARSET=utf8;
			INSERT INTO `notice`(`id`,`content`,`condate`) VALUES (1,'欢迎大家使用LiRecord留言程序，本版本为V0.1测试版本，谢谢您的测试，如果在使用中有任何BUG或者好的建议请邮件给193466605@qq.com或者到官方博客www.licoy.cn进行留言，谢谢您的合作！','".date("Y-m-d")."');";
		echo $sql_1;
		$strsql=explode(";",$sql_1);
		$sqlsum=0;
		foreach($strsql as $value){
			if(empty($value))continue;
			mysqli_query($link, $value);
			$sqlsum++;
		}
		if($sqlsum){
			echo '<script language="JavaScript">alert("第一步完成了，一共执行了'.$sqlsum.'条SQL语句，点击确定进入下一步操作！");</script>';
		}
		else{
			echo '<script language="JavaScript">alert("安装出错，请检查你的数据库信息是否正确！");</script>';
		}
//		if(!mysqli_query($link, $sql_2)){
//			echo "失败！";
//		}
//		else{
			echo "<meta charset='utf-8'><script>window.location='install_2.php';</script>";
	//	}
	}
 }
?>
</script>
</body>
</html>