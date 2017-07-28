<?php
session_start();
require 'config.inc.php';
require 'function_core.php';
require 'file_cache.php';
// set cache expire time . with 1 standing for  1s;
define('CACHE_SAVING_TIME',2*60*60, true);

$cache = new FileCache();	
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
				$str_orderlist = panda_order_list_by_employee($data);
				if ($str_orderlist)
				{
						$orderlist = json_decode($str_orderlist,true);
						$order_work_list = order_work_list($orderlist);
						array_multisort($order_work_list,SORT_DESC);
						/*
						foreach($orderlist as $key => $val)
						{
								$order_name = $orderlist[$key]['name'];
								if (strpos($order_name, '哈哈网订单') !== false)
								{
										$arr = explode('-',$order_name);
										$arr1 = explode(':',$arr[0]);
										$data['order_id'] = $arr1[1];
										$orderlist[$key]['ozhaha_orderid'] = $data['order_id'];
										//$orderlist[$key]['memo'] = ozhaha_waimai_get_order_dish_list($data);
								}
						}*/
						//$str_orderlist = json_encode($orderlist);
						$str_orderlist = json_encode($order_work_list);
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

function order_work_list($list)
{
	global $cache;
	$out =array();
	if($list)
	{
		foreach($list as $item)
		{
			if($cache->fetch($item['code']))
			{
				//if($cache->fetch($item['code'])=='WORK')
				$out[] = $item;
				//$out[] ='haha';
			}
		}
	}
	return $out;

}
?>