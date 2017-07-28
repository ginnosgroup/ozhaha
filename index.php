<?php
session_start();
require 'app/config.inc.php';
require 'app/function_core.php';

if ($_SESSION['dm_uid']) header("Location:main.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>配送员入口</title>
<meta name="description" content="此接口仅限 Panda Delivery 配送员使用。">
<meta name="author" content="Ozhaha">
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
	<div id="page-form-login" class="page">
	  <header class="bar bar-nav">	    
	    <h1 class="title">配送员登录</h1>
	  </header>
  	
  	<?php include('app/include/main_footer.php')?>
  	
  	<div class="content">
		    <div class="list-block">
		      <ul>
		        <li>
		          <div class="item-content">
		            <div class="item-inner">
		              <div class="item-title label">账户名称</div>
		              <div class="item-input">
		                <input type="text" name="username" id="username" placeholder="Your name">
		              </div>
		            </div>
		          </div>
		        </li>
		        <li>
		          <div class="item-content">
		            <div class="item-inner">
		              <div class="item-title label">账户密码</div>
		              <div class="item-input">
		                <input type="password" name="passwd" id="passwd" placeholder="Your password">
		              </div>
		            </div>
		          </div>
		        </li>
		        <li>
		          <div class="item-content">
		            <div class="item-inner">
		              <div class="item-title label">记住登录</div>
		              <div class="item-input">
		                <label class="label-switch">
		                  <input type="checkbox" name="rember" id="rember" value="1">
		                  <div class="checkbox"></div>
		                </label>
		              </div>
		            </div>
		          </div>
		        </li>
		      </ul>
		    </div>
		    <div class="content-block">
		      <div class="row">
		        <div class="col-50"><a href="#" class="button button-big button-fill button-danger">取消</a></div>
		        <div class="col-50"><a href="#" class="button button-big button-fill button-success">提交</a></div>
		      </div>
		      <div class="row text-center" style="margin-top:2.2rem;"><div class="col-100"><a href="signup.php">注册成为配送员</a></div></div>
		    </div>
    </div>
    
  </div>
</div>
<script src="SUI-Mobile/dist/js/sm.js"></script>
<script src="SUI-Mobile/dist/js/sm-extend.js"></script>
<script src="SUI-Mobile/dist/js/aes.js"></script>
<script src="SUI-Mobile/dist/js/aes-json-format.js"></script>
<script src="SUI-Mobile/assets/js/page_init.js"></script>
</body>
</html>