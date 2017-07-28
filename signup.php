<?php
require 'app/code/signup_code.php';
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>注册成为配送员</title>
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
	<div id="page-form-signup" class="page">
	  <header class="bar bar-nav">	    
	    <h1 class="title">注册成为配送员</h1>
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
		              <div class="item-title label">确认密码</div>
		              <div class="item-input">
		                <input type="password" name="passwd1" id="passwd1" placeholder="Your password again">
		              </div>
		            </div>
		          </div>
		        </li>
		        <li>
		          <div class="item-content">
		            <div class="item-inner">
		              <div class="item-title label">真实姓名</div>
		              <div class="item-input">
		                <input type="text" name="realname" id="realname" placeholder="Your realname">
		              </div>
		            </div>
		          </div>
		        </li>
		        <li>
		          <div class="item-content">
		            <div class="item-inner">
		              <div class="item-title label">性别</div>
		              <div class="item-input">
		                <select name="sex" id="sex">
		                	<option value="">Please choose</option>
		                  <option value="MALE">Male</option>
		                  <option value="FEMALE">Female</option>
		                  <option value="UNKNOWN">Unknown</option>
		                </select>
		              </div>
		            </div>
		          </div>
		        </li>
		        <li>
		          <div class="item-content">
		            <div class="item-inner">
		              <div class="item-title label">手机号码</div>
		              <div class="item-input">
		                <input type="text" name="phone" id="phone" placeholder="Your mobile phone number">
		              </div>
		            </div>
		          </div>
		        </li>
		        <li>
		          <div class="item-content">
		            <div class="item-inner">
		              <div class="item-title label">E-mail</div>
		              <div class="item-input">
		                <input type="text" name="email" id="email" placeholder="Your email address">
		              </div>
		            </div>
		          </div>
		        </li>
		        <li>
		          <div class="item-content">
		            <div class="item-inner">
		              <div class="item-title label">企业编码类型</div>
		              <div class="item-input">
		                <select name="numberType" id="numberType">
		                	<option value="">Please choose</option>
		                  <option value="ABN" selected>ABN</option>
		                  <option value="ACN">ACN</option>
		                  <option value="ACT_BN">ACT_BN</option>
		                  <option value="NSW_BN">NSW_BN</option>
		                  <option value="NT_BN">NT_BN</option>
		                  <option value="QLD_BN">QLD_BN</option>
		                  <option value="TAS_BN">TAS_BN</option>
		                  <option value="SA_BN">SA_BN</option>
		                </select>
		              </div>
		            </div>
		          </div>
		        </li>
		        <li>
		          <div class="item-content">
		            <div class="item-inner">
		              <div class="item-title label">企业编码</div>
		              <div class="item-input">
		                <input type="text" name="number" id="number" placeholder="Your business No.">
		              </div>
		            </div>
		          </div>
		        </li>
		        <li id="business_name" style="">
		          <div class="item-content">
		            <div class="item-inner">
		              <div class="item-title label">企业名称</div>
		              <div class="item-input">
		                <input type="text" name="businessName" id="businessName" placeholder="Your business name">
		              </div>
		            </div>
		          </div>
		        </li>		        
		      </ul>
		    </div>
		    <div class="content-block">
		      <div class="row">
		        <div class="col-50"><a href="index.php" class="button button-big button-fill button-danger">取消</a></div>
		        <div class="col-50"><a href="#" class="button button-big button-fill button-success">注册账户</a></div>
		      </div>
		      <div class="row text-center" style="margin-top:2.2rem;"><div class="col-100"><a href="index.php">配送员登录</a></div></div>
		    </div>
    </div>
    
  </div>
</div>
<script src="SUI-Mobile/dist/js/sm.js"></script>
<script src="SUI-Mobile/dist/js/sm-extend.js"></script>
<script src="SUI-Mobile/assets/js/page_init.js"></script>
</body>
</html>