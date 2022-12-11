<?php
session_start();
include_once("../config/config.php");
include_once("../config/ini.php");
include_once("nav.php");
$link=@mysqli_connect(MYSQLIP, MYSQLUSER, MYSQLPSWD);
@mysqli_select_db($link,MYSQLBASE);
$query=@mysqli_query($link,"select * from user where username='".$_SESSION['username']."'");
$rows=@mysqli_fetch_array($query);
if($_SESSION['username']==''){
	echo '<script language="JavaScript">location="../index.php";</script>';
}
?>
<!doctype html>
<html class="no-js">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>更改密码 - <?php echo SITENAME?></title><meta name="renderer" content="webkit">
  <meta http-equiv="Cache-Control" content="no-siteapp"/>
  <link rel="icon" type="icon" href="../assets/i/favicon.ico">
  <meta name="mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">
  <link rel="stylesheet" href="../assets/css/amazeui.min.css">
  <link rel="stylesheet" href="../assets/css/app.css">
  <link rel="stylesheet" href="../assets/css/main.css">
</head>
<div id="content">
	<form action="" class="am-form" id="doc-vld-msg" method="post">
  <fieldset>
    <legend>更改密码 - <?php echo SITENAME?></legend>
     <div class="am-form-group">
      <label for="doc-vld-age-1-1">原密码</label>
      <input type="password" name="oldpswd" id="doc-vld-age-1-1" placeholder="请输入8~18位非纯数字密码" minlength="8" maxlength="18"  required data-validation-message="请输入8~18位字符密码(不能为纯数字)"/>
    </div>
    
   <div class="am-form-group">
      <label for="doc-vld-age-2-1">新密码</label>
      <input type="password" name="newpswd" id="doc-vld-age-2-1" placeholder="请输入8~18位非纯数字密码" minlength="8" maxlength="18"  required data-validation-message="请输入8~18位字符密码(不能为纯数字)"/>
    </div>

    <div class="am-form-group">
      <label for="doc-vld-pwd-2">确认新密码</label>
      <input type="password" id="doc-vld-pwd-2" placeholder="请输入你的新密码确认" data-equal-to="#doc-vld-age-2-1" data-validation-message="请于上方密码保持一致" required/>
    </div>
    
	<input name="uppswd" class="am-btn  am-btn-secondary" type="submit"/>
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
<?php include("../footer.php") ?>
<?php
	include("../functions.php");
 if(@$_POST['uppswd']){
	$link=@mysqli_connect(MYSQLIP,MYSQLUSER,MYSQLPSWD);
	if(!$link){
		echo "<script language='javascript'>alert('数据库信息错误');</script>";
	}
	else{
		//echo "成功！";
		mysqli_select_db($link,MYSQLBASE);
		if($rows['userpswd']!=$_POST['oldpswd']){
			echo '<script language="JavaScript">alert("旧密码输入错误！");</script>';
		}
		else{
		$sql_1="UPDATE `user` SET `userpswd`='".$_POST['newpswd']."' WHERE `id`='".$rows['id']."';";
		$query_up=mysqli_query($link, $sql_1);
		if($query_up){
			echo '<script language="JavaScript">alert("恭喜你，修改成功！");</script>';
		}
		else{
			echo '<script language="JavaScript">alert("很遗憾，修改失败！");</script>';
		}
	}
	}
 }
?>
</script>
</body>
</html>