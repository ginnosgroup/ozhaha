<?php
session_start();
require 'config.inc.php';
require 'function_core.php';
require 'file_cache.php';

define('CACHE_SAVING_TIME',102000, true);
$cache = new FileCache();
$ac = $_GET['ac'];
$dm_uid = $_SESSION['dm_uid'];
$dm_username = $_SESSION['dm_username'];
$dm_token = $_SESSION['dm_token'];
$dm_status = $_SESSION['dm_status'];
$order_code = isset($_GET['order_code'])?$_GET['order_code']:'';

$d['dm_uid'] = $dm_uid;
$d['dm_token'] = $dm_token;
if (panda_employee_token_check($d) && $dm_status == 'ENABLED')
{
		switch($ac)
		{
				case 'receive':
					data_receive();
				break;
				case 'cancel':
					data_cancel();
				break;
				case 'done':
					data_done();
				break;
				case 'confirmPay':
				    payment_done();
				break;
				case 'confirmPickup':
					confirm_pickup();
					break;

		}
}else
{
		$arr = array("msg" => "expired","content" => "登录过期，请登录后再使用。");
		$result = json_encode($arr);
		exit($result);
}

function data_receive()
{
		global $dm_uid,$dm_username,$dm_token,$config,$order_code,$order_name;
		date_default_timezone_set('Australia/Sydney');
		$d = $_GET;
		if ($order_code)
		{
				//$number = panda_employee_order_count($data);//查询配送员当前正在配送的订单数量
				$number = 0;//测试值
				if ($number < $config['dm_receive_order_limit'])
				{
						$data['dm_uid'] = $dm_uid;
						$data['dm_username'] = $dm_username;
						$data['dm_token'] = $dm_token;
						$data['order_code'] = $order_code;
						$data['dispatchStatus'] = 'MOVE';
						$data['order_status'] = 'WAIT';
						$data['accept_order_time'] = date("YmdHis");
						$order_name = $_GET['name'];
						$sync = '';
						$sync_content='';					
						$result = panda_employee_update_dispatch_status($data);	
						//joe on 21/07/2017
						// if($result)
						// {
						// 	//$cache->store($data['order_code'],$data['dispatchStatus'], CACHE_SAVING_TIME);

						// }
						//end		
						if ($result)
						{
								if (strpos($order_name, '哈哈网订单') !== false)
								{
									//同步更新到哈哈网订单api
									//joe
									$sync_content = ozhaha_deliver_update_status($data);
									if($sync_content) $sync = 1;
									else $sync = 0;


								}
								$arr = array("msg" => "ok","content" => "您抢到了这个订单啦！","sync" => $sync,"sync_content" =>$sync_content, "result" => $result);
								//end
						}else
						{
								$arr = array("msg" => "failed","content" => "订单已被其他配送员抢走啦！");								
						}	
				}else
				{						
						$arr = array("msg" => "failed","content" => "您当前正在配送的订单过多,不能抢单!");
				}
		}else
		{
				$arr = array("msg" => "failed","content" => "请求的数据异常，请联系管理员。");
		}
		$result = json_encode($arr);
		exit($result);
}

function data_cancel()
{
		global $dm_uid,$dm_username,$dm_token,$config,$order_code,$order_name;
		
		if ($order_code)
		{
				$data['dm_uid'] = $dm_uid;
				$data['dm_username'] = $dm_username;
				$data['dm_token'] = $dm_token;
				$data['order_code'] = $order_code;
				$data['dispatchStatus'] = 'WAIT';
				$data['order_status'] = 'WAIT';
				$order_name = $_GET['name'];
				$sync = 2;
				$sync_content='';
				//order_code for testing  1bfc2300143d4cfeb65dd638e13dac21 

				$result = panda_employee_update_dispatch_status($data);
				//$result =1;
				if ($result)
				{
						if (strpos($order_name, '哈哈网订单') !== false)
						{
								//同步更新到哈哈网订单api
							   //$result = ozhaha_employee_update_dispatch_status($data);
							   //$data['order_code'] = '62aa9f06106f44a2925de4aedbd5cd5b';
							   $sync_content = ozhaha_deliver_update_status($data);
							   //var_dump($result_sync);
							   if($sync_content) $sync = 1;
							   else $sync = 0;
							   // {$arr = array("msg" => "ok","content" => "取消成功！");}
							   // else{$arr = array("msg" => "ok","content" => "取消成功！");}
						}

						$arr = array("msg" => "ok","content" => "取消成功！", 'sync' => $sync,'sync_content' => $sync_content );
				}else
				{
						$arr = array("msg" => "failed","content" => "取消失败！请联系管理员。");
				}
		}else
		{		
				$arr = array("msg" => "failed","content" => "请求的数据异常，请联系管理员。");
		}
		$result = json_encode($arr);
		exit($result);
}

function data_done()
{
		global $dm_uid,$dm_username,$dm_token,$config,$order_code,$order_name;
		date_default_timezone_set('Australia/Sydney');
		if ($order_code)
		{
				$data['dm_uid'] = $dm_uid;
				$data['dm_username'] = $dm_username;
				$data['dm_token'] = $dm_token;
				$data['order_code'] = $order_code;
				$data['done_order_time'] = date("YmdHis");
				$data['pay_code'] = isset($_GET['pay_code'])?$_GET['pay_code']:'noCode';
				$data['dispatchStatus'] = 'FINISH';	
				$data['order_status'] = 'DONE';
				$order_name = $_GET['name'];
				$sync = 2;
				$sync_content='';

				$result = panda_employee_update_dispatch_status($data);
				if ($result)
				{
						if (strpos($order_name, '哈哈网订单') !== false)
						{
								//同步更新到哈哈网订单api
							$sync_content = ozhaha_deliver_update_status($data);
							if($sync_content) $sync = 1;
							else $sync = 0;
						}
						$arr = array("msg" => "ok","content" => "订单送达确认成功！",'sync' => $sync,'sync_content' =>$sync_content);
				}else
				{
						$arr = array("msg" => "failed","content" => "送达确认失败！请联系管理员。");
				}
		}else
		{		
				$arr = array("msg" => "failed","content" => "请求的数据异常，请联系管理员。");
		}	
		$result = json_encode($arr);
		exit($result);
}
//Joe
function payment_done()
{
  global $dm_uid,$dm_username,$dm_token,$config,$order_code,$order_name;
 
      $total_price = str_replace(".",'d',$_GET['total_price']);
      $actual_pay = str_replace(".",'d',$_GET['actual_pay']);
      $note = $_GET['note'];

      if($order_code){
            $data['dm_uid'] = $dm_uid;
		    $data['dm_username'] = $dm_username;
			$data['dm_token'] = $dm_token;
			$data['order_code'] = $order_code; 
            $data['total_price'] = $total_price;
            $data['actual_pay'] = $actual_pay;
            $data['user_id'] = $_GET['user_id'];
            $data['order_pay_code'] = "OF"."/P".$data['total_price']."/AP".$data['actual_pay'].'/N'.$note;
     		$result = panda_order_confirm_payment($data);
           if ($result){
				
					$arr = array("msg" => "ok","content" => "订单送达确认成功！请按 “确认送达” 按钮完成订单");
				}
		   else
				{
					$arr = array("msg" => "failed","content" => "送达确认失败！请联系管理员。");
				}
            $result = json_encode($arr);
            }
            exit($result);
}

function confirm_pickup(){

	global $dm_uid,$dm_token,$config,$cache;
	$data['dm_uid'] = $dm_uid;
	$data['dm_token'] = $dm_token;
	$data['order_code'] = $_POST['order_code'];
	$data['prev_memo'] = $_POST['prev_memo'];
	$data['dispatchStatus'] = 'WORK';
	$data['order_status'] = 'DELIVERY';
	$sync = '';
	$sync_content='';
	$actual_pay = '';
	$memo_update = '';
	if(!empty($_POST['actual_pay'])) $actual_pay = $_POST['actual_pay'];
	if(!empty($actual_pay))
	{
		$data['memo'] = get_new_memo($data['prev_memo'],$actual_pay);
		$memo_update = update_order_memo($data);
		$data['memo_update'] = $memo_update;
	}
	$result = panda_employee_update_dispatch_status($data);
	if($result)
	{
		$cache_result = $cache->store($data['order_code'],$data['dispatchStatus'], CACHE_SAVING_TIME);
		//joe
		$sync_content = ozhaha_deliver_update_status($data);
		if($sync_content) $sync = 1;
		else $sync = 0;

	}
	if ($result&&$sync)
	{
		$arr = array("msg" => "ok","result" => 'R='.$result.'&SR='.$sync.'&CR='.$cache_result, 'content'=>$data);
	}
	elseif($result||$sync)
	{						
		$arr = array("msg" => "ok", 'result' => 'R='.$result.'&SR='.$sync.'&CR='.$cache_result,'content'=>$data);
	}
	else 
	{
		$arr = array("msg" => "failed",'result' => 'R='.$result.'&SR='.$sync.'&CR='.$cache_result, 'content'=>$data);
	}
	exit(json_encode($arr));

}


function secondsToTime($seconds) {
    $dtF = new \DateTime('@0');
    $dtT = new \DateTime("@$seconds");
    return $dtF->diff($dtT)->format('%a days, %h hours, %i minutes and %s seconds');
}



function get_new_memo($curr_memo,$actual_pay)
{
	$s ='';
	$pos = strpos($curr_memo,'SHOP');
	if($pos === false)
		{
			$s = $curr_memo.';PAY2SHOP:'.$actual_pay.';';
		}
	else{
		   $s = substr($curr_memo,0,strpos($curr_memo,'SHOP')+5).$actual_pay.';';
		} 

	return $s;

}


//End

?>