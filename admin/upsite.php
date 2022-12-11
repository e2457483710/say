<?php
session_start();
include_once("../config/config.php");
include_once("../config/ini.php");
include_once("nav.php");
$link=@mysqli_connect(MYSQLIP, MYSQLUSER, MYSQLPSWD);
@mysqli_select_db($link,MYSQLBASE);
$query=@mysqli_query($link,"select * from user where username='".$_SESSION['username']."'");
$rows=@mysqli_fetch_array($query);
if($rows['id']!=1 || $_SESSION['username']==''){
	echo '<script language="JavaScript">location="../index.php";</script>';
}
?>
<!doctype html>
<html class="no-js">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>更新站点配置 - <?php echo SITENAME?></title><meta name="renderer" content="webkit">
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
	<div class="am-alert am-alert-danger" data-am-alert>
  <button type="button" class="am-close">&times;</button>
  <p>如果某项无需更改，请按照原值进行输入。</p>
</div>
	<form action="" class="am-form" id="doc-vld-msg" method="post">
  <fieldset>
    <legend>更新站点配置 - <?php echo SITENAME?></legend>
    <div class="am-form-group">
      <label for="doc-vld-name-2-1">站点名称</label>
      <input type="text" name="sitename" id="doc-vld-name-2-1" maxlength="20" placeholder="<?php echo SITENAME?>" data-validation-message="输入站点名称" required/>
    </div>
    
    <div class="am-form-group">
      <label for="doc-vld-name-2-1">站点域名(请不要带http://)</label>
      <input type="text" name="sitedomain" id="doc-vld-name-2-1"  placeholder="<?php echo SITEDOMAIN?>" data-validation-message="请输入站点域名" required/>
    </div>
    
    <div class="am-form-group">
      <label for="doc-vld-name-2-1">站长QQ</label>
      <input type="number" name="siteqq" id="doc-vld-name-2-1"  minlength="5" maxlength="12" placeholder="<?php echo SITEQQ?>" data-validation-message="请输入5~12位数的QQ" required/>
    </div>
    
	<input name="upsite" class="am-btn  am-btn-secondary" type="submit"/>
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
 if(@$_POST['upsite']){
	$sqlstr='<?php
	define("SITENAME", "'.strval($_POST['sitename']).'");
	define("SITEDOMAIN", "'.strval($_POST['sitedomain']).'");
	define("SITEQQ", "'.strval($_POST['siteqq']).'");
	?>';
	saveFile("../config/ini.php",$sqlstr);
	$link=@mysqli_connect(MYSQLIP,MYSQLUSER,MYSQLPSWD);
	if(!$link){
		echo "<script language='javascript'>alert('数据库信息错误');</script>";
	}
	else{
		//echo "成功！";
		mysqli_select_db($link,MYSQLBASE);
		$sql_1="UPDATE `site` SET `sitename`='".$_POST['sitename']."',`sitedomain`='".$_POST['sitedomain']."',`siteqq`='".$_POST['siteqq']."' WHERE `sitename`='".SITENAME."';";
		$row=mysqli_query($link, $sql_1);
		if($row){
			echo '<script language="JavaScript">alert("恭喜你，修改成功！");</script>';
		}
		else{
			echo '<script language="JavaScript">alert("很遗憾，修改失败！");</script>';
		}
		
			//echo "<meta charset='utf-8'><script>window.location='../index.php';</script>";
	}
 }
?>
</script>
</body>
</html>