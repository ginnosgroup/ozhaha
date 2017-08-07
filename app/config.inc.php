<?php
/*
panda delivery 接口配置信息 最后修正时间:2017-02-22 19:12
*/
date_default_timezone_set('Australia/Sydney');
$config['api_requesturl'] = 'api.pandadelivery.com.au';//panda delivery 接口Url地址
//$config['api_requesturl'] = 'dev.pandadelivery.com.au:8443';//panda delivery 测试接口Url地址
$config['api_id'] = '21';//panda delivery 接口授权id
$config['api_key'] = '1e50f868f3604a20b8a658c721fbdb35';//panda delivery 接口授权id
$config['api_host'] = 'https://'.$config['api_id'].':'.$config['api_key'].'@'.$config['api_requesturl'];
$config['api_id_admin'] = '10';//panda delivery admin接口授权id
$config['api_key_admin'] = '23902fd3b7b74fdcb5c5adef97ac2f68';//panda delivery admin接口授权id
$config['api_host_admin'] = 'https://'.$config['api_id_admin'].':'.$config['api_key_admin'].'@'.$config['api_requesturl'];
$config['ozhaha_api_requesturl'] = 'https://www.ozhaha.com';//哈哈网订单接口Url地址
$config['new_ozhaha_api_requesturl'] ='admin.ozhaha.com/selleradmin';//新哈哈网订单接口Url地址
//$config['new_ozhaha_api_requesturl'] ='admintest.ozhaha.com/selleradmin';//新哈哈网订单接口Url地址
$config['google_map_api_key'] = 'AIzaSyBptsvZaWblvXtvGpQ4NNXgGkKAcFA5tXo';//google地图api key
$config['curl_refer'] = "https://www.ozhaha.com";//curl refer页url地址
$config['curl_timeout'] = 10;//curl请求超时值
$config['dm_receive_order_limit'] = 4;//同时接单数限制值
$config['test_api_url'] = 'localhost/ci/selleradmin'
?>
 