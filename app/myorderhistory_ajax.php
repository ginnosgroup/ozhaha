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
		global $dm_uid,$dm_token;
		
		$d = $_GET;
		if ($dm_uid)
		{
				$data['employeeId'] = $dm_uid;
				$data['token'] = $dm_token;
				$data['dayNum'] = intval($_GET['day']);
				$str_orderlist = panda_order_list_by_employee_and_daynum($data);
				if ($str_orderlist)
				{
						$orderlist = json_decode($str_orderlist,true);
						array_multisort($orderlist,SORT_DESC);						
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