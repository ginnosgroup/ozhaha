$(function () {
  'use strict';
  
  //对话框
  $(document).on("pageInit", "#page-form-login", function(e, id, page) {
    var $content = $(page).find('.content');
    $content.on('click','.button-success',function () {
    	var username = $("#username").val();
    	var passwd = $("#passwd").val();
    	var rember = $("input[name='rember'][checked]").val();
    	if (username == '')
    	{
    			$.alert('账户名称不能为空！');
    	}else if (passwd == '')
    	{
    			$.alert('账户密码不能为空！');
    	}else
    	{
		    	$.showPreloader('verifying...');
					//ajax请求提交
					var strUrl = 'app/login_ajax.php?ac=post';
					$.ajax({
					  type: "POST",
					  url: strUrl,
					  data: {username: username, passwd: passwd,rember: rember},
					  success: function(data){
					  	$.hidePreloader();
					  	if (data.msg == 'ok')
					  	{
					  			$.showPreloader('identity authenticated...');
					  			location.href = 'main.php';
					  	}else if (data.msg == 'failed')
					  	{
					  			$.alert('账户名称或密码不正确！');				  		
					  	}
					  },
					  dataType: 'json'
					});
    	}
    });    
  });

  $.init();
});