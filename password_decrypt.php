<?php 
define('IV_SIZE', mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC));
$pw = $_GET['password'];
//$password = $_COOKIE['']
exit(decrypt($pss));

function decrypt ($garble,$key="\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0") {
  $key="\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0";
  $combo = base64_decode($garble);
 $iv = substr($combo, 0, IV_SIZE);
  $crypt = substr($combo, IV_SIZE, strlen($combo));
  $payload = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $crypt, MCRYPT_MODE_CBC, $iv);
  return $payload;
  //exit(json_encode($payload));
}

?>