<?php
require 'app/code/message_code.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>配送员专区</title>
<meta name="description" content="此接口仅限 Panda Delivery 配送员使用。">
<meta name="author" content="ozhaha">
<meta name="viewport" content="initial-scale=1, maximum-scale=1">
<link rel="shortcut icon" href="images/favicon.ico">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no">
<link rel="stylesheet" href="SUI-Mobile/dist/css/sm.css">
<link rel="stylesheet" href="SUI-Mobile/dist/css/sm-extend.css">
<script src="SUI-Mobile/assets/js/zepto.min.js"></script>
</head>
<body>
<div class="page-group">
	<div id="page-message-list" class="page">
	  <?php include('app/include/main_header.php')?>  	
  	<?php include('app/include/main_footer.php')?>
  	
  	<?
  	switch($_GET['id'])
  	{
  			case 1:
  	?>
  	<div class="content">
  			<div class="content-block-title">提示信息</div>
		    <div class="list-block media-list">
		      <div id="content-list" style="margin-left:15px;color:red;">账户待审核，部分功能受限。</div>
		    </div>
    </div>
    <?
    		break;
    }
    ?>
    
  </div>
</div>
<script src="SUI-Mobile/dist/js/sm.js"></script>
<script src="SUI-Mobile/dist/js/sm-extend.js"></script>
<script src="SUI-Mobile/assets/js/page_init.js"></script>
</body>
</html>