<?php
require 'app/code/main_code.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>配送员接单</title>
<meta name="description" content="此接口仅限 Panda Delivery 配送员使用。">
<meta name="author" content="ozhaha">
<meta name="viewport" content="initial-scale=1, maximum-scale=1">
<link rel="shortcut icon" href="images/favicon.ico">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no">
<meta http-equiv="Cache-Control" content="max-age=172800" />
<meta http-equiv="Last-Modified" content="<?php echo gmdate("D, d M Y H:i:s").' GMT';?>" /> 
<link rel="stylesheet" href="SUI-Mobile/dist/css/sm.css">
<link rel="stylesheet" href="SUI-Mobile/dist/css/sm-extend.css">
<script src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script src="SUI-Mobile/assets/js/zepto.min.js"></script>

</head>
<body>
<div class="page-group">
	<div id="page-order-list" class="page">
	  <?php include('app/include/main_header.php');?>  	
  	<?php include('app/include/main_footer.php');?>


  	<div class="content">
  		<div class="content-block-title" style ='margin-top: 10px;'>附近的待接订单</div>
        <div class="content pull-to-refresh-content">
         <div class="pull-to-refresh-layer">
            <div class="preloader"></div>
            <div class="pull-to-refresh-arrow"></div>
         </div>
		    <div class="list-block media-list">
		      <div id="content-list"></div>
		    </div>
        </div>
    </div>
    
  </div>
</div>

<script src="SUI-Mobile/dist/js/sm.js"></script>
<script src="SUI-Mobile/dist/js/sm-extend.js"></script>
<script src="SUI-Mobile/dist/js/aes.js"></script>
<script src="SUI-Mobile/dist/js/aes-json-format.js"></script>
<?php include('app/include/main_gps_update.php');?>
<script src="SUI-Mobile/assets/js/page_init.js"></script>
</body>
<script>
$(document).on('refresh', '.pull-to-refresh-content',function(e) {
      setTimeout(function() {
      clearInterval(timer1);
      getOrderList();
      //reset timer
      timer1 = setInterval("getOrderList()",order_reqtime);
      $.pullToRefreshDone('.pull-to-refresh-content');
      }, 1000);
      $.initPullToRefresh('.pull-to-refresh-content');
     });
</script>

</html>