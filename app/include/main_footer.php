<nav class="bar bar-tab">
	<!-- <a class="tab-item" href="index.php">
	  <span class="icon icon-home"></span>
	  <span class="tab-label">首页</span>
	</a> -->
	<a class="tab-item<?=(page_self()=='main.php' ? ' active':'')?>" href="main.php" data-no-cache="true">
	  <span class="icon icon-browser"></span>
	  <span class="tab-label">抢订单</span>
	</a>
	<a class="tab-item<?=(page_self()=='my_received_order.php' ? ' active':'')?>" href="my_received_order.php" data-no-cache="true">
	  <span class="icon icon-search"></span>
	  <span class="tab-label">我已接的单</span>
	</a>
	<a class="tab-item<?=(page_self()=='my_order.php' ? ' active':'')?>" href="my_order.php" data-no-cache="true">
	  <span class="icon icon-search"></span>
	  <span class="tab-label">我正在配送</span>
	</a>
	<a class="tab-item<?=(page_self()=='my_orderhistory.php' ? ' active':'')?>" href="my_orderhistory.php" data-no-cache="true">
	  <span class="icon icon-clock"></span>
	  <span class="tab-label">我近期订单</span>
	</a>
	<a class="tab-item<?=(page_self()=='settings.php' ? ' active':'')?>" href="settings.php" data-no-cache="true">
	  <span class="icon icon-settings"></span>
	  <span class="tab-label">设置</span>
	</a>
</nav>