<script>
//gps上报接口
var latlng;
var gps_reqtime = 15000;//gps更新时间 单位毫秒
wx.config({
	  //debug: true,
	  appId: '<?=$signPackage["appId"];?>',
	  timestamp: <?=$signPackage["timestamp"];?>,
	  nonceStr: '<?=$signPackage["nonceStr"];?>',
	  signature: '<?=$signPackage["signature"];?>',
	  jsApiList: [
	    // 所有要调用的 API 都要加到这个列表中
	    'getLocation'
	  ]
});

wx.ready(function () {
	  // 在这里调用 API    
	  getLocation();
	  setInterval("getLocation()",gps_reqtime); 
});

function getLocation()
{    		
		wx.getLocation({
		type:"wgs84",
        success: function (res) {
      	//latlng = JSON.stringify(res);
      	var strUrl = "app/gps_ajax.php?ac=update&longitude="+ res.longitude +"&latitude="+ res.latitude +"&accuracy=" + res.accuracy +"&random="+Math.random();
		    $.ajax({
				  type: "GET",
				  url: strUrl,
				  data:'' ,//{latlng: latlng}
				  success: function(data){
				  	if (data != null)
				  	{
						  	if (data.msg == 'ok')
						  	{
						  			//$.alert('gps更新成功。');			
						  	}else if (data.msg == 'failed')
						  	{
						  			//$.alert('GPS更新失败');				  		
						  	}else if (data.msg == 'expired')
						  	{
						  			$.alert(data.content, function () {
							        location.href = 'logout.php';		        
							      });  		
						  	}
				  	}
				  },
				  dataType: 'json'
				});
      },
      cancel: function (res) {
        $.alert('用户拒绝授权获取地理位置！');
      }
    });    
}

wx.error(function (res){
  	$.alert(res.errMsg);
});
</script>