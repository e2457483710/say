<?php
session_start();
if(@$_SESSION['username']!=''){
	echo '<script language="JavaScript">location="admin";</script>';
}
include_once("config/ini.php");
include("typehead.php");
include("nav.php")
?>
<?php
	if(@$_POST['sub']){
		include_once("config/config.php");
		$link=@mysqli_connect(MYSQLIP,MYSQLUSER,MYSQLPSWD);
		mysqli_select_db($link,MYSQLBASE);
		$sql='INSERT INTO `user` (`username`,`userpswd`,`useremail`) VALUES ("'.$_POST["reusername"].'","'.$_POST["reuserpswd"].'","'.$_POST["reuseremail"].'");';
		//$sql='INSERT INTO `user` (`username`,`userpswd`,`useremail`) VALUES ("zhangsan","qwerasdf","193466@qq.com");';
			$query=mysqli_query($link, $sql);
		if(!$query){
			echo "<meta charset='utf-8'><script language='javascript'>alert('注册失败，可能是用户名或邮箱已经被注册了，请更换再次注册！');</script>";
		}
		else{
			echo "<meta charset='utf-8'><script language='javascript'>alert('注册成功，即将返回登录页面');location='login.php';</script>";
		}
	}
?>
	<div id="content">
<form action="" class="am-form" id="doc-vld-msg" method="post">
  <fieldset>
    <legend>注册用户</legend>
    <div class="am-form-group">
      <label for="doc-vld-name-2-1">用户名</label>
      <input type="text" name="reusername" id="doc-vld-name-2-1" minlength="5" maxlength="12" placeholder="输入用户名(5~12位字符)" data-validation-message="请输入5~12位字符的用户名" required/>
    </div>

    <div class="am-form-group">
      <label for="doc-vld-email-2-1">邮箱</label>
      <input type="email" name="reuseremail" id="doc-vld-email-2-1" data-validation-message="请输入长度小于20字符的邮箱" placeholder="最长20个字符的邮箱" maxlength="20"  required/>
    </div>

     <div class="am-form-group">
      <label for="doc-vld-age-2-1">密码</label>
      <input type="password" name="reuserpswd" id="doc-vld-age-2-1" placeholder="请输入8~18位非纯数字密码" minlength="8" maxlength="18"  required data-validation-message="请输入8~18位字符密码(不能为纯数字)"/>
    </div>

    <div class="am-form-group">
      <label for="doc-vld-pwd-2">确认密码</label>
      <input type="password" id="doc-vld-pwd-2" placeholder="请与上面输入的值一致" data-equal-to="#doc-vld-age-2-1" data-validation-message="请于上方密码保持一致" required/>
    </div>
    <input name="sub" class="am-btn am-btn-secondary" value="注册" type="submit"/>
  </fieldset>
</form>
</div>
<?php include("scriptinfo.php") ?>
<script type="text/javascript">
	$(function(){
		//验证用户名是否已经注册
			$("input[name=reusername]").blur(function(){
				var name=$("input[name=reusername]").attr("value");
				var name=encodeURIComponent(name);
				if(name!=""){
					var xhr = new XMLHttpRequest();
					xhr.onreadystatechange = function(){
						if(xhr.readyState == 4){
							if(xhr.responseText=="true"){
								alert("该用户名可以注册！");
							}
							else if(xhr.responseText=="false"){
								alert("该用户名已经被别人注册了！");
								$("input[name=reusername]").attr("value","");
							}
						}
						}
						xhr.open("POST","validation.php");
						xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
						var info = "reusername="+name;
						xhr.send(info);
				}
				
		})
		//验证邮箱是否已经注册
			$("input[name=reuseremail]").blur(function(){
				var eamil=$("input[name=reuseremail]").attr("value");
				var eamil=encodeURIComponent(eamil);
				if(eamil!=""){
					var xhr = new XMLHttpRequest();
					xhr.onreadystatechange = function(){
						if(xhr.readyState == 4){
							if(xhr.responseText=="true"){
								alert("该用户名可以注册！");
							}
							else if(xhr.responseText=="false"){
								alert("该用户名已经被别人注册了！");
								$("input[name=reuseremail]").attr("value","");
							}
						}
						}
						xhr.open("POST","validation.php");
						xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
						var info = "reuseremail="+eamil;
						xhr.send(info);
				}
		})
		//判断所有的内容是否都已经填写
		$("input[name=sub]").click(function(){
			var name=$("input[name=reusername]").attr("value");
			var eamil=$("input[name=reuseremail]").attr("value");
			var pswd=$("input[name=reuserpswd]").attr("value");
			if(name==''){
				alert("用户名不可以为空");return false;
			}
			else if(eamil==''){
				alert("用户名不可以为空");return false;
			}
			else if(eamil==''){
				alert("用户名不可以为空");return false;
			}
		})
})
</script>
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
<?php include("footer.php") ?>