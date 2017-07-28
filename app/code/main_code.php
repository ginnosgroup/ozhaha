<?php
session_start();
require_once 'app/config.inc.php';
require_once 'app/function_core.php';

require_once "weixin_sdk/config.inc.php";
require_once "weixin_sdk/jssdk.php";
$jssdk = new JSSDK($weixin['appid'], $weixin['appsecret']);
$signPackage = $jssdk->GetSignPackage();

if (!$_SESSION['dm_uid']) header("Location:index.php");
if ($_SESSION['dm_status'] == 'PRE') header("Location:message.php?id=1");
?>
 