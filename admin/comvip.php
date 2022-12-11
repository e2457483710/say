<?php
session_start();
include_once("../config/config.php");
include_once("../config/ini.php");
include_once("nav.php");
include_once("../config/comvip.php");
include_once("../functions.php");
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
  <title>等级设置 - <?php echo SITENAME?></title><meta name="renderer" content="webkit">
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
    <legend>等级设置 - <?php echo SITENAME?></legend>
    <div class="am-form-group">
      <label for="doc-vld-name-2-1">VIP1留言条数</label>
      <input type="number" name="vip1" id="doc-vld-name-2-1"  minlength="1" maxlength="5" value="<?php echo $ComVip1?>" data-validation-message="请输入5~12位数的QQ" required/>
    </div>
    <div class="am-form-group">
      <label for="doc-vld-name-2-1">VIP2留言条数</label>
      <input type="number" name="vip2" id="doc-vld-name-2-1"  minlength="1" maxlength="5" value="<?php echo $ComVip2?>" data-validation-message="请输入5~12位数的QQ" required/>
    </div>
    <div class="am-form-group">
      <label for="doc-vld-name-2-1">VIP3留言条数</label>
      <input type="number" name="vip3" id="doc-vld-name-2-1"  minlength="1" maxlength="5" value="<?php echo $ComVip3?>" data-validation-message="请输入5~12位数的QQ" required/>
    </div>
    <div class="am-form-group">
      <label for="doc-vld-name-2-1">VIP4留言条数</label>
      <input type="number" name="vip4" id="doc-vld-name-2-1"  minlength="1" maxlength="5" value="<?php echo $ComVip4?>" data-validation-message="请输入5~12位数的QQ" required/>
    </div>
    <div class="am-form-group">
      <label for="doc-vld-name-2-1">VIP5留言条数</label>
      <input type="number" name="vip5" id="doc-vld-name-2-1"  minlength="1" maxlength="5" value="<?php echo $ComVip5?>" data-validation-message="请输入5~12位数的QQ" required/>
    </div>
    <div class="am-form-group">
      <label for="doc-vld-name-2-1">VIP6留言条数</label>
      <input type="number" name="vip6" id="doc-vld-name-2-1"  minlength="1" maxlength="5" value="<?php echo $ComVip6?>" data-validation-message="请输入5~12位数的QQ" required/>
    </div>
    <div class="am-form-group">
      <label for="doc-vld-name-2-1">VIP7留言条数</label>
      <input type="number" name="vip7" id="doc-vld-name-2-1"  minlength="1" maxlength="5" value="<?php echo $ComVip7?>" data-validation-message="请输入5~12位数的QQ" required/>
    </div>
    
	<input name="comvipsub" class="am-btn  am-btn-secondary" type="submit"/>
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
 if(@$_POST['comvipsub']){
	$vipstr='<?php
		define(VIP1,"'.$_POST['vip1'].'");
		define(VIP2,"'.$_POST['vip2'].'");
		define(VIP3,"'.$_POST['vip3'].'");
		define(VIP4,"'.$_POST['vip4'].'");
		define(VIP5,"'.$_POST['vip5'].'");
		define(VIP6,"'.$_POST['vip6'].'");
		define(VIP7,"'.$_POST['vip7'].'");
		?>';
	saveFile("../config/comvipini.php",$vipstr);
	echo '<script language="javascript">location="go.php"</script>';
 }
?>
</script>
</body>
</html>