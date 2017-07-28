<?php
require 'app/code/settings_code.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>配送员设置</title>
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
	<div id="page-settings-list" class="page">
	  <?php include('app/include/main_header.php')?> 
  	<?php include('app/include/main_footer.php')?>
  	
  	<div class="content">
  			<div class="buttons-tab">
		      <a href="#settings-tab1" id="oh-tab1" class="tab-link active button">修改登录密码</a>		      
		    </div>  			
		    <div class="list-block media-list">
		    	<div class="tabs">
		    			<div id="settings-tab1" class="tab active">
		      				<div class="list-block">
							      <ul>							        
							        <li>
							          <div class="item-content">
							            <div class="item-inner">
							              <div class="item-title label">当前的密码</div>
							              <div class="item-input">
							                <input type="password" name="passwd" id="passwd" placeholder="Enter current password">
							              </div>
							            </div>
							          </div>
							        </li>
							        <li>
							          <div class="item-content">
							            <div class="item-inner">
							              <div class="item-title">修改的新密码</div>
							              <div class="item-input">
							                <input type="password" name="passwd1" id="passwd1" placeholder="Enter new password">
							              </div>
							            </div>
							          </div>
							        </li>
							        <li>
							          <div class="item-content">
							            <div class="item-inner">
							              <div class="item-title">确认新密码</div>
							              <div class="item-input">
							                <input type="password" name="passwd2" id="passwd2" placeholder="Confirm new password">
							              </div>
							            </div>
							          </div>
							        </li>							        
							      </ul>
							    </div>
							    <div class="content-block">
							      <div class="row">
							        <div class="col-50"><a href="#" id="btnSubmit" class="button button-big button-fill button-success">提交</a></div>
							      </div>
							    </div>
		      		</div>		      		
		    	</div>
		    </div>
    </div>
    
  </div>
</div>
<script src="SUI-Mobile/dist/js/sm.js"></script>
<script src="SUI-Mobile/dist/js/sm-extend.js"></script>
<?php include('app/include/main_gps_update.php')?>
<script src="SUI-Mobile/assets/js/page_init.js"></script>
</body>
</html>