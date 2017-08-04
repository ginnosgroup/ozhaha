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
<meta http-equiv="Cache-Control" content="max-age=172800" />
<meta http-equiv="Last-Modified" content="<?php echo gmdate("D, d M Y H:i:s"). " GMT";?>" />
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
	<div id="page-my-received-order-list" class="page">
	  <?php include('app/include/main_header.php');?> 
  	<?php include('app/include/main_footer.php');?>
  	
  	<div class="content">
  			<div class="content-block-title" style ='margin-top: 10px;'>我接过的单</div>
         <div class="content pull-to-refresh-content" data-ptr-distance="55" style="margin-bottom: 5px">
         <div class="pull-to-refresh-layer">
            <div class="preloader"></div>
            <div class="pull-to-refresh-arrow"></div>
         </div>
		    <div class="list-block media-list">
		      <div id="content-list0"></div>
		    </div>
      </div>
    </div>
  <div class="popup popup-pick-up" id='pickup-popup' style='z-index:1000'>
    <div hidden id='order-info'></div>
    <div class='content-block content-padded'>
    <div class='list-block'>
    <iframe id='dishesList' src='' style='width:100%;height:260px;border:0;'></iframe>
    <div class="item-inner" style="border-bottom: 2px dotted #000;
    border-top: 2px dotted #000;">
        <div class="item-title label">实付商家金额: </div>
            <div class="item-input">
               <input type ='number' id='actualPay' placeholder="actual pay to shop">
            </div>
        </div>
 
    <div class="item-inner" style="border-bottom:2px dotted #000;">
        <div class="item-title label">核实菜品: </div>
           <div class="item-input">
              <label class="label-switch">
                <input type="checkbox" name='dishesCheck'>
                <div class="checkbox"></div>
              </label>
            </div>
        </div>
    </div>
    <div><button class='button disabled prompt-title-ok-cancel' id='checkingOrder' onclick="checkOrders();" style="margin-bottom: 5px;width: 100%;" disabled>菜品确认</button></div>
    <div><a href='#' class='button button-success' style='display:none;margin-bottom: 5px;' id='checkingPay' onclick='ConfirmPickUp()'>确认支付</a></div>
    <div><a href='#' class='button button-warning close-popup' onclick="clearPopupInputs()">关闭</a></div>
  </div>
    </div>
  </div>
</div>

<script src="SUI-Mobile/dist/js/sm.js"></script>
<script src="SUI-Mobile/dist/js/sm-extend.js"></script>
<?php include('app/include/main_gps_update.php');?>
<script src='SUI-Mobile/assets/js/page_init.js?v=<?php echo gmdate("YmdH");?>'></script>
</body>
<script> 
$(document).on('refresh', '.pull-to-refresh-content',function(e) {
      setTimeout(function() {
      clearInterval(timer1);  
      getMyReceivedOrderList();
      //reset timer
     timer1 = setInterval("getMyReceivedOrderList()",order_reqtime);
      $.pullToRefreshDone('.pull-to-refresh-content');
  
      }, 1000);
     // $.initPullToRefresh('.pull-to-refresh-content');
     });



</script>
</html>