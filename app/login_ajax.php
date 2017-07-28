<?php
session_start();
require 'config.inc.php';
require 'function_core.php';
require 'cryptojs-aes.php';
 //define('SC_PHRASE', "my secret passphrase");

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
		$salt = 'SHIFLETT';
		if ($post['username'] != '' && $post['passwd'] != '')
		{
				$data['name'] = $post['username'];
				$data['password'] = $post['passwd'];
				$dm_uid = panda_employee_login($data);
				if ($dm_uid)
				{
						if ($_SESSION['dm_status'] != 'PRE')
						{
								//同步dm_token到哈哈网
							$data['dm_username'] = $data['name'];
							$data['dm_token'] = $_SESSION['dm_token'];
							$result = ozhaha_employee_update_token($data);								
						}
						if(isset($post['rember']))
						{
							$identifier = md5($data['name']);
						 	//$p_token = md5($data['dm_token']);
						 	$cookie_password = cryptoJsAesEncrypt("my secret passphrase",$data['password']);
						 	//var_dump($cookie_password);
							setcookie('username',$data['name'], time() + (60*60*24), "/");
							//setcookie('password',addslashes($cookie_password), time() + (60*60*24), "/");
							//setcookie('auth',$identifier.'__'.$data['dm_token'], time() + (60*60*24), "/");

							$_SESSION['username'] = $data['name'];
							//$_SESSION['p_token'] = $p_token;
						}	
						//session_start();


						$arr = array("msg" => "ok","username" => $post['username'], 'pss' => json_encode($cookie_password));
				}else
				{								
						$arr = array("msg" => "failed");
				}
		}
		$result = json_encode($arr);
		exit($result);
}

// function encrypt ($payload,$key="\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0") {
//   $iv = mcrypt_create_iv(IV_SIZE, MCRYPT_DEV_URANDOM);
//   $crypt = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $payload, MCRYPT_MODE_CBC, $iv);
//   $combo = $iv . $crypt;
//   $garble = base64_encode($iv . $crypt);
//   return $garble;
// }

// function decrypt ($garble,$key="\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0") {
//   $key="\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0";
//   $combo = base64_decode($garble);
//  $iv = substr($combo, 0, IV_SIZE);
//   $crypt = substr($combo, IV_SIZE, strlen($combo));
//   $payload = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $crypt, MCRYPT_MODE_CBC, $iv);
//   return $payload;
//   //exit(json_encode($payload));
// }
?>