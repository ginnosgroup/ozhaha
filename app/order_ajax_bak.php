<?php
session_start();
require 'config.inc.php';
require 'function_core.php';

$ac = $_GET['ac'];
$dm_uid = $_SESSION['dm_uid'];
$dm_username = $_SESSION['dm_username'];
$dm_token = $_SESSION['dm_token'];
$dm_status = $_SESSION['dm_status'];
$order_code = $_GET['order_code'];




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
						$data['dispatchStatus'] = 'WORK';						
						$result = panda_employee_update_dispatch_status($data);				
						if ($result)
						{
								if (strpos($order_name, '哈哈网订单') !== false)
								{
										//同步更新到哈哈网订单api
										$result = ozhaha_employee_update_dispatch_status($data);

								}
								$arr = array("msg" => "ok","content" => "您抢到了这个订单啦！");
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
				$result = panda_employee_update_dispatch_status($data);
				if ($result)
				{
						if (strpos($order_name, '哈哈网订单') !== false)
						{
								//同步更新到哈哈网订单api
									$result = ozhaha_employee_update_dispatch_status($data);
								
                        }

						$arr = array("msg" => "ok","content" => "取消成功！");
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
		
		if ($order_code)
		{
				$data['dm_uid'] = $dm_uid;
				$data['dm_username'] = $dm_username;
				$data['dm_token'] = $dm_token;
				$data['order_code'] = $order_code;
				$data['dispatchStatus'] = 'FINISH';				
				$result = panda_employee_update_dispatch_status($data);
				if ($result)
				{
						if (strpos($order_name, '哈哈网订单') !== false)
						{
								//同步更新到哈哈网订单api
								$result = ozhaha_employee_update_dispatch_status($data);
						}
						$arr = array("msg" => "ok","content" => "订单送达确认成功！");
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
      //test order_code = b2ab6a49b43d40e881b257cf38c6bcf8   
      $user_id = $_GET['user_id'];
      $total_price = $_GET['total_price'];

    
      if($order_code){
                
            $data['dm_uid'] = $dm_uid;
		    $data['dm_username'] = $dm_username;
			$data['dm_token'] = $dm_token;
			$data['order_code'] = $order_code; 
            $data['total_price'] = $total_price;
            //$data['create_date'] = $create_date;
            $data['user_id'] = $user_id;
          
            $data['order_pay_code'] = "OF".$data['order_code'].$data['user_id'].intval($data['total_price']);

			 $result = panda_order_confirm_payment($data);
           if ($result){
					// if (strpos($order_name, '哈哈网订单') !== false)
					// {
					// 			//同步更新到哈哈网订单api
					// 	$result = ozhaha_employee_update_dispatch_status($data);
					// }
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

function secondsToTime($seconds) {
    $dtF = new \DateTime('@0');
    $dtT = new \DateTime("@$seconds");
    return $dtF->diff($dtT)->format('%a days, %h hours, %i minutes and %s seconds');
}
//End

?>