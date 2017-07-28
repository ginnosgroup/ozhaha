<?php
session_start();
require 'app/config.inc.php';
require 'app/function_core.php';

$data['dm_uid'] = $_SESSION['dm_uid'];
$data['dm_tokens'] = $_SESSION['dm_token'];
$result = panda_employee_logout($data);
session_unset();
session_destroy();
echo "<SCRIPT language=\"JavaScript\">window.location = \"index.php\";</SCRIPT>";
?> 
