<?php
session_start();
if(@$_SESSION['username']!=''){
	echo '<script language="JavaScript">location="admin";</script>';
}
include_once("config/ini.php");
include("typehead.php"); 
include("nav.php");
?>
<div id="content">
<form action="" class="am-form" id="doc-vld-msg" method="post">
  <fieldset>
    <legend>登录</legend>
    <div class="am-form-group">
      <label for="doc-vld-name-2-1">用户名</label>
      <input name="username" type="text" id="doc-vld-name-2-1" value="" minlength="5" placeholder="输入用户名" data-validation-message="请输入至少5位字符的用户名" required/>
    </div>

     <div class="am-form-group">
      <label for="doc-vld-age-2-1">密码</label>
      <input name="userpswd" type="password" id="doc-vld-age-2-1" value="" placeholder="请输入8~18位非纯数字密码" min="8" max="18"  required data-validation-message="请输入8~18位字符密码(不能为纯数字)"/>
    </div>
    <input class="am-btn am-btn-secondary" name="login" type="button" onclick="checkname()" value="登录"/>
  </fieldset>
</form>
</div>
<?php include("scriptinfo.php") ?>
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
<script type="text/javascript">
			function checkname(){
				var name=$("input[name=username]").attr("value");
				var pswd=$("input[name=userpswd]").attr("value");
				var name=encodeURIComponent(name);//encodeURIComponent可把字符串作为URI组件进行编码
				var pswd=encodeURIComponent(pswd);
				//alert(name+".."+pswd);
			if(name==""){
				alert("请输入用户名！");
			}
			else if(pswd==""){
				alert("请输入密码！");
			}
			else{
			var xhr = new XMLHttpRequest();
			xhr.onreadystatechange = function(){
				if(xhr.readyState == 4){
					if(xhr.responseText=="true"){
						location='admin';
					}
					else if(xhr.responseText=="pswdfalse"){
						alert("密码错误！");
					}
					else if(xhr.responseText=="namefalse"){
						alert("不存在该用户！");
					}
					else{
						alert("未知错误");
					}
				}
			}
			}
			//alert(name);
			xhr.open("POST","validation.php");
			xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			var info = "username="+name+"&userpswd="+pswd;
			xhr.send(info);
			
		}
</script>
<?php include("footer.php") ?>
	