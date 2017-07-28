<header class="bar bar-nav">
	<a class="icon pull-left open-panel" data-panel=".panel-left"><img src="SUI-Mobile/images/ico_gps.png" /></a>
	<a href="logout.php" class="button button-link button-nav pull-right open-popup" data-popup=".popup-about">注销</a>
  <h1 class="title">配送员：<?=$_SESSION['dm_username']?><?=($_SESSION['dm_status'] == 'PRE' ? '&nbsp;(待审核)':'')?></h1>	    
</header>