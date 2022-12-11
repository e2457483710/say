<head>
	<title>正在登出账号......</title>
</head>

<?php
session_start();
session_unset();
session_destroy();
echo "<meta charset='utf-8'><script language='javascript'>location='index.php';</script>"

?>