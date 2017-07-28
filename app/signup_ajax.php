<?php
session_start();
require 'config.inc.php';
require 'function_core.php';

$ac = $_GET['ac'];

switch($ac)
{
		case 'post':
			data_submit();
		break;
}

function data_submit()
{
		$post = $_POST;
		
		if ($post['username'] != '' && $post['passwd'] != '' && $post['realname'] !='' && $post['sex'] !='' && $post['phone'] !='' && $post['numberType'] !='' && $post['number'] !='')
		{
				$data = $post;
				$data['name'] = $post['username'];
				$data['password'] = $post['passwd'];
				$data['status'] = 'PRE';
				$data['realnamePinyin'] = '';
				$data['logo'] = '';
				$data['level'] = '0';
				$dm_uid = panda_employee_add($data);
				//$arr = array("msg" => "failed","content" => $dm_uid);
				//$result = json_encode($arr);
				//exit($result);
				if(isset($post['rember']))
				{
				$identifier = md5($data['name']);
							//$p_token = md5($data['password']);
				setcookie('username',$data['name'], time() + (60*60*24), "/");
				setcookie('auth',$identifier.'__'.$data['dm_token'], time() + (60*60*24), "/");
				$_SESSION['username'] = $data['name'];
				}
				
				if ($dm_uid)
				{						
						$arr = array("msg" => "ok","username" => $post['username']);
				}else
				{								
						$arr = array("msg" => "failed","content" => "注册失败！用户名可能被占用，请换一个试试。");
				}
		}else
		{
				$arr = array("msg" => "failed","content" => "部分数据为空，请完善后再次提交。");
		}
		$result = json_encode($arr);
		exit($result);
}
?>