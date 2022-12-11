<?php
session_start();
@$name=$_POST['username'];
@$pswd=$_POST['userpswd'];
include_once("config/config.php");
$link=@mysqli_connect(MYSQLIP,MYSQLUSER,MYSQLPSWD);
mysqli_select_db($link,MYSQLBASE);
if(@$_POST['username'] && @$_POST['userpswd']){
$query=mysqli_query($link,"select * from user where username='".$_POST['username']."'");
	if($row=mysqli_fetch_array($query)){
				if($row['username']==$name){
					if($row['userpswd']==$pswd){
						$_SESSION['username']=$name;
						$_SESSION['userpswd']=$pswd;
						echo "true";
					}
					else{
						echo "pswdfalse";
					}
				}
				
			}
	else{
		echo "namefalse";
	}
}
elseif(@$_POST['reusername']){
	$reSqlStr="SELECT username FROM user WHERE username='".$_POST['reusername']."'";
	$reQuery=mysqli_query($link,$reSqlStr);
	$reRows=mysqli_fetch_array($reQuery);
	if($reRows['0']!=$_POST['reusername']){
		echo "true";
	}
	else{
		echo "false";
	}
}

elseif(@$_POST['reuseremail']){
	$reEmaSqlStr="SELECT useremail FROM user WHERE useremail='".$_POST['reuseremail']."'";
	$reEmaQuery=mysqli_query($link,$reEmaSqlStr);
	$reEmaRows=mysqli_fetch_array($reEmaQuery);
	if($reEmaRows['0']!=$_POST['reuseremail']){
		echo "true";
	}
	else{
		echo "false";
	}
}
	
	
	
	
?>