<?php
session_start();
if(!file_exists("install/install.lock")){
	echo "<meta charset='utf-8'><script>alert('未安装，将跳转安装页面！');window.location='install/';</script>";
}
 include_once("config/ini.php");
 include_once("config/config.php");
 include("typehead.php");
include_once("functions.php");
 ?>
<body>
<?php
$link=@mysqli_connect(MYSQLIP, MYSQLUSER, MYSQLPSWD);
@mysqli_select_db($link,MYSQLBASE);
@mysqli_query("set names utf8;");
//----处理POST数据
if(@$_POST['sub'] && @$_SESSION['username']!=''){
	$text=htmlspecialchars($_POST['retext']);
	@mysqli_query("set names utf8;");
	$sql_user="select * from user where username='".mysqli_real_escape_string($link,$_SESSION['username'])."';";
	$query_user=@mysqli_query($link, $sql_user);
	$row_user=@mysqli_fetch_array($query_user);
	$userid=@$row_user['id'];
	$sql_megs="insert into `megs` (`sid`,`content`,`megtime`,`megip`) values (".$userid.",'".$text."','".time()."','".$_SERVER['REMOTE_ADDR']."');";
	$query_megs=@mysqli_query($link,$sql_megs);
	if($query_megs){
		echo "<meta charset='utf-8'><script language='javascript'>alert('留言成功！');</script>";
	}
	else{
		echo "<meta charset='utf-8'><script language='javascript'>alert('留言失败！');</script>";
	}
	$sql_upuser="update `user` set `usercomm`=".($row_user['usercomm']+1)." where `id`=".$userid.";";
	@mysqli_query($link,$sql_upuser);
}
//----END
include("nav.php") ;
?>
	<div id="content">
<form class="am-form" method="post" action="">
  <fieldset>
					<?php
	if(@$_SESSION['username']==''){
		echo '<div class="am-alert am-alert-warning" data-am-alert>
		温馨提示：你当前处于未登录状态，不可以在此进行留言，请点击右上方登录/注册进行登录会话！
		</div>';
	}
	else{
		echo '<div class="am-alert am-alert-secondary" data-am-alert>
		温馨提示：你当前处于登录状态，可以再次进行留言，请留下你的脚印！
		</div>';
	}
//	echo @$_SESSION['username'];
//	echo @$_SESSION['userpswd'];
	if(@$_SESSION['username']!=''){
	echo '<div class="am-alert am-alert-success" data-am-alert>
  <button type="button" class="am-close">&times;</button>
  <p>请文明用语，勿发广告信息</p>
</div>';
}
?>
		<div class="am-form-group">
      <label for="doc-vld-name-2-1">进行留言</label>
      <textarea type="text" name="retext" rows="5" id="doc-ta-1" <?php if(@$_SESSION['username']==''){echo 'disabled';}?>></textarea><br />
      <input type="submit" value="提交" name="sub" class="am-btn am-btn-secondary" data-am-modal="{target: '#my-alert'}" />
    </div>
  </fieldset>
</form>
            <div class="am-panel-bd am-collapse am-in am-cf" id="collapse-panel-3">
              <ul class="am-comments-list admin-content-comment">
              	<?php
              	$query=mysqli_query($link,"select * from megs;");
				$b=mysqli_num_rows($query);
				$pagesize = 5;//每一页显示多少留言记录 
				if(isset($_GET['page'])&&$_GET['page']!='') $page=$_GET['page']; 
				else $page=0;
				$sql="select * from `megs` ORDER BY `id` DESC";
				$sqlstr=mysqli_query($link,$sql);
				$numRecord=mysqli_num_rows($sqlstr); 
				//echo "留言总数量：".$numRecord;
				$totalpage = ceil($numRecord/$pagesize); 
				//echo "<br/>分页页数为：".$totalpage;
				$recordSql = $sql. " LIMIT ".($page*$pagesize).",".$pagesize; 
				$result = mysqli_query($link,$recordSql);
				while($rs=mysqli_fetch_object($result)){
				$sql_username="select * from `user` where `id`=".$rs->sid."";
				$res_username=mysqli_query($link,$sql_username);
				$row_username=mysqli_fetch_array($res_username);
				$eamil=$row_username['useremail'];
              	?>
                <li class="am-comment">
                  <img src="<?php echo "http://secure.gravatar.com/avatar/".md5($eamil);?>" alt="" class="am-comment-avatar" width="48" height="48">
                  <div class="am-comment-main">
                    <header class="am-comment-hd">
                      <div class="am-comment-meta"><?php if($row_username['id']==1){echo '<a class="am-badge am-badge-danger am-round">管理员</a>';}else{ echo ComVip($row_username['usercomm']); }?> 用户名为 <?php echo $row_username['username'] ?> / 评论于 <time><?php ini_set('date.timezone', 'Asia/Shanghai'); echo date("Y-m-d H:i:s",$rs->megtime); ?></time> / IP为 <?php echo explodeIpStr($rs->megip) ?></div>
                    </header>
                    <div class="am-comment-bd"><p><?php echo $rs->content ?></p>
                    </div>
                  </div>
                </li>
				<?php } ?>
              </ul>
              <ul class="am-pagination am-fr admin-content-pagination">
              	<?php 
				if($page>0) echo '<li><a href="?page='.($page-1).'">上一页</a></li>';
				else{echo '<li class="am-disabled"><a href="#">上一页</a></li>';} 
				echo '<li class="am-disabled"><a>'.($page+1).'/'.$totalpage.'</a></li>';
				if($page<$totalpage-1) echo '<li><a href="?page='.($page+1).'">下一页</a></li>' ; 
				else{echo '<li class="am-disabled"><a href="#">下一页</a></li>';}
              	
              	?>
              </ul>
            </div>
          </div>
<?php include("scriptinfo.php") ?>
	<script type="text/javascript">
		$(function(){
			function trim(str){   
			    return str.replace(/^(\s|\u00A0)+/,'').replace(/(\s|\u00A0)+$/,'');   
			}
			//alert("选中");
			$("input[name=sub]").click(function(){
				var retext=$("textarea[name=retext]").attr("value");
				//去除空白符
				var retext=trim(retext);
				var retextlen=retext.length;
			if(retext==''){
				alert("留言的内容不能为空");
				return false;
			}
			else if(retextlen<3){
				alert("请输入高于3个字符的留言内容");
				return false;
			}
			else{
				return true;
				}
			})
			
		})
	</script>
<?php include("footer.php") ?>
