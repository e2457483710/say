<header class="am-topbar am-topbar-inverse">
  <!--<h1 class="am-topbar-brand">
    <a href="#" class="am-text-ir"></a>
  </h1>-->

  <button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-success am-show-sm-only" data-am-collapse="{target: '#doc-topbar-collapse'}"><span class="am-sr-only">导航切换</span> <span class="am-icon-bars"></span></button>

  <div class="am-collapse am-topbar-collapse" id="doc-topbar-collapse">
    <ul class="am-nav am-nav-pills am-topbar-nav">
      <li class="am-active"><a href="index.php">LiRecord - 留言板 - 程序安装</a></li>
      <!--<li><a href="https://www.licoy.cn">憧憬博客</a></li>
      <li class="am-dropdown" data-am-dropdown>
        <a class="am-dropdown-toggle" data-am-dropdown-toggle href="javascript:;">
          更多项目<span class="am-icon-caret-down"></span>
        </a>
        <ul class="am-dropdown-content">
          <li class="am-dropdown-header">更多项目</li>
          <li><a href="http://www.wakew.cn">瓦客网</a></li>
          <li><a href="http://music.wakew.cn">瓦客音乐</a></li>
          <li><a href="http://t.wakew.cn">瓦客云签</a></li>
        </ul>-->
      </li>
    </ul>
    <?php
    	if(@$_SESSION['username']==''){
    		echo '<div class="am-topbar-right">
    	<div class="nav_login_re">
      <a href="login.php" target="_blank"><button class="am-btn am-btn-secondary am-topbar-btn am-btn-sm">登录</button></a>
      <a href="register.php" target="_blank"><button class="am-btn am-btn-secondary am-topbar-btn am-btn-sm">注册</button></a>
      </div>
    </div>';}
		else{
			echo '<div class="am-topbar-right">
    	<div class="nav_login_re">
      <a href="admin" target="_blank"><button class="am-btn am-btn-secondary am-topbar-btn am-btn-sm">用户中心</button></a>
      </div>
    </div>';
		}
			
			
    	
    	
    	
    	
    	
    ?>
    
  </div>
    
</header>