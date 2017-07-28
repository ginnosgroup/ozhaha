<?php
session_start();
require 'config.inc.php';
require 'function_core.php';

$ac = $_GET['ac'];
$dm_uid = $_SESSION['dm_uid'];
$dm_token = $_SESSION['dm_token'];
$dm_status = $_SESSION['dm_status'];

$d['dm_uid'] = $dm_uid;
$d['dm_token'] = $dm_token;
if (panda_employee_token_check($d) && $dm_status == 'ENABLED')
{
		switch($ac)
		{
				case 'update':					
					data_update();
				break;
		}
}else
{
		$arr = array("msg" => "expired","content" => "登录过期，请登录后再使用。");
		$result = json_encode($arr);
		exit($result);
}

function data_update()
{
		global $dm_uid;
		
		$d = $_GET;
		$_SESSION['dm_currlat'] = '-33.8726559';
		$_SESSION['dm_currlng'] = '151.20442730000002';
		if ($_SESSION['dm_currlat'] && $_SESSION['dm_currlng'])
		{
				$data['longitude'] = $_SESSION['dm_currlng'];
				$data['latitude'] = $_SESSION['dm_currlat'];
				//-33.8726559,151.20442730000002
				$data['distance'] = 10;//搜索范围
				$str_orderlist = panda_order_list_by_distance($data);
				if ($str_orderlist)
				{
						$orderlist = json_decode($str_orderlist,true);
						foreach($orderlist as $order)
						{
							$create_days[] = $order['createDate'];
						}
						//SORT_ASC
						array_multisort($create_days,SORT_DESC,SORT_NUMERIC,$orderlist);
						//array_multisort($orderlist,SORT_DESC, SORT_NUMERIC);
						$str_orderlist = json_encode($orderlist);
						$arr = array("msg" => "ok","content" => $str_orderlist);
				}else
				{						
						$arr = array("msg" => "failed");
				}
		}else
		{
				$arr = array("msg" => "failed");
		}
		$result = json_encode($arr);
		exit($result);
}
?>