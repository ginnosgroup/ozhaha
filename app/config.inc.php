<?php
/*
panda delivery �ӿ�������Ϣ �������ʱ��:2017-02-22 19:12
*/
date_default_timezone_set('Australia/Sydney');
$config['api_requesturl'] = 'api.pandadelivery.com.au';//panda delivery �ӿ�Url��ַ
//$config['api_requesturl'] = 'dev.pandadelivery.com.au:8443';//panda delivery ���Խӿ�Url��ַ
$config['api_id'] = '21';//panda delivery �ӿ���Ȩid
$config['api_key'] = '1e50f868f3604a20b8a658c721fbdb35';//panda delivery �ӿ���Ȩid
$config['api_host'] = 'https://'.$config['api_id'].':'.$config['api_key'].'@'.$config['api_requesturl'];
$config['api_id_admin'] = '10';//panda delivery admin�ӿ���Ȩid
$config['api_key_admin'] = '23902fd3b7b74fdcb5c5adef97ac2f68';//panda delivery admin�ӿ���Ȩid
$config['api_host_admin'] = 'https://'.$config['api_id_admin'].':'.$config['api_key_admin'].'@'.$config['api_requesturl'];
$config['ozhaha_api_requesturl'] = 'https://www.ozhaha.com';//�����������ӿ�Url��ַ
$config['new_ozhaha_api_requesturl'] ='admin.ozhaha.com/selleradmin';//�¹����������ӿ�Url��ַ
//$config['new_ozhaha_api_requesturl'] ='admintest.ozhaha.com/selleradmin';//�¹����������ӿ�Url��ַ
$config['google_map_api_key'] = 'AIzaSyBptsvZaWblvXtvGpQ4NNXgGkKAcFA5tXo';//google��ͼapi key
$config['curl_refer'] = "https://www.ozhaha.com";//curl referҳurl��ַ
$config['curl_timeout'] = 10;//curl����ʱֵ
$config['dm_receive_order_limit'] = 4;//ͬʱ�ӵ�������ֵ
$config['test_api_url'] = 'localhost/ci/selleradmin'
?>
 