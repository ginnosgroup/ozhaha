<?php
session_start();
require 'config.inc.php';
require 'function_core.php';

$ac = $_GET['ac'];
$dm_uid = $_SESSION['dm_uid'];
$dm_username = $_SESSION['dm_username'];
$dm_token = $_SESSION['dm_token'];

$d['dm_uid'] = $dm_uid;
$d['dm_token'] = $dm_token;
if (panda_employee_token_check($d))
{
		switch($ac)
		{
				case 'modifypasswd':
					data_modifypasswd();
				break;				
		}
}else
{
		$arr = array("msg" => "expired","content" => "登录过期，请登录后再使用。");
		$result = json_encode($arr);
		exit($result);
}

function data_modifypasswd()
{
		global $dm_uid,$dm_username,$dm_token,$config;
		
		$d = $_POST;
		if ($d['passwd'])
		{
				$data['dm_uid'] = $dm_uid;
				$data['dm_username'] = $dm_username;
				$data['password'] = trim($d['passwd']);
				$data['newPassword'] = trim($d['passwd1']);
				$result = panda_employee_update_password($data);
				if ($result)
				{
						$arr = array("msg" => "ok","content" => "修改密码成功！");
				}else
				{
						$arr = array("msg" => "failed","content" => "当前的密码不正确！");		
				}				
		}else
		{
				$arr = array("msg" => "failed","content" => "请求的数据异常，请联系管理员。");
		}
		$result = json_encode($arr);
		exit($result);
}
?>