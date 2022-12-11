<?php
	if(phpversion()<5.5){
		echo "你的PHP版本为".phpversion()."不适合安装此程序，请升级到PHP5.5以上版本！";
	}
	else{
		include_once("install.php");
	}
		
?>