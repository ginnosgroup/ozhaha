<?php
require 'app/code/my_orderhistory_code.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>配送员历史订单列表</title>
<meta name="description" content="此接口仅限 Panda Delivery 配送员使用。">
<meta name="author" content="ozhaha">
<meta name="viewport" content="initial-scale=1, maximum-scale=1">
<link rel="shortcut icon" href="images/favicon.ico">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no">
<link rel="stylesheet" href="SUI-Mobile/dist/css/sm.css?v=<?php echo gmdate("YmdH");?>">
<link rel="stylesheet" href="SUI-Mobile/dist/css/sm-extend.css?v=<?php echo gmdate("YmdH");?>">
<script src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script src="SUI-Mobile/assets/js/zepto.min.js"></script>
</head>
<body>
<div class="page-group">
	<div id="page-my-orderhistory-list" class="page">
	  <?php include('app/include/main_header.php');?>  	
  	<?php include('app/include/main_footer.php');?>
  	
  	<div class="content">
  			<div class="buttons-tab">
		      <a href="#orderhistory-tab1" id="oh-tab1" class="tab-link active button">全部</a>
		      <a href="#orderhistory-tab2" id="oh-tab2" class="tab-link button">今天</a>
		      <a href="#orderhistory-tab3" id="oh-tab3" class="tab-link button">7天内</a>
		    </div>  			
		    <div class="list-block media-list">
		    	<div class="tabs">
		    			<div id="orderhistory-tab1" class="tab active">
		      				<div id="content-list1"></div>
		      		</div>
		      		<div id="orderhistory-tab2" class="tab">
					        <div id="content-list2"></div>
				      </div>
				      <div id="orderhistory-tab3" class="tab">
					        <div id="content-list3"></div>
				      </div>
		    	</div>
		    </div>
    </div>
    
  </div>
</div>
<script src="SUI-Mobile/dist/js/sm.js"></script>
<script src="SUI-Mobile/dist/js/sm-extend.js"></script>
<?php include('app/include/main_gps_update.php');?>
<script src='SUI-Mobile/assets/js/page_init.js?v=<?php echo gmdate("YmdH");?>'></script>
</body>
</html>