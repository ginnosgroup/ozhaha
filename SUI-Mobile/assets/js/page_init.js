var timer1 = null;
//var order_reqtime = 10000;//订单列表更新时间 单位毫秒
var order_reqtime = 120000; 
var datalist_url_base = 'https://admintest.ozhaha.com/'; 
//var datalist_url_base = 'https://admin.ozhaha.com/'; 
var sc_phrase = "my secret passphrase";    
$(function () {
  'use strict';
 //setReloadPage
//console.log(decrpt(val,sc_phrase));
  //配送员登录页面
  $(document).on("pageInit", "#page-form-login", function(e, id, page) {
    var $content = $(page).find('.content');
   	if(readCookie('username')) {$("#username").val(readCookie('username'))};
   	if(readCookie('password')) {$("#passwd").val(readCookie('password'))};
    $content.on('click','.button-success',function () {
    	var username = $("#username").val();
    	var passwd = $("#passwd").val();

    	if(passwd.length>15){
    	var val = eval("(" + readCookie('password') + ")"); 
    	passwd = decrpyt(val,sc_phrase);
    	}
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
					  	//var username = getCookieValue('username');
					  	if (data.msg == 'ok')
					  	{
					  			//console.log(data.pss);
					  			createCookie('password',data.pss,1);
					  			console.log('66');
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
  
  //配送员注册页面
  $(document).on("pageInit", "#page-form-signup", function(e, id, page) {
    var $content = $(page).find('.content');
    $content.on('click','.button-success',function () {
    	var username = $("#username").val();
    	var passwd = $("#passwd").val();
    	var passwd1 = $("#passwd1").val();
    	var realname = $("#realname").val();
    	var sex = $("#sex").val();
    	var phone = $("#phone").val();
    	var email = $("#email").val();
    	var numberType = $("#numberType").val();
    	var businessNumber = $("#number").val();
    	var businessName = $("#businessName").val();
    	
    	if (username == '')
    	{
    			$("#username").focus();
    	}else if (username.length < 6 || username.length > 20)
    	{
    			$.alert('账户名称长度必须在6-20个字符区间。');
    			$("#username").focus();
    	}else if (passwd == '')
    	{
    			$("#passwd").focus();
    	}else if (passwd1 == '')
    	{
		    	$("#passwd1").focus();
    	}else if (passwd != passwd1)
    	{
    			$.alert('两次密码不一致！');
		    	$("#passwd1").focus();
    	}else if (realname == '')
    	{
		    	$("#realname").focus();
    	}else if (sex == '')
    	{
		    	$("#sex").select();
    	}else if (phone == '')
    	{
		    	$("#phone").focus();
    	}else if (numberType == '')
    	{
		    	$("#numberType").focus();
    	}else if (businessNumber == '')
    	{
		    	$("#number").focus();
    	}else
    	{
    			$.showPreloader('正在注册...');
					//ajax请求提交
					var strUrl = 'app/signup_ajax.php?ac=post';
					$.ajax({
					  type: "POST",
					  url: strUrl,
					  data: {username: username, passwd: passwd,realname: realname,sex: sex,phone: phone,email: email,numberType: numberType,number: businessNumber,businessName: businessName},
					  success: function(data){
					  	$.hidePreloader();
					  	if (data.msg == 'ok')
					  	{
					  			$.showPreloader('注册成功！账户信息审核中...');
					  			location.href = 'main.php';
					  	}else if (data.msg == 'failed')
					  	{
					  			$.alert(data.content);				  		
					  	}
					  },
					  dataType: 'json'
					});
    	}
    });
    
    $("#number").keyup(function(){
    	var numberType = $("#numberType").val();
    	if (numberType == 'ABN' || numberType == 'ACN')
    	{
    			//因需要向https://abr.business.gov.au/Tools/WebServices 申请ugid，暂不启用
    	}
    });   
  });
  
  //抢单页面
  $(document).on("pageInit", "#page-order-list", function(e, id, page) {
  	clearInterval(timer1);
    //$.showPreloader('loading...');
		getOrderList();
		timer1 = setInterval("getOrderList()",order_reqtime);
		//refreshPage();

  });
  //接单列表页面，配送员需要前去取餐的订单
  $(document).on("pageInit", "#page-my-received-order-list", function(e, id, page) {
  	
  	$('#pickup-popup').on('change','input[type="checkbox"]',function(){
    if($('input[type="checkbox"]').prop('checked'))
      {
          $('#checkingOrder').prop('disabled',false);
          $('#checkingOrder').removeClass('disabled');
          $('#checkingOrder').addClass('button-dark');

      }
    else{
        $('#checkingOrder').prop('disabled',true);
        $('#checkingOrder').addClass('disabled');
        $('#checkingOrder').removeClass('button-dark');

    }});
  	clearInterval(timer1);
	getMyReceivedOrderList();
	timer1 = setInterval("getMyReceivedOrderList()",order_reqtime);

  });

  //配送订单列表页面
  $(document).on("pageInit", "#page-my-order-list", function(e, id, page) {  	
  	clearInterval(timer1);
    //$.showPreloader('loading...');
		getMyOrderList();
		timer1 = setInterval("getMyOrderList()",order_reqtime);
  });
  
  //配送历史订单列表页面
  $(document).on("pageInit", "#page-my-orderhistory-list", function(e, id, page) { 
  	var $content = $(page).find('.content');
    $content.on('click','#oh-tab1',function () {
    	clearInterval(timer1);
    	$("#content-list1").html('');
    	$.showPreloader('loading...');
    	getMyOrderHistoryList(30);
			timer1 = setInterval("getMyOrderHistoryList(30)",order_reqtime);
    });
    
    $content.on('click','#oh-tab2',function () {
      clearInterval(timer1);
      $("#content-list2").html('');
      $.showPreloader('loading...');      
    	getMyOrderHistoryList(1);
			timer1 = setInterval("getMyOrderHistoryList(1)",order_reqtime);
    });
    
    $content.on('click','#oh-tab3',function () {
      clearInterval(timer1);
      $("#content-list3").html('');
      $.showPreloader('loading...');
    	getMyOrderHistoryList(7);
			timer1 = setInterval("getMyOrderHistoryList(1)",order_reqtime);
    });
  	 	
  	clearInterval(timer1);
		getMyOrderHistoryList(30);
		timer1 = setInterval("getMyOrderHistoryList(30)",order_reqtime);
  });
  
  //配送员设置页面
  $(document).on("pageInit", "#page-settings-list", function(e, id, page) {
  	var $content = $(page).find('.content');	
		$content.on('click','#btnSubmit',function () {
      modifyPasswd();//修改配送员密码
    });
    clearInterval(timer1);
  });
  
	$.init();
});

$.config = {
    // 路由功能开关过滤器，返回 false 表示当前点击链接不使用路由
    routerFilter: function($link) {
        // 某个区域的 a 链接不想使用路由功能
        if ($link.is('.disable-router a')) {
            return false;
        }
        return true;
    }
};

function formatDate(ns)
{  
    return new Date(parseInt(ns)).toLocaleString().replace(/年|月/g, "-").replace(/日/g, " ");  
}

function showAddress(address)
{
		$.alert('<div><span>'+address+'</span></div>');
} 

/* main.php  begin */
function getOrderList()
{
		var strUrl = "app/orderlist_ajax.php?ac=update&random="+Math.random();
		$.ajax({
		  type: "GET",
		  url: strUrl,
		  data: '',
		  success: function(data){

		  	if (data.msg == 'ok')
		  	{
		  			//console.log($.parseJSON(data.content));
		  			var strHtml = '<ul>';
		  			var json = $.parseJSON(data.content);
		  			
		  			for ( var i=0, len=json.length ; i<len ; i++ )
		  			{
		  					var receiverAddress = json[i]['receiverAddressDetailed']+', '+json[i]['receiverAddress'];
				  			var senderAddress = ((json[i]['senderAddressDetailed'] == 'null')?json[i]['senderAddressDetailed']+', ':'') + json[i]['senderAddress'];
				  			strHtml += '<div class="card"><div class="card=content">';
		  					strHtml = strHtml+'<li><div class="item-inner content-padded"><div class="item-title-row"><div class="item-title">id:'+json[i]['id']+'</div><div class="item-after">'+formatDate(json[i]['createDate'])+'</div></div><div class="item-subtitle"><span style="font-weight:bold;">订单名称:</span>'+json[i]['name']+'</div><div class="item-subtitle"><span style="font-weight:bold;">店铺名:</span><a href="javascript:showAddress(\''+json[i]['senderName']+'\');">'+json[i]['senderName']+'</a></div><div class="item-subtitle"><span style="font-weight:bold;">发件人地址:</span><a href="javascript:showAddress(\''+senderAddress+'\');">'+senderAddress+'</a></div><div class="item-subtitle" style="whiteSpace:normal"><span style="font-weight:bold;">收件人地址:</span><a href="javascript:showAddress(\''+receiverAddress+'\');">'+receiverAddress+'</a></div><div class="item-text"><span style="font-weight:bold;">备注:</span>'+json[i]['note']+'</div><div class="item-subtitle"><span style="font-weight:bold;">其它备注:</span>'+json[i]['memo']+'</div><div class="item-subtitle" style="margin-top:10px"><div class="item-text "><a href="javascript:receive_order(\''+json[i]['code']+'\',\''+json[i]['name']+'\');" id="order_'+json[i]['id']+'" class="button button-fill">抢单</a></div></div></li>';
		  					strHtml += '</div></div></div>';
		  			}
		  			strHtml = strHtml+'</ul>';
		  			$("#content-list").html(strHtml);
		  	}else if (data.msg == 'failed')
		  	{
		  			$("#content-list").html("请求数据失败！");		  		
		  	}else if (data.msg == 'expired')
		  	{
		  			clearInterval(timer1);
		  			$.alert(data.content, function () {
			        location.href = 'logout.php';		        
			      });	  		
		  	}		  	
		  },
		  dataType: 'json'
		});
}

function receive_order(ordercode,name)
{
		clearInterval(timer1);
		$.showPreloader('正在抢这个订单...');
		var strUrl = "app/order_ajax.php?ac=receive&order_code="+ordercode+"&name="+name+"&random="+Math.random();
		$.ajax({
		  type: "GET",
		  url: strUrl,
		  data: '',
		  success: function(data){	  
		  	$.hidePreloader();
		  	if (data.msg == 'ok')
		  	{
		  			$.alert(data.content, function () {
			        //Joe modified 19/07/2017
			        //location.href = 'my_order.php';
			        location.href = 'my_received_order.php';
			        //End
			      });		
		  	}else if (data.msg == 'failed')
		  	{
		  			getOrderList();
		  			$.alert(data.content);
		  	}else if (data.msg == 'expired')
		  	{
		  			clearInterval(timer1);
		  			$.alert(data.content, function () {
			        location.href = 'logout.php';		        
			      });	  		
		  	}	  	
		  },
		  dataType: 'json'
		});
}
/* main.php  end */

/*确认取餐 */
function getMyReceivedOrderList()
{
	var strUrl = "app/my_received_order_ajax.php?ac=update&random="+Math.random();
		$.ajax({
		  type: "GET",
		  url: strUrl,
		  data: '',
		  success: function(data){
		  	if (data.msg == 'ok')
		  	{
		  			if (data.content != '[]')
		  			{
				  			$.hidePreloader();
				  			var strHtml = '<ul>';
				  			var json = $.parseJSON(data.content);

				  			
				  			for ( var i=0, len=json.length ; i<len ; i++ )
				  			{
				  					var receiverAddress = json[i]['receiverAddressDetailed']+', '+json[i]['receiverAddress'];
				  					var senderAddress = ((json[i]['senderAddressDetailed'] == 'null')?json[i]['senderAddressDetailed']+', ':'') + json[i]['senderAddress'];
				  					var lat = json[i]['senderAddressLat'];
				  					var lng = json[i]['senderAddressLon'];
				  					if (json[i]['payCode'] == null ) json[i]['payCode'] = '';
				  					var payType = strPayType(json[i]['payType']);
                     
				  					if(json[i]['status'] != 'CANCEL'&&json[i]['status'] != 'COMPLETE')
									{
									strHtml += '<div class="card"><div class="card=content">';	
									strHtml = strHtml+'<li>';
                                    strHtml +='<div class="item-inner content-padded"><div class="item-title-row">';
				  					strHtml +='<div class="item-title" id='+ json[i]['id'] + '>id:'+json[i]['id']+'</div><div class="item-after">'+formatDate(json[i]['createDate'])+'</div></div><div class="item-subtitle"><span style="font-weight:bold;">订单名称:</span>'+json[i]['name']+'</div><div class="item-subtitle"><span style="font-weight:bold;">发件人:</span>'+json[i]['senderName']+'&nbsp;&nbsp;</div><div class="item-subtitle"style="white-space:normal!important"><span style="font-weight:bold;">发件人地址:</span><a href="javascript:showAddress(\''+receiverAddress +'\');">'+senderAddress+'</a></div><div class="receiverHightlight" style="border:1px solid #ff9500;"><div class="item-subtitle"><span style="font-weight:bold;">收件人:</span>'+json[i]['receiverName']+'&nbsp;&nbsp;</div><div class="item-subtitle"><span style="font-weight:bold;">电话:</span><a href="tel:'+json[i]['receiverPhone']+'">'+json[i]['receiverPhone']+'</a></div><div class="item-subtitle"style="white-space:normal!important"><span style="font-weight:bold;">收件人地址:</span><a href="javascript:showAddress(\''+receiverAddress+'\');">'+receiverAddress+'</a></div></div><div class="item-subtitle"><span style="font-weight:bold;">备注:</span>'+json[i]['note']+'</div>';

        	  						strHtml += '<div class="item-subtitle"><span style="font-weight:bold;">配送状态:</span>'+json[i]['status']+'</div>';
        	  						strHtml += '<div class="item-subtitle"><span style="font-weight:bold;">支付类型:</span>'+ payType +'&nbsp;&nbsp;<span style="font-weight:bold;">支付编码:</span>'+json[i]['payCode']+'</div>';
				  					strHtml += '<div class="item-subtitle"><span style="font-weight:bold;">其它备注:</span>'+json[i]['memo']+'</div>';
				  					
				  					strHtml += '<div class="item-text"><p class="buttons-row"><a href="javascript:cancel_order(\''+json[i]['code']+'\',\''+json[i]['name']+'\');" class="button button-danger" data-operation ="cancelOrder"' + 'style="font-weight:bold;">取消</a>';

                                  if(json[i]['status']!='CANCEL')
                                  {	
                                  	 strHtml = strHtml+'<a href="" class="button active confirmPickUp open-popup-pick-up"'+ 'style="font-weight:bold;" onclick="checkPickUp('+'\''  + escapeHtml(json[i]['memo']) + '\',\'' + escapeHtml(json[i]['code']) +'\''+')">确认取餐'+'</a>';
                                  }

                                   strHtml += '</div></li></div></div>'

							}
                                
				  			}
				  			strHtml = strHtml+'</ul>';                           
		  			}
		  			else
		  			{
		  					strHtml = '<div style="margin-left:15px;font-size:14px;">您没有正在配送中的订单。</div>';
		  			}
		  			$("#content-list0").html(strHtml);
               
		  	}else if (data.msg == 'failed')
		  	{
		  			//$("#content-list1").html("请求数据失败！");		  		
		  	}else if (data.msg == 'expired')
		  	{
		  			clearInterval(timer1);
		  			$.alert(data.content, function () {
			        location.href = 'logout.php';		        
			      });	  		
		  	}	  	
		  },
		  dataType: 'json'
		});
}

function catchAnchorId(st)
{
	
	var tmpP = st.indexOf('order_id=');
	var id = st.substring(tmpP+9,tmpP+16);

	return id;

}

function checkPickUp(currMemo,orderCode){
	clearInterval(timer1);
	//currMemo = '<a target="_blank" href="https://admintest.ozhaha.com/backend/pandadelivery_api?mod=order&amp;order_id=1000275&amp;source=item">查看菜品详情</a>';
	var orderId = catchAnchorId(currMemo);
	var  strUrl = datalist_url_base + 'backend/pandadelivery_api?mod=order&order_id=' + orderId+ '&source=item';
	$('#dishesList').attr('src',strUrl);
	$('#order-info').val(orderCode);
	$('#order-info').attr('data-memo', currMemo);
   	$.popup('.popup-pick-up');

}

function checkOrders(){

  $.confirm('已核实菜品, 已包括饭，餐具？', '核对菜品', function(){
         $('#checkingPay').css('display','block');
         $('#checkingOrder').css('display','none');
  });
}

function ConfirmPickUp(){
	var actualPay = $('#actualPay').val();
	var orderCode = $('#order-info').val();
	var prevMemo = $('#order-info').attr('data-memo');
	var submitData = {actual_pay:actualPay,order_code:orderCode,prev_memo:prevMemo};	
	var strUrl = "app/order_ajax.php?ac=confirmPickup&random="+Math.random();
	$.ajax({
		url:strUrl,
		data:submitData,
		type: 'POST',
		success: function(data){

			if(data.msg =='ok')
			{
				if(data.result)
				{
					$.confirm('请在 ‘我正在配送’ 界面继续操作该单','已确认');
				}
				else{
					console.log(data.content);
				}

			}
			
		},
		error: function(xhr, status, error){

			alert('status: ' + status + '; msg: '+error.Message);
		}
	});
	 $.closeModal();
	clearPopupInputs();
 	getMyReceivedOrderList();
	timer1 = setInterval("getMyReceivedOrderList()",order_reqtime);

}

function clearPopupInputs()
{
	 $('#order-info').val('');
	 $('#dishesList').attr('src','');
	 $('#actualPay').val('');
	 $('input[type="checkbox"]').prop('checked',false);
	 $('#checkingPay').css('display','none');
     $('#checkingOrder').css('display','block');
     $('#checkingOrder').prop('disabled',true);
     $('#checkingOrder').addClass('disabled');
     $('#order-info').removeAttr('data-memo');
	 
}
/*my_received_order.php end*/

/* my_order.php  begin */
function getMyOrderList()
{
		var strUrl = "app/myorder_ajax.php?ac=update&random="+Math.random();
		$.ajax({
		  type: "GET",
		  url: strUrl,
		  data: '',
		  success: function(data){
		  	if (data.msg == 'ok')
		  	{
		  			if (data.content != '[]')
		  			{
				  			$.hidePreloader();
				  			var strHtml = '<ul>';
				  			var json = $.parseJSON(data.content);

				  			
				  			for ( var i=0, len=json.length ; i<len ; i++ )
				  			{
				  					var receiverAddress = json[i]['receiverAddressDetailed']+', '+json[i]['receiverAddress'];
				  					var senderAddress = ((json[i]['senderAddressDetailed'] == 'null')?json[i]['senderAddressDetailed']+', ':'') + json[i]['senderAddress'];
				  					var lat = json[i]['senderAddressLat'];
				  					var lng = json[i]['senderAddressLon'];
				  					if (json[i]['payCode'] == null ) json[i]['payCode'] = '';
				  					if (json[i]['memo'] == null ) json[i]['memo'] = '';
			
				  					var payType = strPayType(json[i]['payType']);
                        			//<div class="item-subtitle"><span style="font-weight:bold;">电话:</span><a href="tel:'+json[i]['senderPhone']+'">'+json[i]['senderPhone']+'</a></div>
				  					if(json[i]['status'] != 'CANCEL'&&json[i]['status'] != 'COMPLETE')
									{
									strHtml += '<div class="card"><div class="card=content">';	
									strHtml = strHtml+'<li>';
                                    strHtml +='<div class="item-inner content-padded"><div class="item-title-row">';
				  					strHtml +='<div class="item-title" id='+ json[i]['id'] + '>id:'+json[i]['id']+'</div><div class="item-after">'+formatDate(json[i]['createDate'])+'</div></div><div class="item-subtitle"><span style="font-weight:bold;">订单名称:</span>'+json[i]['name']+'</div><div class="item-subtitle"><span style="font-weight:bold;">发件人:</span>'+json[i]['senderName']+'&nbsp;&nbsp;</div><div class="item-subtitle"style="white-space:normal!important"><span style="font-weight:bold;">发件人地址:</span><a href="javascript:showAddress(\''+receiverAddress +'\');">'+senderAddress+'</a></div><div class="receiverHightlight" style="border:1px solid #ff9500;"><div class="item-subtitle"><span style="font-weight:bold;">收件人:</span>'+json[i]['receiverName']+'&nbsp;&nbsp;</div><div class="item-subtitle"><span style="font-weight:bold;">电话:</span><a href="tel:'+json[i]['receiverPhone']+'">'+json[i]['receiverPhone']+'</a></div><div class="item-subtitle" style="white-space:normal!important"><span class="" style="font-weight:bold;">收件人地址:</span><a href="javascript:showAddress(\''+receiverAddress+'\');">'+receiverAddress+'</a></div></div><div class="item-subtitle"><span style="font-weight:bold;">重量:</span><span style="color:blue;">'+json[i]['weight']+'kg</span>&nbsp;&nbsp;<span style="font-weight:bold;">备注:</span>'+json[i]['note']+'</div>';

        	  						strHtml += '<div class="item-subtitle"><span style="font-weight:bold;">配送状态:</span>'+json[i]['status']+'</div>';
        	  						strHtml += '<div class="item-subtitle"><span style="font-weight:bold;color:#f6383a">支付类型:</span>'+ payType +'&nbsp;&nbsp;<span style="font-weight:bold;">支付编码:</span>'+json[i]['payCode']+'</div>';
				  					strHtml += '<div class="item-subtitle"><span style="font-weight:bold;">其它备注:</span>'+json[i]['memo']+'</div>';

				  					strHtml += '<div class="item-text"><p class="buttons-row"><a href="javascript:cancel_order(\''+json[i]['code']+'\',\''+json[i]['name']+'\');" class="button button-danger" data-operation ="cancelOrder"' + 'style="font-weight:bold;">取消</a>';

				  					//Joe
				  					//ordercode,userId,memo,payType
                                  if(json[i]['status']!='CANCEL')
                                  {	

                                   if(json[i]['payType'] !='PAYPAL')
                                   {
                                   
                                   if(json[i]['payCode']!='')
                                   {
  									strHtml = strHtml +'<a href="javascript:done_order(\''+ json[i]['code']+ '\',\'' + json[i]['name'] + '\',\''+json[i]["payCode"]+'\');" class="button active" data-operation ="finishOrder' + i + '"' + 'style="font-weight:bold;">确认送达</a></p></div>';
                                   }
                                   else
                                   {
                                   	  strHtml = strHtml+'<a href="javascript:confirm_payment(\''+ json[i]['code']+ '\',\'' + json[i]['userId'] + '\',\'' + escapeHtml(json[i]['memo']) +  '\',\'' + json[i]['payType'] + '\');" class="  button button-success" data-operation="confirmPayment' + i + '"' + 'style="font-weight:bold;">确认收款'+'</a>';
                                   }   
                                   }
                                   else
                                   {
                                   	
                                   	strHtml = strHtml +'<a href="javascript:done_order(\''+ json[i]['code']+ '\',\'' + json[i]['name'] + '\',\''+json[i]["payCode"]+ '\');" class="button button-round active" data-operation ="finishOrder' + i + '"' + 'style="font-weight:bold;">确认送达</a></p></div>';

                                   }}

                                   strHtml += '</div></li></div></div>'

							}
                                
				  			}
				  			strHtml = strHtml+'</ul>';                           
		  			}else
		  			{
		  					strHtml = '<div style="margin-left:15px;font-size:14px;">您没有正在配送中的订单。</div>';
		  			}
		  			$("#content-list1").html(strHtml);

		  	}else if (data.msg == 'failed')
		  	{
		  			//$("#content-list1").html("请求数据失败！");		  		
		  	}else if (data.msg == 'expired')
		  	{
		  			clearInterval(timer1);
		  			$.alert(data.content, function () {
			        location.href = 'logout.php';		        
			      });	  		
		  	}	  	
		  },
		  dataType: 'json'
		});
}

function cancel_order(ordercode,name)//取消配送订单
{
		//clearInterval(timer1);
		//$.showPreloader('正在取消这个订单...');
	//var strUrl = "app/order_ajax.php?ac=cancel&order_code="+ordercode+"&name="+name+"&random="+Math.random();
	// var str = "<iframe height=800 allowTransparency=true" + ' style="width:100%;border:none;overflow:auto;" frameborder="0" src="http://au.mikecrm.com/44vbt2S">' +"</iframe>";
	// document.location = "http://au.mikecrm.com/44vbt2S?order_id ='hahahah'";
	// c = url.searchParams.get('order_id');
	 //$('input[data-reactid=".0.0.0:$c200005851.1.0.0.2"]').val('haha');
	// alert('c');
		//return str;
		//alert(str);
		// $.ajax({
		//   type: "GET",
		//   url: strUrl,
		//   data: '',
		//   success: function(data){		  	
		//   	if (data.msg == 'ok')
		//   	{
		//   			$.hidePreloader();
		//   			$.alert(data.content, function () {
		// 	        getMyOrderList();			        
		// 	      });		
		//   	}else if (data.msg == 'failed')
		//   	{		  					  				
		//   			$.hidePreloader();
		//   			$.alert(data.content);
		//   			getMyOrderList();
		//   	}else if (data.msg == 'expired')
		//   	{
		//   			clearInterval(timer1);
		//   			$.alert(data.content, function () {
		// 	        location.href = 'logout.php';		        
		// 	      });	  		
		//   	} 	
		//   },
		//   error:function(err){
		//   	  $.hidePreloader();
  //             console.log(err.responseText);

		//   },
		//   dataType: 'json'
		// });
	 alert('配送员无法取消订单，取消订单请于管理后台联系！！');
}

function done_order(ordercode,name,paycode)//确认送达
{
		clearInterval(timer1);		
		$.confirm('<span style="font-size:14px;">注意：确认送达操作后，不可逆向操作。</span>','你确定吗?', function () {
				$.showPreloader('正在确认送达...');
				var strUrl = "app/order_ajax.php?ac=done&order_code="+ordercode+"&name="+name+"&pay_code="+paycode+"&random="+Math.random();
				$.ajax({
				  type: "GET",
				  url: strUrl,
				  data: '',
				  success: function(data){
				  	if (data.msg == 'ok')
				  	{
				  			$.hidePreloader();
				  			$.alert(data.content, function () {
					        getMyOrderList();
					        timer1 = setInterval("getMyOrderList()",order_reqtime);
					      });		
				  	}else if (data.msg == 'failed')
				  	{		  			
				  			$.hidePreloader();
				  			$.alert(data.content);
				  			getMyOrderList();
				  			timer1 = setInterval("getMyOrderList()",order_reqtime);
				  	}else if (data.msg == 'expired')
				  	{
				  			
				  			clearInterval(timer1);
				  			$.alert(data.content, function () {
					        location.href = 'logout.php';		        
					      });	
				  	}		  	
				  },
				  error: function(err){
				  	$.hidePreloader();
                    $console.log(err.responseText);
					getMyOrderList();
					timer1 = setInterval("getMyOrderList()",order_reqtime);
					      

				  },
				  dataType: 'json'
				});
		},function (){
				getMyOrderList();
				timer1 = setInterval("getMyOrderList()",order_reqtime);
		});	
}

function TotalPrice(memoString)
{
    var keyPos= 0
	var pricePos = 1;
	var strArray = memoString.split(';');
	var totalPrice =0;
	strArray.forEach(function(v,i)
	{
       
       if((v.toUpperCase()).match('TOTAL'))
       //if(v.includes('total'.toUpperCase()))
       //var string ='TOTAL';
       //if(v.indexOf('TOTAL')!==-1)
       {
       	 tmpArray = v.split(':');
 	     totalPrice = parseFloat(tmpArray[pricePos]);

       }});
    return totalPrice;

}

function confirm_payment(ordercode,userId,memo,payType)//确认收款
{
	
	var totalPrice = TotalPrice(memo);
		// + '<div style="font-size:18px;">备忘: <input class="modal-text-input" style="front-size:1.2em; type="text" name ="pNote"></div>'
		clearInterval(timer1);	 
		if(payType!='paypal'){
		$.confirm('<div style="text-align:left;padding-bottom:3px;"><div style="font-size:18px;">应收款: $' + totalPrice +'</div>'
			+'<div style="font-size:18px;">实际收: <input class="modal-text-input" style="display:inline-block;" type="number" name ="actualPay"></div>'
			+'</div>','确认收款', function () {
		       
		        var actualPay = $('input[name="actualPay"]').val();
                //var note = $('input[name="pNote"]').val();
                var note = '';
				$.showPreloader('正在确认送达...');
				var strUrl = "app/order_ajax.php?ac=confirmPay&order_code="+ordercode+"&actual_pay="+ actualPay +"&user_id="+ userId + "&total_price="+ totalPrice + "&note=" + note + "&random="+Math.random();
				$.ajax({
				  type: "GET",
				  url: strUrl,
				  data: '', 
				  success: function(data){
				  	if (data.msg == 'ok')
				  	{
				  			$.hidePreloader();
				  			$.alert(data.content, function () {
					        getMyOrderList();
					        timer1 = setInterval("getMyOrderList()",order_reqtime);
					      });		
				  	}else if (data.msg == 'failed')
				  	{		  			
				  			$.alert(data.content);
				  			getMyOrderList();
				  			timer1 = setInterval("getMyOrderList()",order_reqtime);
				  	}else if (data.msg == 'expired')
				  	{
				  			clearInterval(timer1);
				  			$.alert(data.content, function () {
					        location.href = 'logout.php';		        
					      });	
				  	}		  	
				  },
				  dataType: 'json',
				  error: function(err){
                      $.hidePreloader();
                      $.alert(err.responseText, function () {
					        getMyOrderList();
					        timer1 = setInterval("getMyOrderList()",order_reqtime);
					      });
				  }
				});
		},function (){
				getMyOrderList();
				timer1 = setInterval("getMyOrderList()",order_reqtime);
				});	
		}
		else
		{
			alert('confirmed!');
		}
}
//End
/* my_order.php  end */

/* my_orderhistory.php  begin */
function getMyOrderHistoryList(day)
{
		var strUrl = "app/myorderhistory_ajax.php?ac=update&day="+day+"&random="+Math.random();
		var content_id = '#content-list';
		switch(day)
		{
				case 30:
						content_id = content_id+'1';
				break;
				case 1:
						content_id = content_id+'2';
				break;
				case 7:
						content_id = content_id+'3';
				break;
		}		
		$.ajax({
		  type: "GET",
		  url: strUrl,
		  data: '',
		  success: function(data){
		  	$.hidePreloader();
		  	if (data.msg == 'ok')
		  	{
		  			if (data.content != '[]')
		  			{				  			
				  			var strHtml = '<ul>';
				  			var json = $.parseJSON(data.content);
				  			
				  			for ( var i=0, len=json.length ; i<len ; i++ )
				  			{
				  				var receiverAddress = json[i]['receiverAddressDetailed']+', '+json[i]['receiverAddress'];
				  				var senderAddress = ((json[i]['senderAddressDetailed'] == 'null')?json[i]['senderAddressDetailed']+', ':'') + json[i]['senderAddress'];
          						var payType = strPayType(json[i]['payType']);
				  					//if (json[i]['status'] == 'DELIVERY')
				  					//{
				  					//<span style="font-weight:bold;">电话:</span><a href="tel:'+json[i]['senderPhone']+'">'+json[i]['senderPhone']+'</a>     
						  		if (json[i]['payCode'] == null ) json[i]['payCode'] = '';
						  			strHtml += '<div class="card"><div class="card=content">';	
						  			strHtml = strHtml+'<li><div class="item-inner content-padded"><div class="item-title-row"><div class="item-title">id:'+json[i]['id']+'</div><div class="item-after">'+formatDate(json[i]['createDate'])+'</div></div><div class="item-subtitle"><span style="font-weight:bold;">订单名称:</span>'+json[i]['name']+'</div><div class="item-subtitle"><span style="font-weight:bold;">发件人:</span>'+json[i]['senderName']+'&nbsp;&nbsp;</div><div class="item-subtitle"><span style="font-weight:bold;">发件人地址:</span><a href="javascript:showAddress(\''+ senderAddress +'\');">'+ senderAddress +'</a></div><div class="item-subtitle"><span style="font-weight:bold;">收件人:</span>'+json[i]['receiverName']+'&nbsp;&nbsp;<span style="font-weight:bold;">电话:</span><a href="tel:'+json[i]['receiverPhone']+'">'+json[i]['receiverPhone']+'</a></div><div class="item-subtitle"><span style="font-weight:bold;">收件人地址:</span><a href="javascript:showAddress(\''+ receiverAddress +'\');">'+receiverAddress+'</a></div><div class="item-subtitle"><span style="font-weight:bold;">重量:</span><span style="color:blue;">'+json[i]['weight']+'kg</span>&nbsp;&nbsp;<span style="font-weight:bold;">备注:</span>'+json[i]['note']+'<div class="item-subtitle"><span style="font-weight:bold;">配送状态:</span>'+json[i]['status']+'</div>'+'</div><div class="item-subtitle"><span style="font-weight:bold;">支付类型:</span>'+payType+'&nbsp;&nbsp;<span style="font-weight:bold;">支付编码:</span>'+json[i]['payCode']+'</div><div class="item-subtitle"><span style="font-weight:bold;">其它备注:</span>'+json[i]['memo']+'</div></div></li>';
						  			strHtml += '</div></div>';
				  					//}
				  			}
				  			strHtml = strHtml+'</ul>';
		  			}else
		  			{
		  					strHtml = '<div style="margin-left:15px;font-size:14px;">您没有配送的历史订单。</div>';
		  			}
		  			$(content_id).html(strHtml);
		  	}else if (data.msg == 'failed')
		  	{
		  			//$("#content-list1").html("请求数据失败！");		  		
		  	}else if (data.msg == 'expired')
		  	{
		  			clearInterval(timer1);
		  			$.alert(data.content, function () {
			        location.href = 'logout.php';		        
			      });	  		
		  	}	  	
		  },
		  dataType: 'json'
		});
}
/* my_orderhistory.php  end */

/* settings.php  begin */
function modifyPasswd()
{		
		var passwd = $("#passwd").val();
		var passwd_1 = $("#passwd1").val();
		var passwd_2 = $("#passwd2").val();				
  	if (passwd == '')
  	{
  			$.alert('当前的密码不能为空！');
  	}else if (passwd_1 == '')
  	{
  			$.alert('新密码不能为空！');
  	}else if (passwd_1 != passwd_2)
  	{
  			$.alert('新密码两次输入不一致！');
  	}else
  	{  			
				$.showPreloader('处理中...');					
				var strUrl = "app/settings_ajax.php?ac=modifypasswd&random="+Math.random();
				$.ajax({
				  type: "POST",
				  url: strUrl,
				  data: {passwd: passwd, passwd1: passwd_1},
				  success: function(data){	  
				  	$.hidePreloader();
				  	if (data.msg == 'ok')
				  	{
				  			$.alert(data.content, function () {
					        $("#passwd").val("");
					        $("#passwd1").val("");
					        $("#passwd2").val("");
					      });		
				  	}else if (data.msg == 'failed')
				  	{				  			
				  			$.alert(data.content);
				  	}else if (data.msg == 'expired')
				  	{
				  			clearInterval(timer1);
				  			$.alert(data.content, function () {
					        location.href = 'logout.php';		        
					      });	  		
				  	}	  	
				  },
				  dataType: 'json'
				});
		}
}

function copyToClipboard(elem) {
	  // create hidden text element, if it doesn't already exist
    var targetId = "_hiddenCopyText_";
    var isInput = elem.tagName === "INPUT" || elem.tagName === "TEXTAREA";
    var origSelectionStart, origSelectionEnd;
    if (isInput) {
        // can just use the original source element for the selection and copy
        target = elem;
        origSelectionStart = elem.selectionStart;
        origSelectionEnd = elem.selectionEnd;
    } else {
        // must use a temporary form element for the selection and copy
        target = document.getElementById(targetId);
        if (!target) {
            var target = document.createElement("textarea");
            target.style.position = "absolute";
            target.style.left = "-9999px";
            target.style.top = "0";
            target.id = targetId;
            document.body.appendChild(target);
        }
        target.textContent = elem.textContent.split(':')[1];
    }
    // select the content
    var currentFocus = document.activeElement;
    target.focus();
    target.setSelectionRange(0, target.value.length);
    
    // copy the selection
    var succeed;
    try {
    	  succeed = document.execCommand("copy");
    } catch(e) {
        succeed = false;
    }
    // restore original focus
    if (currentFocus && typeof currentFocus.focus === "function") {
        currentFocus.focus();
    }
    
    if (isInput) {
        // restore prior selection
        elem.setSelectionRange(origSelectionStart, origSelectionEnd);
    } else {
        // clear temporary content
        target.textContent = "";
    }
    return succeed;
}


/* settings.php  end */
//Joe
//private function, to escape string input
var entityMap = {
  '&': '&amp;',
  '<': '&lt;',
  '>': '&gt;',
  '"': '&quot;',
  "'": '&#39;',
  '/': '&#x2F;',
  '`': '&#x60;',
  '=': '&#x3D;'
};

function escapeHtml (string) {
  
if(string)
{
  string = string.replace(/'/g, '"');
  return String(string).replace(/[&<>"'`=\/]/g, function (s) {
    return entityMap[s];
  });
}
else{
	return 'N/A';
}
}

var payTypeMap = {
'OTHER':'余额支付',
'RECEIVER':'到付',
'PAYPAL':'PAYPAL支付',
'SENDER':'SENDER',
'EWAY':'EWAY'

};

function strPayType(s){
	if(s)
	{
		return '<span style="font-weight:bold;color:#f6383a;">'+ payTypeMap[s.toUpperCase()] + '</span>';
	}
	else{
		return 'N/A';
	} 

}

function createCookie(name,value,days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + value + expires + "; path=/";
}

function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}

function eraseCookie(name) {
    createCookie(name,"",-1);
}

function decrpyt(val, str)
{
	return JSON.parse(CryptoJS.AES.decrypt(val, str, {format: CryptoJSAesJson}).toString(CryptoJS.enc.Utf8));
}
//End