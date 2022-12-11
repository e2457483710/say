<?php
function saveFile($fileName, $text) {
	if (!$fileName || !$text)return false;
	if (makeDir(dirname($fileName))) {
		if ($fp = fopen($fileName, "w")) {
			if (@fwrite($fp, $text)) {
				fclose($fp);
				return true;
			}else{
				fclose($fp);
				return false;
			} 
		} 
	} 
	return false;
}
function makeDir($dir, $mode = "0777") {
	if (!$dir) return false;
		if(!file_exists($dir)) {
			return mkdir($dir,$mode,true);
		} else {
			return true;
		}
}
function gravatar($email){
	$str="https://secure.gravatar.com/avatar/".md5($eamil);
	return $str;
}
function explodeIpStr($str){
	$arr=explode(".",$str);
	//var_dump($arr);
	$ipStr=$arr[0].".".$arr[1].".***.".$arr[3];
	return $ipStr;
	
}
function ComVip($usercomm){
	@include_once("config/comvipini.php");
	if($usercomm>0 && $usercomm<=VIP1){
		echo '<a class="am-badge am-round">VIP1</a>';
	}
	elseif($usercomm>VIP1 && $usercomm<=VIP2){
		echo '<a class="am-badge am-badge-primary am-round">VIP2</a>';
	}
	elseif($usercomm>VIP2 && $usercomm<=VIP3){
		echo '<a class="am-badge am-badge-secondary am-round">VIP3</a>';
	}
	elseif($usercomm>VIP3 && $usercomm<=VIP4){
		echo '<a class="am-badge am-badge-success am-round">VIP4</a>';
	}
	elseif($usercomm>VIP4 && $usercomm<=VIP5){
		echo '<a class="am-badge am-badge-warning am-round">VIP5</a>';
	}
	elseif($usercomm>VIP5 && $usercomm<=VIP6){
		echo '<a class="am-badge am-badge-danger am-round">VIP6</a>';
	}
	elseif($usercomm>VIP5 && $usercomm<=VIP7){
		echo '<a class="am-badge am-badge-success am-round">VIP7</a>';
	}
	else{
		echo '<a class="am-badge am-badge-danger am-round">SVIP</a>';
	}
}
?>