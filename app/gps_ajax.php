<?php
session_start();
require 'config.inc.php';
require 'function_core.php';

$ac = $_GET['ac'];
$dm_uid = $_SESSION['dm_uid'];
$dm_token = $_SESSION['dm_token'];

$d['dm_uid'] = $dm_uid;
$d['dm_token'] = $dm_token;
if (panda_employee_token_check($d))
{
		switch($ac)
		{
				case 'update':
					data_update();
				break;
		}
}/*else
{
		$arr = array("msg" => "expired","content" => "登录过期，请登录后再使用。");
		$result = json_encode($arr);
		exit($result);
}*/

function data_update()
{
		global $dm_uid;
		
		$d = $_GET;
		//if ($d['latlng'])
		if($d)
		{
				//$arr = json_decode($d['latlng'],true);
				//if ($d['latlng'])
			    if($d['latitude']&&$d['longitude']&&$d['accuracy'])
				{
						// $lat = $arr['latitude'];
						// $lng = $arr['longitude'];
						// $accuracy = $arr['accuracy'];
						$lat = $d['latitude'];
						$lng = $d['longitude'];
						$accuracy = $d['accuracy'];
						$_SESSION['dm_currlat'] = $lat;
						$_SESSION['dm_currlng'] = $lng;
						$data['dm_uid'] = $dm_uid;
						$data['longitude'] = $lng;
						$data['latitude'] = $lat;
						$data['address'] = 'unknown';
						$result = panda_employee_update_place($data);
						if ($result)
						{
								//上报gps成功
								$arr = array("msg" => "ok");
						}else
						{
								$arr = array("msg" => "failed");
						}
				}else
				{						
						$arr = array("msg" => "failed");
				}
		}
		$result = json_encode($arr);
		exit($result);
}
?>