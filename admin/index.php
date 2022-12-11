<?php
session_start();
if(@$_SESSION['username']==''){
	echo '<meta charset="utf-8"><script type="text/javascript">alert("你还没有登录，立即返回登录页面！");window.location="../login.php";</script>';
}
//echo "<meta charset='utf-8'><script>alert('你还没有登录，立即返回登录页面！')window.location='../login.php';</script>";
?>
</script>
<?php
include_once("../config/config.php");
include_once("../config/ini.php");
include_once("typehead.php");
include_once("../functions.php");
$link=@mysqli_connect(MYSQLIP, MYSQLUSER, MYSQLPSWD);
@mysqli_select_db($link,MYSQLBASE);
$query=mysqli_query($link,"select * from user where username='".$_SESSION['username']."'");
$row=mysqli_fetch_array($query);
?>
<!--[if lte IE 9]>
<p class="browsehappy">你正在使用<strong>过时</strong>的浏览器，本站暂不支持。 请 <a href="http://browsehappy.com/" target="_blank">升级浏览器</a>
  以获得更好的体验！</p>
<![endif]-->
<header class="am-topbar am-topbar-inverse admin-header">
  <div class="am-topbar-brand">
    <strong><?php echo SITENAME ?></strong> <small>用户中心</small>
  </div>

  <button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-success am-show-sm-only" data-am-collapse="{target: '#topbar-collapse'}"><span class="am-sr-only">导航切换</span> <span class="am-icon-bars"></span></button>

  <div class="am-collapse am-topbar-collapse" id="topbar-collapse">

    <ul class="am-nav am-nav-pills am-topbar-nav am-topbar-right admin-header-list">
      <li class="am-dropdown" data-am-dropdown>
        <a class="am-dropdown-toggle" data-am-dropdown-toggle href="javascript:;">
          <span class="am-icon-users"></span> <?php if($row['id']==1){echo "管理员";}else{echo $row['username'];}?> <span class="am-icon-caret-down"></span>
        </a>
        <ul class="am-dropdown-content">
        	<?php
        	 	if($row['id']==1){
        	 		echo "<li><a href='upsite.php'><span class='am-icon-cogs'></span> 站点设置</a></li>";
					echo "<li><a href='notice.php'><span class='am-icon-comment'></span> 公告发布</a></li>";
					echo "<li><a href='comvip.php'><span class='am-icon-vimeo-square'></span> 等级设置</a></li>";
					echo "<li><a href='uprank.php'><span class='am-icon-history'></span> 排名更新</a></li>";
				}
        	 ?> 
          <li><a href="uppswd.php"><span class="am-icon-eye-slash"></span> 密码修改</a></li>
          <li><a href="../logout.php"><span class="am-icon-power-off"></span> 账号登出</a></li>
        </ul>
      </li>
      <li class="am-dropdown" data-am-dropdown><a href="../index.php"><span class="am-icon-home"> 返回首页</span></a></li>
      <li class="am-hide-sm-only"><a href="javascript:;" id="admin-fullscreen"><span class="am-icon-arrows-alt"></span> <span class="admin-fullText">开启全屏</span></a></li>
      
    </ul>
  </div>
</header>

<div class="am-cf admin-main">
  <!-- content start -->
  <div class="admin-content">
    <div class="admin-content-body">
      <div class="am-cf am-padding"></div>

      <ul class="am-avg-sm-1 am-avg-md-2 am-margin am-padding am-text-center admin-content-list ">
        <li><a href="#" class="am-text-success"><span class="am-icon-btn am-icon-file-text"></span><br/>留言数量<br/><?php $commsum=mysqli_query($link,"select * from megs");$commsum = mysqli_num_rows($commsum);
echo $commsum; ?>条</a></li>
        <li><a href="#" class="am-text-secondary"><span class="am-icon-btn am-icon-user-md"></span><br/>注册用户<br/><?php $usersum=mysqli_query($link,"select * from user");$usersum = mysqli_num_rows($usersum);
echo $usersum; ?>位</a></li>
      </ul>
		<?php 
			@$queSite=mysqli_query($link, "SELECT * FROM site;");
			@$rowSite=mysqli_fetch_array($queSite);
			@$commDate=$rowSite['sitecmdate'];
		?>
		<div class="am-alert am-alert-secondary" data-am-alert>
  <button type="button" class="am-close">&times;</button>
<center>排名信息上次更新的时间为：<?php ini_set('date.timezone', 'Asia/Shanghai'); echo date("Y-m-d H:i:s",$commDate); ?></center>
</div>
      <div class="am-g">
        <div class="am-u-sm-12">
          <table class="am-table am-table-bd am-table-striped admin-content-table">
            <thead>
            <tr>
              <th>ID</th><th>用户名</th><th>上次留言</th><th>共计留言</th><th>排名</th>
            </tr>
            </thead>
            <tbody><?php
            $resou=mysqli_query($link,"SELECT * FROM user ORDER BY usercomm DESC;");
			$rowsum=1;
			while($rows=mysqli_fetch_array($resou)){
				if($rowsum<=10){
				echo '<tr><td>'.$rows['id'].'</td><td>'.$rows['username'].'</td><td>';
				$rowmestr='';
				$resoumeg=mysqli_query($link,"SELECT * FROM megs where sid='".$rows['id']."'ORDER BY id DESC");
				$rowmegs=mysqli_fetch_array($resoumeg);
	           	$rowmestr=date("Y-m-d H:i:s",$rowmegs['megtime']);
				//查询总共留言条数
				$selcomsum=mysqli_query($link,"SELECT COUNT(SID) FROM `megs` where sid=".$rows['id']);
				$rowconsum=mysqli_fetch_array($selcomsum);
	           	echo $rowmestr.'</td><td><span class="am-badge am-badge-success">'.$rowconsum['0'].'</span></td><td><span class="am-badge am-badge-danger">'.$rowsum.'</span></td></tr>';
				$rowsum++;
				}
				else{
					break;
				}
			}
            ?>
            
            </tbody>
          </table>
        </div>
      </div>

      <div class="am-g">
        <div class="am-u-md-6">
          <div class="am-panel am-panel-default">
            <div class="am-panel-hd am-cf" data-am-collapse="{target: '#collapse-panel-1'}">运行信息<span class="am-icon-chevron-down am-fr" ></span></div>
            <div class="am-panel-bd am-collapse am-in" id="collapse-panel-1">
              <ul class="am-list admin-content-file">
                <li>
                  <strong><span class="am-icon-check"></span>用户占用</strong>
                  <div class="am-progress am-progress-striped am-progress-sm am-active">
                    <div class="am-progress-bar am-progress-bar-success" style="width: <?php $usersum=$usersum*0.8;echo $usersum;?>%"><?php $usersum=$usersum*0.8;echo $usersum;?>%</div>
                  </div>
                </li>
                <li>
                  <strong><span class="am-icon-check"></span>当前运行脚本所在IP为：</strong>
                  <p><?php echo $_SERVER['REMOTE_ADDR'];?></p>
                </li>
                <li>
                  <strong><span class="am-icon-check"></span>当前脚本运行的域名为：</strong>
                  <p><?php echo $_SERVER['HTTP_HOST'];?></p>
                </li>
              </ul>
            </div>
          </div>
          <div class="am-panel am-panel-default">
            <div class="am-panel-hd am-cf" data-am-collapse="{target: '#collapse-panel-2'}">服务器信息<span class="am-icon-chevron-down am-fr" ></span></div>
            <div id="collapse-panel-2" class="am-in">
              <table class="am-table am-table-bd am-table-bdrs am-table-striped am-table-hover">
                <tbody>
                <tr>
                  <th>名称</th>
                  <th>值</th>
                </tr>
                <tr>
                  <td>PHP版本</td>
                  <td><?php if($row['id']==1){echo phpversion();}else{echo "木有权限";}?></td>
                </tr>
                <tr>
                  <td>域名</td>
                  <td><?php echo $_SERVER['SERVER_NAME'];?></td>
                </tr>
                <tr>
                  <td>服务器IP</td>
                  <td><?php if($row['id']==1){echo $_SERVER['SERVER_ADDR'];}else{echo "木有权限";}?></td>
                </tr>
                <tr>
                  <td>CPU</td>
                  <td><?php echo $_SERVER['PROCESSOR_IDENTIFIER'];?></td>
                </tr>
                <tr>
                  <td>当前日期</td>
                  <td><?php echo date("Y-m-d H:i:s",time());?></td>
                </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="am-u-md-6">
          <div class="am-panel am-panel-default">
            <div class="am-panel-hd am-cf" data-am-collapse="{target: '#collapse-panel-4'}">公告<span class="am-icon-chevron-down am-fr" ></span></div>
            <div id="collapse-panel-4" class="am-panel-bd am-collapse am-in">
              <ul class="am-list admin-content-task">
                <li>
                  <div class="admin-task-meta"></div>
                  <div class="admin-task-bd">
                    <?php
                    	$sqlstr_1=mysqli_query($link,"select * from notice;");
						$b=mysqli_num_rows($sqlstr_1);
						$sqlstr_1=mysqli_query($link,"SELECT * FROM notice WHERE `id`='".$b."'");
						$sqlrow_1=mysqli_fetch_array($sqlstr_1);
						//echo $b;
						echo $sqlrow_1['content'];
                    ?>
                  </div>
                  <div class="am-cf">
                   
                    <div class="am-fr">
                      <button type="button" class="am-btn am-btn-default am-btn-xs"><?php echo $sqlrow_1['condate']; ?></button>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>

          <div class="am-panel am-panel-default">
            <div class="am-panel-hd am-cf" data-am-collapse="{target: '#collapse-panel-3'}">最近留言<span class="am-icon-chevron-down am-fr" ></span></div>
            <div class="am-panel-bd am-collapse am-in am-cf" id="collapse-panel-3">
              <ul class="am-comments-list admin-content-comment">
                <?php
              	$link=@mysqli_connect(MYSQLIP, MYSQLUSER, MYSQLPSWD);
				@mysqli_select_db($link,MYSQLBASE);
              	$query=mysqli_query($link,"select * from megs;");
				$b=mysqli_num_rows($query);
				$pagesize = 3;//每一页显示多少留言记录 
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
                      <div class="am-comment-meta">用户名为 <?php echo $row_username['useremail'] ?> * 评论于 <time><?php ini_set('date.timezone', 'Asia/Shanghai'); echo date("Y-m-d H:i:s",$rs->megtime); ?></time> * IP为 <?php echo explodeIpStr($rs->megip) ?></div>
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
        </div>
      </div>
      <?php include_once("../footer.php");?>
    </div>

<a href="#" class="am-icon-btn am-icon-th-list am-show-sm-only admin-menu" data-am-offcanvas="{target: '#admin-offcanvas'}"></a>

<!--[if lt IE 9]>
<script src="http://libs.baidu.com/jquery/1.11.1/jquery.min.js"></script>
<script src="http://cdn.staticfile.org/modernizr/2.8.3/modernizr.js"></script>
<script src="assets/js/amazeui.ie8polyfill.min.js"></script>
<![endif]-->

<!--[if (gte IE 9)|!(IE)]><!-->
<script src="../assets/js/jquery.min.js"></script>
<!--<![endif]-->
<script src="../assets/js/amazeui.min.js"></script>
<script src="../assets/js/app.js"></script>
</body>
</html>
