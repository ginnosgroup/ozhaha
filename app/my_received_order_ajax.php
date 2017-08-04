<?php
session_start();

require 'config.inc.php';
require 'function_core.php';
require 'file_cache.php';
// set cache expire time . with 1 standing for  1s;
define('CACHE_SAVING_TIME',2*60*60, true);

define('HTRY_PAGE_CACHE_TIME',20*60, true);

$cache = new FileCache();	
$ac = $_GET['ac'];
$dm_uid = $_SESSION['dm_uid'];

$cache->store(($dm_uid.'history_page'),'my_received_order.php',HTRY_PAGE_CACHE_TIME);

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
	global $dm_uid,$dm_token,$cache;
		
		$d = $_GET;
		if ($dm_uid)
		{
				$data['employeeId'] = $dm_uid;
				$data['token'] = $dm_token;
				$str_orderlist = panda_order_list_by_employee($data);
				if($str_orderlist)
				{
					$order_move_list = order_move_list(json_decode($str_orderlist,true));
					//$order_move_list = json_decode($str_orderlist,true);
					array_multisort($order_move_list,SORT_DESC);
					$arr = array("msg" => "ok","content" => json_encode($order_move_list));
				}	
				else
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

function order_move_list($list)
{
	global $cache;
	//print_r($list);
	$out =array();
	if($list)
	{
		foreach($list as $item)
		{
			if($cache->fetch($item['code']))
			{
				if($cache->fetch($item['code']) != 'WORK')
					$out[] = $item;
			}
			else 
			{
				$out[] = $item;
			}
		}
	}
	return $out;

}


?>