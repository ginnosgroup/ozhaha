<?php
require 'app/code/my_order_code.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>配送员订单列表</title>
<meta name="description" content="此接口仅限 Panda Delivery 配送员使用。">
<meta name="author" content="ozhaha">
<meta name="viewport" content="initial-scale=1, maximum-scale=1">
<link rel="shortcut icon" href="images/favicon.ico">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no">
<link rel="stylesheet" href="SUI-Mobile/dist/css/sm.css">
<link rel="stylesheet" href="SUI-Mobile/dist/css/sm-extend.css">
<script src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script src="SUI-Mobile/assets/js/zepto.min.js"></script>
</head>
<body>
<div class="page-group">
	<div id="page-my-order-list" class="page">
	  <?php include('app/include/main_header.php');?> 
  	<?php include('app/include/main_footer.php');?>
  	
  	<div class="content">
  			<div class="content-block-title" style ='margin-top: 10px;'>我配送的订单</div>
        <div class="content pull-to-refresh-content">
         <div class="pull-to-refresh-layer">
            <div class="preloader"></div>
            <div class="pull-to-refresh-arrow"></div>
         </div>
		    <div class="list-block media-list">
		      <div id="content-list1"></div>
		    </div>
      </div>
    </div>
    
  </div>
</div>
<script src="SUI-Mobile/dist/js/sm.js"></script>
<script src="SUI-Mobile/dist/js/sm-extend.js"></script>
<?php include('app/include/main_gps_update.php');?>
<script src="SUI-Mobile/assets/js/page_init.js"></script>
</body>
<script>
$(document).on('refresh', '.pull-to-refresh-content',function(e) {
      setTimeout(function() {
      clearInterval(timer1);
      getMyOrderList();
      //reset timer
      timer1 = setInterval("getMyOrderList()",order_reqtime);
      $.pullToRefreshDone('.pull-to-refresh-content');
      }, 1000);
      $.initPullToRefresh('.pull-to-refresh-content');
     });
</script>
</html>