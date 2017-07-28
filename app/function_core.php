<?php

function panda_set_headers()//ÉèÖÃheaderÍ·
{
		$headers = array();
		$headers[] = 'X-Apple-Tz: 0';
		$headers[] = 'X-Apple-Store-Front: 143444,12';
		$headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8';
		$headers[] = 'Accept-Encoding: gzip, deflate, sdch';
		$headers[] = 'Accept-Language: zh-CN,zh;q=0.8';
		$headers[] = 'Cache-Control: no-cache';
		$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.111 Safari/537.36';
		$headers[] = 'X-MicrosoftAjax: Delta=true';
		$headers[] = 'Content-type: application/json';
		return $headers;
}

function panda_submit_curl($method,$headers,$config)//curlÇëÇó
{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_URL, $config['curl_url']);
		curl_setopt($ch, CURLOPT_REFERER, $config['curl_refer']); //¹¹ÔìÀ´Â·
		curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
		if ($method == 'post')
		{
				curl_setopt($ch, CURLOPT_POST, 1);//ÉèÖÃÎªPOST·½Ê½
				
		}elseif ($method == 'put')
		{
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
		}
		if ($method == 'post' || $method == 'put') curl_setopt($ch, CURLOPT_POSTFIELDS, $config['curl_data']);//Ìá½»Êý¾Ý
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_TIMEOUT,$config['curl_timeout']);
		curl_setopt($ch, CURLOPT_ENCODING, "");
		$out = curl_exec($ch);
		$httpinfo = curl_getinfo($ch);
		curl_close($ch);
		//var_dump($httpinfo['http_code']);
		if ($httpinfo['http_code'] != '200') $out = '300';
		//$out = $httpinfo['http_code'];
		return $out;
}

function panda_employee_verify($data)//ÑéÖ¤ÅäËÍÔ±ÃÜÂë
{
		global $config;
		
		$result = 0;
		$headers = panda_set_headers();
		$config['curl_url'] = $config['api_host'].'/employee/verify?name='.$data['name'].'&password='.$data['password'];		
		$config['curl_data'] = '';
		$out = panda_submit_curl('get',$headers,$config);
		if ($out)
		{
				$arr = json_decode($out,true);
				if ($arr['code'] == '0') $result = (bool)($arr['data']);
		}
		unset($out);
		return $result;
}

function panda_employee_id($data)//Í¨¹ý±àºÅ²éÑ¯ÅäËÍÔ±ÐÅÏ¢
{
		global $config;
		
		$result = array();
		$headers = panda_set_headers();
		$config['curl_url'] = $config['api_host'].'/employee/'.$data['dm_uid'];		
		$config['curl_data'] = '';
		$out = panda_submit_curl('get',$headers,$config);
		if ($out)
		{
				$arr = json_decode($out,true);
				if ($arr['code'] == '0') $result = $arr['data'];
		}
		unset($out);
		return $result;
}

function panda_employee_login($data)//ÅäËÍÔ±µÇÂ¼
{
		global $config;
		
		$dm_uid = 0;
		$headers = panda_set_headers();
		$config['curl_url'] = $config['api_host'].'/employee/login?name='.$data['name'].'&password='.$data['password'];
		$config['curl_data'] = '';
		$out = panda_submit_curl('get',$headers,$config);
		if ($out)
		{
				$arr = json_decode($out,true);
				if ($arr['code'] == '0')
				{
						$dm_uid = intval($arr['data']['id']);
						$d['dm_uid'] = $dm_uid;
						$dm_info = panda_employee_id($d);
						$_SESSION['dm_username'] = $data['name'];
						$_SESSION['dm_uid'] = $dm_uid;
						$_SESSION['dm_token'] = $arr['data']['token'];
						$_SESSION['dm_status'] = $dm_info['status'];
				}
		}
		unset($out);
		return $dm_uid;
}

function panda_employee_logout($data)//ÅäËÍÔ±×¢Ïú
{
		global $config;
		
		$result = 0;
		$headers = panda_set_headers();
		$config['curl_url'] = $config['api_host'].'/employee/logout?id='.$data['dm_uid'].'&token='.$data['dm_token'];
		$config['curl_data'] = '';
		$out = panda_submit_curl('get',$headers,$config);	
		if ($out)
		{
				$arr = json_decode($out,true);
				if ($arr['code'] == '0' && $arr['data']) $result = 1;		
		}
		unset($out);
		return $result;
}

function panda_employee_add($data)//´´½¨ÅäËÍÔ±
{
		global $config;
		
		$dm_uid = 0;
		$headers = panda_set_headers();
		$config['curl_url'] = $config['api_host'].'/employee/add';		
		$config['curl_data'] = json_encode($data);
		unset($data);
		$out = panda_submit_curl('post',$headers,$config);
		if ($out)
		{
				$arr = json_decode($out,true);
				if ($arr['code'] == '0') $dm_uid = intval($arr['data']);
		}
		unset($out);
		return $dm_uid;
}

function panda_admin_employee_add($data)//¹ÜÀíÔ±´´½¨ÅäËÍÔ±
{
		global $config;
		
		$dm_uid = 0;
		$headers = panda_set_headers();
		$config['curl_url'] = $config['api_host_admin'].'/admin/employee/add';		
		$config['curl_data'] = json_encode($data);
		unset($data);
		$out = panda_submit_curl('post',$headers,$config);		
		if ($out)
		{
				$arr = json_decode($out,true);
				if ($arr['code'] == '0') $dm_uid = intval($arr['data']);
		}
		unset($out);
		return $dm_uid;
}

function panda_employee_update_place($data)//¸üÐÂÅäËÍÔ±×ø±êÐÅÏ¢
{
		global $config;
		
		$result = 0;
		$headers = panda_set_headers();
		$config['curl_url'] = $config['api_host'].'/employee/update_place?id='.$data['dm_uid'].'&longitude='.$data['longitude'].'&latitude='.$data['latitude'].'&address='.$data['address'];
		$config['curl_data'] = '';
		unset($data);
		$out = panda_submit_curl('put',$headers,$config);
		if ($out)
		{
				$arr = json_decode($out,true);
				if ($arr['code'] == '0' && $arr['data']) $result = 1;
		}		
		unset($out);		
		return $result;
}

function panda_employee_update_password($data)//ÐÞ¸ÄÅäËÍÔ±ÃÜÂë
{
		global $config;
		
		$result = 0;
		$headers = panda_set_headers();
		$config['curl_url'] = $config['api_host'].'/employee/update_password?id='.$data['dm_uid'].'&name='.$data['dm_username'].'&password='.$data['password'].'&newPassword='.$data['newPassword'];
		$config['curl_data'] = '';
		unset($data);
		$out = panda_submit_curl('put',$headers,$config);
		if ($out)
		{
				$arr = json_decode($out,true);
				if ($arr['code'] == '0' && $arr['data']) $result = 1;
		}		
		unset($out);		
		return $result;
}
//Joe
function panda_order_detail($data) //获取订单信息
{
        global $config;

        $output = '';
        $headers = panda_set_headers();
        $config['curl_url'] = $config['api_host'].'/order/'.$data['order_code'];
		$config['curl_data'] = '';
		unset($data);
		
	    $out = panda_submit_curl('get',$headers,$config);
		if ($out)
		{
				$arr = json_decode($out,true);
				if ($arr['code'] == '0') $output = json_encode($arr['data']);			
		}
		unset($out);
		return $output; 
  

}

function update_order_memo($data)
{
	global $config;
	$result = 0;
	$headers = panda_set_headers();
	$config['curl_url'] = $config['api_host'].'/employee/update_order_memo?id='.$data['dm_uid'].'&token='.$data['dm_token'].'&orderCode='.$data['order_code'].'&memo='.urlencode($data['memo']);
	//var_dump($config['curl_url']);
	unset($data);
	$out = panda_submit_curl('put',$headers,$config);
	//var_dump($out);
	if ($out)
	{
		$arr = json_decode($out,true);
		if ($arr['code'] == '0' && $arr['data']) $result = 1;
	}
	unset($out);		
	return $result;

}
//End

function panda_order_list_by_distance($data)//ËÑË÷ÖÜ±ßµÄ¶©µ¥
{
		global $config;
		
		$list = '';
		$headers = panda_set_headers();
		$config['curl_url'] = $config['api_host'].'/order/list_by_distance?longitude='.$data['longitude'].'&latitude='.$data['latitude'].'&distance='.$data['distance'];
		$config['curl_data'] = '';
		
	

		$out = panda_submit_curl('get',$headers,$config);
		if ($out)
		{
				$arr = json_decode($out,true);
				if ($arr['code'] == '0') $list = json_encode($arr['data']);			
		}
		unset($out);
		return $list;
}

function panda_order_list_by_employee($data)//ÅäËÍÖÐµÄ¶©µ¥
{
		global $config;
		
		$list = '';
		$headers = panda_set_headers();
		$config['curl_url'] = $config['api_host'].'/order/list_by_employee?employeeId='.$data['employeeId'].'&token='.$data['token'];
		$config['curl_data'] = '';
		$out = panda_submit_curl('get',$headers,$config);
		if ($out)
		{
				$arr = json_decode($out,true);
				if ($arr['code'] == '0') $list = json_encode($arr['data']);			
		}
		unset($out);
		return $list;
}

function panda_employee_update_dispatch_status($data)//ÅäËÍÔ±¶©µ¥×´Ì¬¸üÐÂ
{
		global $config;
		
		$result = 0;
		$headers = panda_set_headers();
		$config['curl_url'] = $config['api_host'].'/employee/update_dispatch_status?dispatchStatus='.$data['dispatchStatus'].'&id='.$data['dm_uid'].'&token='.$data['dm_token'].'&orderCode='.$data['order_code'];
		$config['curl_data'] = '';
		unset($data);
		$out = panda_submit_curl('put',$headers,$config);		
		if ($out)
		{
				$arr = json_decode($out,true);
				if ($arr['code'] == '0' && $arr['data']) $result = 1;
		}
		unset($out);		
		return $result;
}

function panda_employee_token_check($data)//¼ì²éÅäËÍÔ±tokenÊÇ·ñÊ§Ð§
{
		global $config;
		
		$expired = 1;
		$headers = panda_set_headers();
		$config['curl_url'] = $config['api_host'].'/order/list_by_employee?employeeId='.$data['dm_uid'].'&token='.$data['dm_token'];
		$config['curl_data'] = '';
		$out = panda_submit_curl('get',$headers,$config);
		if ($out)
		{
				$arr = json_decode($out,true);
				if ($arr['code'] == '102') $expired = 0;				
		}else
		{
				$expired = 0;
		}
		unset($out);
		return $expired;
}

function panda_order_list_by_employee_and_daynum($data)//ÅäËÍµÄÀúÊ·¶©µ¥
{
		global $config;
		
		$list = '';
		$headers = panda_set_headers();
		$config['curl_url'] = $config['api_host'].'/order/list_by_employee_and_daynum?employeeId='.$data['employeeId'].'&token='.$data['token'].'&dayNum='.$data['dayNum'];
		$config['curl_data'] = '';
		$out = panda_submit_curl('get',$headers,$config);
		if ($out)
		{
				$arr = json_decode($out,true);
				if ($arr['code'] == '0') $list = json_encode($arr['data']);			
		}
		unset($out);
		return $list;
}
//Joe
function panda_order_confirm_payment($data)//ÅäËÍÔ±¶©µ¥×´Ì¬¸üÐÂ
{
		global $config;
		
		$result = 0;
		$headers = panda_set_headers();

		$config['curl_url'] = $config['api_host'].'/employee/collection?id='.$data['dm_uid'].'&userId='.$data['user_id'].'&token='.$data['dm_token'].'&orderCode='.$data['order_code'].'&orderPayCode='.$data['order_pay_code'];
		
		$config['curl_data'] = '';
		unset($data);
		$out = panda_submit_curl('put',$headers,$config);		
		if ($out)
		{
				$arr = json_decode($out,true);
				if ($arr['code'] == '0' && $arr['data']) $result = 1;
		}
		unset($out);		
		return $result;
}
//End

function panda_get_payType($pay_option)//·µ»ØÖ§¸¶ÀàÐÍ
{
		$payType = '';
		switch(intval($pay_option))
		{
				case 1:
						$payType = 'RECEIVER';
				break;
				case 2:
						$payType = 'PAYPAL';//ÔÚÏßÖ§¸¶
				break;
				case 3:
						$payType = 'SENDER';//Óà¶îÖ§¸¶
				break;
		}
		return $payType;
}

function panda_get_latlng($address)
{
		global $config;
		
		$data = array();
		//¶ÔµØÖ·ÀïÃæµÄ¶ººÅ½øÐÐ´¦Àí
		$address = str_replace("£¬",",",$address);
		//Í¨¹ýµØÖ··µ»Ø¾­Î³¶ÈÐÅÏ¢
		$maps_url = "https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($address)."&key=".$config['google_map_api_key'];
		$result = file_get_contents($maps_url);
		$json = json_decode($result);
		$location = $json->results[0]->geometry->location;
		$data['lat'] = $location->lat;
		$data['lng'] = $location->lng;		
		
		return $data;
}

function ozhaha_employee_update_token($data)//¹þ¹þÍøÅäËÍÔ±token¸üÐÂ
{
		global $config;
		
		$result = 0;
		$headers = panda_set_headers();
		$config['curl_url'] = $config['ozhaha_api_requesturl'].'/source/plugin/dzapp_waimai/bischina_pandadelivery/order_api.php?ac=waimai_employee_update_token&dm_username='.$data['dm_username'].'&dm_token='.$data['dm_token'];		
		$config['curl_data'] = '';
		unset($data);
		$out = panda_submit_curl('GET',$headers,$config);		
		if ($out)
		{
				$arr = json_decode($out,true);
				if ($arr['code'] == '0' && $arr['data']) $result = 1;
		}
		unset($out);		
		return $result;
}

function ozhaha_employee_update_dispatch_status($data)//¹þ¹þÍø¶©µ¥ÅäËÍÔ±×´Ì¬¸üÐÂ
{
		global $config;
		
		$result = 0;
		$headers = panda_set_headers();
		$config['curl_url'] = $config['ozhaha_api_requesturl'].'/source/plugin/dzapp_waimai/bischina_pandadelivery/order_api.php?ac=waimai_employee_update_dispatch&dispatchStatus='.$data['dispatchStatus'].'&dm_username='.$data['dm_username'].'&panda_order_code='.$data['order_code'];		
		$config['curl_data'] = '';
		unset($data);
		$out = panda_submit_curl('GET',$headers,$config);	

			
		if ($out)
		{
				$arr = json_decode($out,true);
				if ($arr['code'] == '0' && $arr['data']) $result = 1;
		}
		unset($out);		
		return $result;
}

function ozhaha_deliver_update_status($data)//¹þ¹þÍø¶©µ¥ÅäËÍÔ±×´Ì¬¸üÐÂ
{
		global $config;
		
		$result = 0;
		$headers = panda_set_headers();
		$data['pay_code'] = isset($data['pay_code'])?$data['pay_code']:'';
		$data['done_order_time'] = isset($data['done_order_time'])?$data['done_order_time']:'';
		$data['accept_order_time'] = isset($data['accept_order_time'])?$data['accept_order_time']:'';
		$config['curl_url'] = $config['new_ozhaha_api_requesturl'].'/Pddy_api?ac=waimai_deliver_update_status&order_code='.$data['order_code'].'&status='.$data['order_status'].'&pay_code='.$data['pay_code'].'&done_order_time='.$data['done_order_time'].'&accept_order_time='.$data['accept_order_time'];
		//var_dump($config['curl_url']);		
		$config['curl_data'] = '';
		unset($data);
		$out = panda_submit_curl('GET',$headers,$config);
		//var_dump($out);
		if ($out)
		{
				$arr = json_decode($out,true);
				if ($arr['code'] == '0') $result = $out; //&& $arr['data']
		}
		unset($out);		
		return $result;
}

function ozhaha_waimai_get_order_dish_list($data)//¹þ¹þÍø¶©µ¥²Ëµ¥ÏêÏ¸»ñÈ¡
{
		global $config;
		
		$str_text = '';
		$headers = panda_set_headers();
		$config['curl_url'] = $config['ozhaha_api_requesturl'].'/source/plugin/dzapp_waimai/bischina_pandadelivery/order_api.php?ac=waimai_get_order_dish_list&order_id='.$data['order_id'];		
		$config['curl_data'] = '';
		unset($data);
		$out = panda_submit_curl('GET',$headers,$config);		
		if ($out)
		{
				$str_text = $out;
				$str_text = iconv("GBK", "UTF-8//IGNORE", $str_text);
		}
		unset($out);		
		return $str_text;
}

function ozhaha_waimai_oa_delivery_update($data)//¹þ¹þÍøÂÛÌ³´´½¨ÅäËÍÔ±ÕË»§
{
		global $config;
		
		$result = 0;
		$headers = panda_set_headers();
		$config['curl_url'] = $config['ozhaha_api_requesturl'].'/source/plugin/dzapp_waimai/bischina_pandadelivery/order_api.php?ac=waimai_oa_delivery_update&username='.$data['username'].'&password='.$data['password'].'&name='.urlencode($data['name']);
		$config['curl_data'] = '';
		unset($data);
		$out = panda_submit_curl('GET',$headers,$config);		
		if ($out)
		{
				$result = $out;
		}
		unset($out);		
		return $result;
}

function ozhaha_waimai_oa_delivery_update_status($data)//¹þ¹þÍøÅäËÍÔ±×´Ì¬¸üÐÂ
{
		global $config;
		
		$result = 0;
		$headers = panda_set_headers();
		$config['curl_url'] = $config['ozhaha_api_requesturl'].'/source/plugin/dzapp_waimai/bischina_pandadelivery/order_api.php?ac=waimai_oa_delivery_update_status&username='.$data['username'].'&status='.$data['status'].'&name='.urlencode($data['name']);
		$config['curl_data'] = '';
		unset($data);
		$out = panda_submit_curl('GET',$headers,$config);
		if ($out)
		{
				$result = $out;
		}
		unset($out);		
		return $result;
}

function page_self()
{
    $page = substr($_SERVER['PHP_SELF'],strrpos($_SERVER['PHP_SELF'],'/')+1);
    return $page;
}
?>
 